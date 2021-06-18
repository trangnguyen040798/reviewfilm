<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Country\CountryRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
	public function __construct(CountryRepositoryInterface $countryRepoInter)
	{
		$this->countryRepoInter = $countryRepoInter;
	}

    public function index()
    {
    	$data = $this->countryRepoInter->all();

        return view('admin.country.country', ['data' => $data]);
    }

    public function create(Request $request)
    {
    	$data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $rules = [
            'title' => 'required',
            'slug' => 'unique:countries'
        ];
        $messages = [
            'title.required' => 'Mời bạn nhập tên quốc gia',
            'slug.unique' => 'Slug đã tồn tại'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        } 
        $country = $this->countryRepoInter->create($data);

        return response()->json(['success' => 'Thêm mới thành công', 'data' => $country]);
    }

    public function delete($id)
    {
        $result = $this->countryRepoInter->delete($id);

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function detail($id)
    {
        $data = $this->countryRepoInter->find($id);

        return $data;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $rules = [
            'title' => 'required',
            'slug' => 'unique:countries,slug, ' . $data['id']
        ];
        $messages = [
            'title.required' => 'Mời bạn nhập tên quốc gia',
            'slug.unique' => 'Slug đã tồn tại'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        } 
        $this->countryRepoInter->update($data['id'], $data);
        $country = $this->countryRepoInter->find($data['id']);

        return response()->json(['error' => false, 'success' => 'Sửa thành công', 'data' => $country]);
    }

    public function multiDelete(Request $request)
    {
        $listIds = $request->listids;
        foreach ($listIds as $key => $value) {
            $result = $this->countryRepoInter->delete($value);
        }

        return response()->json(['success' => 'Xóa thành công']);
    }
}
