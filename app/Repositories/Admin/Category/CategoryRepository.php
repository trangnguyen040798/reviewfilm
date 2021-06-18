<?php 
namespace App\Repositories\Admin\Category;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{
	public function getModel()
	{
		return Category::class;
	}

	public function wherePluckPluck($id)
	{
		$category = Category::find($id);
		if ($category['type'] == 'film') {
			$category = $category->load('films');
			$films = $category->films;
			if (count($films) > 0) {
				return ['list_id' => $films->pluck('id')->toArray(), 'type' => 'films'];
			} else {
				return [];
			}
		} else {
			$news = $category->load('news');
			$news = $category->news;
			if (count($news) > 0) {
				return ['list_id' => $news->pluck('id')->toArray(), 'type' => 'news'];
			} else {
				return [];
			}
		}
	}
}
