<?php 
namespace App\Repositories\Admin\ManageSlider;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\ManageSlider\ManageSliderRepositoryInterface;
use App\Models\ManageSlider;
use DB;

class ManageSliderRepository extends EloquentRepository implements ManageSliderRepositoryInterface
{
	const slider_1 = 1;
    const slider_2 = 2;
    const LIST_ID_TAG = [
    	self::slider_1,
    	self::slider_2
    ];
    const LIST_TAG = [
        self::slider_1 => 'Slide',
        self::slider_2 => 'Recommend'
    ];

	public function getModel()
	{
		return ManageSlider::class;
	}

    public function search($name)
    {
        $result = DB::table('films')
        ->join('users', 'films.user_id', '=', 'users.id')
        ->where('status', 1)
        ->where('films.name', 'LIKE', '%' . $name . '%')
        ->orWhere('othername', 'LIKE', '%' . $name . '%')
        ->select(DB::raw('films.name AS film_name, films.id AS film_id, users.name AS user_name'))
        ->limit(100)->get();

        return $result;
    }
}
