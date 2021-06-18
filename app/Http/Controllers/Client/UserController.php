<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\User\UserRepositoryInterface;
use App\Repositories\Admin\Film\FilmRepositoryInterface;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Hash;
use App\Repositories\Admin\SavedVideo\SavedVideoRepositoryInterface;

class UserController extends Controller
{
    public $paginateFilms = 12;

	public function __construct(
        UserRepositoryInterface $userRepoInter,
        FilmRepositoryInterface $filmRepoInter,
        SavedVideoRepositoryInterface $savedVideoRepoInter
    )
	{
		$this->userRepoInter = $userRepoInter;
        $this->filmRepoInter = $filmRepoInter;
        $this->savedVideoRepoInter = $savedVideoRepoInter;
	}

    public function index()
    {
    	$user = Auth::user();
        $user['thumbnail'] = is_null($user['thumbnail']) ? asset('') . config('admin.no-image') : asset('') . config('admin.default_folder_image') . $user['thumbnail'];
        $user['image'] = is_null($user['image']) ? asset('') . config('admin.no-image') : asset('') . config('admin.default_folder_image') . $user['image'];
        $films = $this->filmRepoInter->wherePaginate('user_id', $user->id, $this->paginateFilms);
        foreach ($films as $key => $film) {
            if ($film['image'] == null) {
                $films[$key]['image'] = asset('') . config('admin.no-image');
            } else {
                $films[$key]['image'] = asset('') . config('admin.default_folder_image') . $film['image'];
            }
        }
        $listSavedVideo = $this->savedVideoRepoInter->getListSV();
        $listTypes = $this->filmRepoInter::LIST_TYPE;

        return view('client.account', ['user' => $user, 'films' => $films, 'listSavedVideo' => $listSavedVideo, 'listTypes' => $listTypes]);
    }

    public function uploadImage(Request $request)
    {
        $data = $request->all();
        $rules = [
            'image' => 'required'
        ];
        $messages = [
            'image.required' => 'Mời nhập chọn ảnh'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }
        $data['image'] = uploadFile(config('admin.default_folder_image'), $data['image']);
        $result = $this->userRepoInter->update(Auth::user()->id, $data);
        if ($result) {
            return response()->json(['success' => true, 'messgae' => 'Cập nhật ảnh đại diện thành công.', 'image' => asset('') . config('admin.default_folder_image') . $data['image']]);
        } else {
            return response()->json(['error' => true, 'messgae' => 'Cập nhật ảnh đại diện thất bại.']);
        }
    }

    public function uploadThumbnail(Request $request)
    {
        $data = $request->all();
        $rules = [
            'thumbnail' => 'required'
        ];
        $messages = [
            'thumbnail.required' => 'Mời nhập chọn ảnh'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }
        $data['thumbnail'] = uploadFile(config('admin.default_folder_image'), $data['thumbnail']);
        $result = $this->userRepoInter->update(Auth::user()->id, $data);
        if ($result) {
            return response()->json(['success' => true, 'messgae' => 'Cập nhật ảnh bìa thành công.', 'thumbnail' => asset('') . config('admin.default_folder_image') . $data['thumbnail']]);
        } else {
            return response()->json(['error' => true, 'messgae' => 'Cập nhật ảnh bìa thất bại.']);
        }
    }

    public function edit()
    {
        $user = Auth::user();

        return view('client.edit-account', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $rules = [
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'Mời nhập tên tài khoản',
            'email.email' => 'Email không đúng định dạng',
            'email.required' => 'Mời nhập email',
            'email.unique' => 'Email đã tồn tại'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }
        $result = $this->userRepoInter->update($user->id, $data);
        if ($result) {
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
        } else {
            return response()->json(['error' => true, 'message' => 'Cập nhật thất bại.']);
        }
    }
}
