<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;
use Socialite;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'email' => 'required|email|max:191|unique:users',
            'name' => 'required|max:191',
            'password' => 'required|min:6|max:15',
            'rpassword' => 'required|same:password',
        );
        $messages = array(
            'email.required' => __('message.Validate_email_required'),
            'email.email' => __('message.Validate_email'),
            'email.max' => __('message.Validate_max') . ' :max ' . __('message.Validate_character'),
            'email.unique' => __('message.Email_unique'),
            'name.required' => __('message.Validate_full_name_required'),
            'name.max' => __('message.Validate_max') . ' :max ' . __('message.Validate_character'),
            'password.required' => __('message.Validate_password_required'),
            'password.min' => __('message.Validate_min') . ' :min ' . __('message.Validate_character'),
            'password.max' => __('message.Validate_max') . ' :max ' . __('message.Validate_character'),
            'password.same' => __('message.Validate_password_same'),
            'rpassword.required' => __('message.Validate_password_confirmation_required'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }
        $data['password'] = Hash::make($request->password);
        $data['api_token'] = Hash::make(Str::random(60));
        $user = User::create($data);

        return redirect()->route('client.index')->with('success', 'Đăng ký thành công');
    }

    public function register_form()
    {
        if (Auth::check() || Cookie::get('remember_token')) {
            return redirect()->back();
        }

        return view('auth.register');
    }

    public function authenticate(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'email' => 'required|email|max:191',
            'password' => 'required|min:8|max:15',
        );
        $messages = array(
            'password.required' => 'Mời bạn nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất :min kí tự trở lên.',
            'password.max' => 'Vui lòng không nhập mật khẩu quá :max kí tự.',
            'email.required' => 'Mời bạn nhập mail',
            'email.email' => 'Không đúng định dạng mail',
            'email.max' => 'Vui lòng không nhập quá :max kí tự'
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages())->with('data', $data);
        }
        if (Auth::attempt(['email' => $request->email , 'password' => $request->password])) {
            $user = Auth::user();
            $user->api_token = Hash::make(Str::random(60));
            $user->save();
            if ($user['role'] != config('admin.default_role')) {
                return redirect()->back()->with('success', 'Đăng nhập thành công');;
            } else {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công');
            }
        } else {
            return redirect()->back()->with('error', 'Đăng nhập thất bại')->with('data', $data);;
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // Cookie::forget('remember_token');

        return redirect()->route('client.index');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $getInfo = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('client.index');
        }
        $user = $this->createUser($getInfo,$provider); 
        auth()->login($user); 
        return redirect()->route('client.account.index');
    }

    public function createUser($getInfo,$provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        $api_token = Hash::make(Str::random(60));
        if (!$user) {
            if ($provider == 'google') {
                $name = $getInfo->getName();
                $email = $getInfo->getEmail();
                $provider_id = $getInfo->getId();
            } else {
                $name = $getInfo->name;
                $email = $getInfo->email;
                $provider_id = $getInfo->id;
            }
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
                'api_token' => $api_token,
            ]);
        }
        return $user;
    }

    public function mailForm()
    {
        return view('client.mail-form');
    }

    public function sendMail(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'email' => 'required|email|max:191',
        );
        $messages = array(
            'email.required' => 'Mời bạn nhập mail',
            'email.email' => 'Không đúng định dạng mail',
            'email.max' => 'Vui lòng không nhập quá :max kí tự'
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages())->with('email', $data['email']);
        }
        $user = User::where('email', $data['email'])->first();
        if (!empty($user)) {
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $data['email'],
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }

            return redirect()->back()->with('success', 'Mời bạn kiểm tra mail để cài đặt lại mật khẩu')->with('email', $data['email']);
        } else {

            return redirect()->back()->with('error', 'Email chưa tồn tại.')->with('email', $data['email']);
        }
    }

    public function reset(Request $request, $token)
    {
        $data = $request->all();
        $rules = array(
            'password' => 'required|min:8',
        );
        $messages = array(
            'password.required' => 'Mời bạn nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất :min kí tự trở lên.',
            'password.max' => 'Vui lòng không nhập mật khẩu quá :max kí tự.'
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages());
        }
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(10)->isPast()) {
            $passwordReset->delete();

            return response()->back()->with('error', 'Link cài đặt mật khẩu của bạn bị sai');
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $updatePasswordUser = $user->update(['password' => Hash::make($request->password)]);
        $passwordReset->delete();
       
        return redirect()->route('client.index')->with('success', 'Đổi mật khẩu thành công');
    }

    public function resetForm($token)
    {
        return view('client.resetpassword-form', ['token' => $token]);
    }
}
