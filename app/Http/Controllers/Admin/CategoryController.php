<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use DB;
use App\Repositories\Admin\Film\FilmRepositoryInterface;
use App\Repositories\Admin\CategoryFilm\CategoryFilmRepositoryInterface;
use App\Repositories\Admin\ArtistFilm\ArtistFilmRepositoryInterface;
use App\Repositories\Admin\Country\CountryRepositoryInterface;
use App\Repositories\Admin\Video\VideoRepositoryInterface;
use App\Repositories\Admin\News\NewsRepositoryInterface;

class CategoryController extends Controller
{
	public function __construct(
        CategoryRepositoryInterface $categoryRepoInter,
        CategoryFilmRepositoryInterface $cateFilmRepoInter,
        ArtistFilmRepositoryInterface $artistFilmRepoInter,
        VideoRepositoryInterface $videoRepoInter,
        NewsRepositoryInterface $newsRepoInter,
        FilmRepositoryInterface $filmRepoInter)
	{
		$this->categoryRepoInter = $categoryRepoInter;
        $this->cateFilmRepoInter = $cateFilmRepoInter;
        $this->artistFilmRepoInter = $artistFilmRepoInter;
        $this->videoRepoInter = $videoRepoInter;
        $this->newsRepoInter = $newsRepoInter;
        $this->filmRepoInter = $filmRepoInter;
	}

    public function index()
    {
    	$data = $this->categoryRepoInter->all();

        return view('admin.category.category', ['data' => $data]);
    }

    public function create(StoreCategoryRequest $request)
    {
    	$data = $request->all();
        $category = $this->categoryRepoInter->create($data);

        return response()->json(['success' => 'Thêm mới thành công', 'data' => $category]);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = $this->categoryRepoInter->wherePluckPluck($id);
            if (count($data) > 0) {
                if ($data['type'] == 'films') {
                    foreach ($data['list_id'] as $film_id) {
                        if (count($this->cateFilmRepoInter->where('film_id', $film_id)) > 1) {
                            $this->cateFilmRepoInter->whereWhereDelete('film_id', $film_id, 'category_id', $id);
                        } else {
                            $this->filmRepoInter->delete($film_id);
                            $this->cateFilmRepoInter->whereWhereDelete('film_id', $film_id, 'category_id', $id);
                            $this->artistFilmRepoInter->whereDelete('film_id', $film_id);
                            $this->videoRepoInter->whereDelete('film_id', $film_id);
                        }
                    }
                } else {
                    $this->newsRepoInter->multiDelete('id', $data['list_id']);
                }
            }
            $this->categoryRepoInter->delete($id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            throw new Exception($e->getMessage());
        }

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function detail($id)
    {
        $data = $this->categoryRepoInter->find($id);

        return $data;
    }

    public function update(UpdateCategoryRequest $request)
    {
        $data = $request->all();
        $this->categoryRepoInter->update($data['id'], $data);
        $category = $this->categoryRepoInter->find($data['id']);

        return response()->json(['error' => false, 'success' => 'Sửa thành công', 'data' => $category]);
    }

    public function multiDelete(Request $request)
    {
        $listIds = $request->listids;
        DB::beginTransaction();
        try {
            foreach ($listIds as $id) {
                $data = $this->categoryRepoInter->wherePluckPluck($id);
                if (count($data) > 0) {
                    if ($data['type'] == 'films') {
                        foreach ($data['list_id'] as $film_id) {
                            if (count($this->cateFilmRepoInter->where('film_id', $film_id)) > 1) {
                                $this->cateFilmRepoInter->whereWhereDelete('film_id', $film_id, 'category_id', $id);
                            } else {
                                $this->filmRepoInter->delete($film_id);
                                $this->cateFilmRepoInter->whereWhereDelete('film_id', $film_id, 'category_id', $id);
                                $this->artistFilmRepoInter->whereDelete('film_id', $film_id);
                                $this->videoRepoInter->whereDelete('film_id', $film_id);
                            }
                        }
                    } else {
                        $this->newsRepoInter->multiDelete('id', $data['list_id']);
                    }
                }
                $this->categoryRepoInter->delete($id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            throw new Exception($e->getMessage());
        }
        return response()->json(['success' => 'Xóa thành công']);
    }
}
