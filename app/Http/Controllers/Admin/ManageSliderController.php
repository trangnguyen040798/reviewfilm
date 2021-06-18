<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\ManageSlider\ManageSliderRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Validator;

class ManageSliderController extends Controller
{
	public function __construct(ManageSliderRepositoryInterface $manageSliderRepoInter)
	{
		$this->manageSliderRepoInter = $manageSliderRepoInter;
        $this->path_image = config('admin.default_folder_image');
    }

    public function index()
    {
    	$data1 = $this->manageSliderRepoInter->where('tag', $this->manageSliderRepoInter::slider_1);
        foreach ($data1 as $key => $value) {
            $data1[$key]['image'] = asset('') . $this->path_image . $value['image'];
        }
        $data2 = $this->manageSliderRepoInter->with(['film' => function($q) {
            $q->join('users', 'films.user_id', '=', 'users.id')
            ->select(['users.name AS user_name', 'films.name', 'films.id']);
        }])->where('tag', $this->manageSliderRepoInter::slider_2)->get();
        $listSliders = $this->manageSliderRepoInter::LIST_TAG;

        return view('admin.manage-slider.manage-slider', ['data1' => $data1, 'data2' => $data2, 'listSliders' => $listSliders]);
    }

    public function create(Request $request)
    {
    	$data = $request->all();
        if ($data['tag'] == $this->manageSliderRepoInter::slider_1) {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'input-b1' => 'required'
            ];
            $messages = [
                'title.required' => 'Mời nhập tiêu đề',
                'content.required' => 'Mời nhập nội dung',
                'input-b1.required' => 'Mời chọn ảnh'
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data['image'] = uploadFile($this->path_image, $data['input-b1']);
            $manageSlider = $this->manageSliderRepoInter->create($data);;
            $manageSlider->tag = $this->manageSliderRepoInter::LIST_TAG[$manageSlider->tag];
            $manageSlider->image = asset('') . $this->path_image . $manageSlider->image;
        } elseif ($data['tag'] == $this->manageSliderRepoInter::slider_2) {
            $rules = [
                'film_id' => 'required',
                'tag' => 'required',
            ];
            $messages = [
                'film_id.required' =>  'Mời bạn nhập tên phim',
                'tag.required' =>  'Mời bạn chọn loại hiển thị trên trang home',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $exist =  $this->manageSliderRepoInter->wherewhere('film_id', $request->film_id, 'tag', $request->tag);
            if (count($exist) > 0) {
                return response()->json(['error' => 'Phim đã tồn tại trong ' . $this->manageSliderRepoInter::LIST_TAG[$request->tag]]);
            } else {
                $manageSlider = $this->manageSliderRepoInter->create($data);
                $manageSlider = $manageSlider->with(['film' => function($q) {
                    $q->join('users', 'films.user_id', '=', 'users.id')
                    ->select(['users.name AS user_name', 'films.name', 'films.id']);
                }])->find($manageSlider->id);
                $manageSlider->tag = $this->manageSliderRepoInter::LIST_TAG[$manageSlider->tag];
            }
        }

        return response()->json(['error' => false, 'success' => 'Thêm mới thành công', 'data' => $manageSlider]);
    }

    public function delete($id)
    {
        $result = $this->manageSliderRepoInter->delete($id);

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function detail($id)
    {
        $data = $this->manageSliderRepoInter->find($id);
        $data['image'] = asset('') . $this->path_image . $data['image'];
        if ($data['tag'] == $this->manageSliderRepoInter::slider_2) {
            $data = $data->load('film');
        }

        return $data;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if ($data['tag'] == $this->manageSliderRepoInter::slider_1) { 
            $rules = [
                'title' => 'required',
                'content' => 'required'
            ];
            $messages = [
                'title.required' => 'Mời nhập tiêu đề',
                'content.required' => 'Mời nhập nội dung'
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            if (isset($data['input-b1'])) {
                $data['image'] = uploadfile($this->path_image, $data['input-b1']);
            }
            $manageSlider = $this->manageSliderRepoInter->update($data['id'], $data);
            $manageSlider = $this->manageSliderRepoInter->find($data['id']);
            $manageSlider->image = asset('') . $this->path_image . $manageSlider->image;
        } elseif ($data['tag'] == $this->manageSliderRepoInter::slider_2) { 
            $rules = [
                'film_id' => 'required',
                'tag' => 'required',
            ];
            $messages = [
                'film_id.required' =>  'Mời bạn nhập tên phim',
                'tag.required' =>  'Mời bạn chọn loại hiển thị trên trang home',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $manageSlider = $this->manageSliderRepoInter->update($data['id'], $data);
            $manageSlider = $this->manageSliderRepoInter->with(['film' => function($q) {
                $q->join('users', 'films.user_id', '=', 'users.id')
                ->select(['users.name AS user_name', 'films.name', 'films.id']);
            }])->find($data['id']);
        }
        $manageSlider->tag = $this->manageSliderRepoInter::LIST_TAG[$manageSlider->tag];

        return response()->json(['error' => false, 'success' => 'Sửa thành công', 'data' => $manageSlider]);
    }

    public function multiDelete(Request $request)
    {
        $listIds = $request->listids;
        $result = $this->manageSliderRepoInter->multiDelete('id', $listIds);

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->manageSliderRepoInter->search($request->name);

            return $result;
        }
    }
}
