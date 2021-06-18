<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Repositories\Admin\Film\FilmRepositoryInterface;
use App\Repositories\Admin\Country\CountryRepositoryInterface;

class CategoryController extends Controller
{
	public function __construct(
        CategoryRepositoryInterface $cateRepoInter, 
        FilmRepositoryInterface $filmRepoInter,
        CountryRepositoryInterface $countryRepoInter
    )
	{
        $this->cateRepoInter = $cateRepoInter;
        $this->countryRepoInter = $countryRepoInter;
        $this->filmRepoInter = $filmRepoInter;
    }

    public function category($type, $slug)
    {
        switch ($type) {
            case 'film':
            $cate = $this->cateRepoInter->whereFirst('slug', $slug);
            $films = $this->filmCate(['id' => $cate->id, 'table' => 'categories', 'slug' => $slug]);
            break;
            case 'country':
            $cate = $this->countryRepoInter->whereFirst('slug', $slug);
            $films = $this->filmCate(['id' => $cate->id, 'table' => 'countries', 'slug' => $slug]);
            break;
            case 'type':
            $cate['title'] =  $this->filmRepoInter::LIST_TYPE[$slug];
            $films = $this->filmCate(['id' => '', 'table' => '', 'slug' => $slug]);
            break;
        }
        
        return view('client.category', ['category' => $cate, 'films' => $films, 'type' => $type, 'slug' => $slug]);
    }

    public function filmCate($arr)
    {
        $films = $this->filmRepoInter->whereHasCategory($arr);
        $films = $this->getInfor($films, true, false);

        return $films;
    }

    public function getInfor($films, $image=null, $route=null)
    {
        if ($image) {
            foreach ($films as $key => $film) {
                if ($film['image'] == null) {
                    $films[$key]['image'] = asset('') . config('admin.no-image');
                } else {
                    $films[$key]['image'] = asset('') . config('admin.default_folder_image') . $film['image'];
                }
            }
        }
        if($route) {
            foreach ($films as $key => $film) {
                $films[$key]['route'] = route('client.film.detail', [$film->id]);
            }
        }

        return $films;
    }

    public function filter(Request $request)
    {
        $data = $request->all();
        switch ($data['type_route']) {
            case 'film':
            $cate = $this->cateRepoInter->whereFirst('slug', $data['slug']);
            $table = 'categories';
            break;
            case 'country':
            $cate = $this->countryRepoInter->whereFirst('slug', $data['slug']);
            $table = 'countries';
            break;
            case 'type':
            $cate['title'] =  $this->filmRepoInter::LIST_TYPE[$data['slug']];
            $table = '';
            break;
        }
        $films = $this->filmRepoInter->filter($data, isset($cate->id) ? $cate->id : '', $table, $data['slug']);
        $films = $this->getInfor($films, true, true);
        // return redirect()->route('client.category.cate', ['type' => $data['type_route'], 'slug' => $data['slug']])->with(['category' => $cate, 'films' => $films, 'type' => $data['type_route'], 'slug' => $data['slug']]);
        // dd($films);
        // return back()->withInput(['category' => $cate, 'films' => $films, 'type' => $data['type_route'], 'slug' => $data['slug']]);
        return response()->json(['films' => $films]);
    }
}