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

        return redirect()->route('client.index')->with('success', '????ng k?? th??nh c??ng');
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
            'password.required' => 'M???i b???n nh???p m???t kh???u',
            'password.min' => 'M???t kh???u ph???i c?? ??t nh???t :min k?? t??? tr??? l??n.',
            'password.max' => 'Vui l??ng kh??ng nh???p m???t kh???u qu?? :max k?? t???.',
            'email.required' => 'M???i b???n nh???p mail',
            'email.email' => 'Kh??ng ????ng ?????nh d???ng mail',
            'email.max' => 'Vui l??ng kh??ng nh???p qu?? :max k?? t???'
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
                return redirect()->back()->with('success', '????ng nh???p th??nh c??ng');;
            } else {
                return redirect()->route('admin.dashboard')->with('success', '????ng nh???p th??nh c??ng');
            }
        } else {
            return redirect()->back()->with('error', '????ng nh???p th???t b???i')->with('data', $data);;
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
            'email.required' => 'M???i b???n nh???p mail',
            'email.email' => 'Kh??ng ????ng ?????nh d???ng mail',
            'email.max' => 'Vui l??ng kh??ng nh???p qu?? :max k?? t???'
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

            return redirect()->back()->with('success', 'M???i b???n ki???m tra mail ????? c??i ?????t l???i m???t kh???u')->with('email', $data['email']);
        } else {

            return redirect()->back()->with('error', 'Email ch??a t???n t???i.')->with('email', $data['email']);
        }
    }

    public function reset(Request $request, $token)
    {
        $data = $request->all();
        $rules = array(
            'password' => 'required|min:8',
        );
        $messages = array(
            'password.required' => 'M???i b???n nh???p m???t kh???u',
            'password.min' => 'M???t kh???u ph???i c?? ??t nh???t :min k?? t??? tr??? l??n.',
            'password.max' => 'Vui l??ng kh??ng nh???p m???t kh???u qu?? :max k?? t???.'
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages());
        }
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(10)->isPast()) {
            $passwordReset->delete();

            return response()->back()->with('error', 'Link c??i ?????t m???t kh???u c???a b???n b??? sai');
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $updatePasswordUser = $user->update(['password' => Hash::make($request->password)]);
        $passwordReset->delete();
       
        return redirect()->route('client.index')->with('success', '?????i m???t kh???u th??nh c??ng');
    }

    public function resetForm($token)
    {
        return view('client.resetpassword-form', ['token' => $token]);
    }
}
