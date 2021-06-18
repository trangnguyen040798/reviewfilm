<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Cookie;

class UserController extends Controller
{
	public function __construct(UserRepositoryInterface $userRepoInter)
	{
		$this->userRepoInter = $userRepoInter;
	}

    public function index()
    {
    	$data = $this->userRepoInter->where('role', 'customer');
        foreach ($data as $key => $value) {
            if ($value['image'] == null) {
                $data[$key]['image'] = config('admin.no-image');
            } else {
                $data[$key]['image'] = config('admin.default_folder_image') . $data[$key]['image'];
            }
        }

        return view('admin.user.user', ['data' => $data]);
    }

    public function create(Request $request)
    {
    	$data = $request->all();
        $data['password'] = Hash::make(config('admin.default_password'));
        $rules = [
            'email' => 'unique:users'
        ];
        $messages = [
            'email.unique' => 'Email đã tồn tại'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }
        if (isset($data['input-b1'])) {
            $data['image'] = uploadFile(config('admin.default_folder_image'), $data['input-b1']);
        }
        $user = $this->userRepoInter->create($data);
        if ($user['image'] == null) {
            $user['image'] = asset('') . config('admin.no-image');
        } else {
            $user['image'] = asset('') . config('admin.default_folder_image') . $user['image'];
        }

        return response()->json(['error' => false, 'success' => 'Thêm mới thành công', 'data' => $user]);
    }

    public function delete($id)
    {
        $result = $this->userRepoInter->delete($id);

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function detail($id)
    {
        $data = $this->userRepoInter->find($id);
        if ($data['image'] == null) {
            $data['image'] = asset('') . config('admin.no-image');
        } else {
            $data['image'] = asset('') . config('admin.default_folder_image') . $data['image'];
        }

        return $data;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'unique:users,email,'.$data['id'],
        ];
        $messages = [
            'email.unique' => 'Email đã tồn tại'
        ];
        if (isset($data['input-repl-1a'])) {
            $data['image'] = uploadFile(config('admin.default_folder_image'), $data['input-repl-1a']);
        }
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }
        $user = $this->userRepoInter->update($data['id'], $data);
        $user = $this->userRepoInter->find($data['id']);
        if ($user['image'] == null) {
            $user['image'] = config('admin.no-image');
        } else {
            $user['image'] = config('admin.default_folder_image') . $user['image'];
        }

        return response()->json(['error' => false, 'success' => 'Sửa thành công', 'data' => $user]);
    }

    public function multiDelete(Request $request)
    {
        $listIds = $request->listids;
        foreach ($listIds as $key => $value) {
            $result = $this->userRepoInter->delete($value);
        }

        return response()->json(['success' => 'Xóa thành công']);
    }
}
