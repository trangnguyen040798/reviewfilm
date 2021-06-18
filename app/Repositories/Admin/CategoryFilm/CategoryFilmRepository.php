<?php 
namespace App\Repositories\Admin\CategoryFilm;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\CategoryFilm\CategoryFilmRepositoryInterface;
use App\Models\CategoryFilm;

class CategoryFilmRepository extends EloquentRepository implements CategoryFilmRepositoryInterface
{
	public function getModel()
	{
		return CategoryFilm::class;
	}
}
