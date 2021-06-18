<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Repositories\Admin\News\NewsRepositoryInterface;

class NewsController extends Controller
{
	public $paginate = 6;

	public function __construct(
		CategoryRepositoryInterface $cateRepoInter,
		NewsRepositoryInterface $newsRepoInter
	)
	{
		$this->cateRepoInter = $cateRepoInter;
		$this->newsRepoInter = $newsRepoInter;
	}

	public function index()
	{
		$cateNews = $this->cateRepoInter->where('type', 'news');
		if (count($cateNews) > 0) {
			foreach ($cateNews as $key => $value) {
				$news[$key] = $this->newsRepoInter->wherePaginate('category_id', $value['id'], $this->paginate);
			}
			$latestNews = $this->newsRepoInter->whereDate();
			$hotNews = $this->newsRepoInter->whereHot();
		} else {
			$news = [];
			$latestNews = [];
			$hotNews = [];
		}

		return view('client.cate-news', ['cateNews' => $cateNews, 'news' => $news, 'latestNews' => $latestNews, 'hotNews' => $hotNews]);
	}

	public function detail($slug)
	{
		$news = $this->newsRepoInter->whereFirst('slug', $slug);
		$this->newsRepoInter->update($news['id'], ['views' => $news['views'] + 1]);
		if (!empty($news)) {
			$latestNews = $this->newsRepoInter->whereDate();
			$hotNews = $this->newsRepoInter->whereHot();
		} else {
			$latestNews = [];
			$hotNews = [];
		}

		return view('client.news', ['news' => $news, 'latestNews' => $latestNews, 'hotNews' => $hotNews]);
	}

}