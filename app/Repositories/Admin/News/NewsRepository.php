<?php 
namespace App\Repositories\Admin\News;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\News\NewsRepositoryInterface;
use App\Models\News;
use Carbon\Carbon;

class NewsRepository extends EloquentRepository implements NewsRepositoryInterface
{
	public $subDay = 7;
	public $takeNews = 10;
	public $hotNews = 4;

	public function getModel()
	{
		return News::class;
	}

	public function whereDate()
	{
		$newDateTime = Carbon::now()->subDays($this->subDay);
		$news = News::where('updated_at', '>=', $newDateTime)->take($this->takeNews)->get();
		foreach ($news as $key => $value) {
			$news[$key]['new'] = true;
		}
		if (count($news) < $this->takeNews) {
			$mergeNews = News::where('updated_at' , '<=', $newDateTime)->take($this->takeNews - count($news))->orderBy('updated_at', 'DESC')->get();
			foreach ($mergeNews as $key => $value) {
				$mergeNews[$key]['new'] = false;
			}
			$news = $news->merge($mergeNews);
		}

		return $news;
	}

	public function whereHot()
	{
		$news = News::orderBy('views', 'DESC')->take($this->hotNews)->get();

		return $news;
;	} 
}
