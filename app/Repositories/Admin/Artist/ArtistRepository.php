<?php 
namespace App\Repositories\Admin\Artist;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\Artist\ArtistRepositoryInterface;
use App\Models\Artist;

class ArtistRepository extends EloquentRepository implements ArtistRepositoryInterface
{
	const actor= 1;
	const director = 2;
	const LIST_OP_ID = [
		self::actor,
		self::director
	];
	const LIST_OP = [
		self::actor => 'Diễn viên',
		self::director => 'Đạo diễn'
	];
	
	public function getModel()
	{
		return Artist::class;
	}

	public function searchActor($search)
	{
		$result = $this->_model->with('filmsFActor')->where('occupation', self::actor)->where('name', 'LIKE', '%' . $search . '%')->get()->pluck('filmsFActor')->toArray();

		return $result;
	}

	public function searchDirector($search)
	{
		$result = $this->_model->with('filmsFDirector')->where('occupation', self::director)->where('name', 'LIKE', '%' . $search . '%')->get()->pluck('filmsFDirector')->toArray();

		return $result;
	}
}
