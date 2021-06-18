<?php 
namespace App\Repositories\Admin\ArtistFilm;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\ArtistFilm\ArtistFilmRepositoryInterface;
use App\Models\ArtistFilm;

class ArtistFilmRepository extends EloquentRepository implements ArtistFilmRepositoryInterface
{
	public function getModel()
	{
		return ArtistFilm::class;
	}
}
