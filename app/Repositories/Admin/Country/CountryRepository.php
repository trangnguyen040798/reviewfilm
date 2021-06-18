<?php 
namespace App\Repositories\Admin\Country;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\Country\CountryRepositoryInterface;
use App\Models\Country;

class CountryRepository extends EloquentRepository implements CountryRepositoryInterface
{
	public function getModel()
	{
		return Country::class;
	}
}
