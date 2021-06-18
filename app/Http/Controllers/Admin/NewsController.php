<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\News\NewsRepositoryInterface;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    public function __construct(NewsRepositoryInterface $newsRepoInter, CategoryRepositoryInterface $cateRepoInter)
	{
		$this->newsRepoInter = $newsRepoInter;
        $this->cateRepoInter = $cateRepoInter;
	}

    public function index()
    {
    	$data = $this->newsRepoInter->all();
        foreach ($data as $key => $value) {
            $data[$key]['image'] = asset('') . config('admin.default_folder_image') . $value['image'];
        }

        $categories = $this->cateRepoInter->where('type', 'news');

        return view('admin.news.news', ['data' => $data, 'categories' => $categories]);
    }

    public function create(StoreNewsRequest $request)
    {
    	$data = $request->all();
        if (isset($data['image'])) {
            $data['image'] = uploadFile(config('admin.default_folder_image'), $data['image']);
        }
        $news = $this->newsRepoInter->create($data);
        $news['image'] = asset('') . config('admin.default_folder_image') . $news['image'];
        $news['views'] = 0;

        return response()->json(['success' => 'Thêm mới thành công', 'data' => $news]);
    }

    public function delete($id)
    {
        $result = $this->newsRepoInter->delete($id);

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function detail($id)
    {
        $data = $this->newsRepoInter->find($id)->load('category');
        $data['image'] = asset('') . config('admin.default_folder_image') . $data['image'];

        return $data;
    }

    public function update(UpdateNewsRequest $request)
    {
        $data = $request->all();
        if (isset($data['update_image'])) {
            $data['image'] = uploadFile(config('admin.default_folder_image'), $data['update_image']);
        }
        $data['content'] = $data['update_content'];
        unset($data['update_content']);
        $this->newsRepoInter->update($data['id'], $data);
        $news = $this->newsRepoInter->find($data['id']);
        $news['image'] = asset('') . config('admin.default_folder_image') . $news['image'];

        return response()->json(['error' => false, 'success' => 'Sửa thành công', 'data' => $news]);
    }

    public function multiDelete(Request $request)
    {
        $listIds = $request->listids;
        $result = $this->newsRepoInter->multiDelete('id', $listIds);

        return response()->json(['success' => 'Xóa thành công']);
    }
}
