<?php 
namespace App\Repositories\Admin\Film;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\Film\FilmRepositoryInterface;
use App\Models\Film;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use DB;

class FilmRepository extends EloquentRepository implements FilmRepositoryInterface
{
	const series_movie_type = 1;
    const odd_film_type = 2;
    const LIST_ID_TYPE = [
    	self::series_movie_type,
    	self::odd_film_type
    ];
    const LIST_TYPE = [
        self::series_movie_type => 'Phim bộ',
        self::odd_film_type => 'Phim lẻ'
    ];
    const google = 'google';
    // const fpt = 'fpt';
    const zalo = 'zalo';
    const LIST_FILTER_AI = [
        self::google => 'Chị Google',
        // self::fpt => 'FPT Ai',
        self::zalo => 'Zalo Ai'
    ];
    protected $SG = [];
    protected $take = 10;
    public $paginate = 16;

    public function getModel()
    {
        return Film::class;
    }

    public function takeTenFilm($film)
    {
        $listCategoryIds = $film->categories->pluck('id')->toArray();
        $collection = new Collection();
        // if ($this->SG <= 20) {
        foreach ($listCategoryIds as $key => $cate_id) {
            $this->SG[$cate_id] = 0;
            $result = $this->_model->whereHas('categories', function (Builder $query) use ($cate_id) {
                $query->where('categories.id', $cate_id);
            })->where('id', '!=', $film->id)->with('user')->skip($this->SG[$cate_id])->take($this->take)->get();
            $collection = $collection->merge($result);
            $count = count($collection);
            if ($count == 10) {
                $this->SG[$key] += 10;

                return $collection;
            } else if ($key == count($listCategoryIds) - 1) {

                return $collection;
            }
            $this->take = 10 - $count;
            $this->SG[$cate_id] += $count;
        }
        // }

        return null;
    }

    public function _whereHasCategory($arr)
    {
        if ($arr['table'] != '') {
            return $this->_model->whereHas($arr['table'] == 'countries' ? 'country' : $arr['table'], function (Builder $query) use ($arr) {
            $query->where($arr['table'] . '.id', $arr['id']);
        })->where('status', 1);
        } else {
            return $this->_model->where('type', $arr['slug']);
        }
    }

    public function whereHasCategory($arr)
    {
        $query = $this->_whereHasCategory($arr);
        return $query->paginate($this->paginate);
    }

    public function filter($data, $id, $table)
    {
        $query = $this->_whereHasCategory(['id' => $id, 'table' => $table, 'slug' => $data['slug']]);
        if (isset($data['categories']) && !empty($data['categories'])) {
            $query = $query->whereHas('categories', function (Builder $q) use ($data) {
                $q->whereIn('categories.id', $data['categories']);
            }); 
        }
        if(isset($data['countries']) && !empty($data['countries'])) {
            $query = $query->whereHas('country', function (Builder $q) use ($data) {
                $q->whereIn('countries.id', $data['countries']);
            });
        }
        if(isset($data['year']) && !is_null($data['year'])) {
            $query = $query->where('year', $data['year']);
        }
        if(isset($data['top']) && !empty($data['top'])) {
            if ($data['top'] == 'top_viewed') {
                $query = $query->orderBy('views', 'desc');
            } elseif($data['top'] == 'top_rating') {
                $query = $query->orderBy('rating', 'desc');
            }
        }

        return $query->get();
    }

    public function search($search)
    {
        $result = $this->_model->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
          ->orWhere('othername', 'LIKE', '%' . $search . '%');
        })->where('status', 1)->paginate($this->paginate);

        return $result;
    }

    public function getTopView()
    {
        $result = $this->_model->orderBy('views', 'desc')->where('status', 1)->take(16)->get();

        return $result;
    }

    public function getTopRating()
    {
        $result = $this->_model->orderBy('rating', 'DESC')->where('status', 1)->take(16)->get();
 
        return $result;
    }

    public function getTopLatest()
    {
        $result = $this->_model->orderBy('id', 'desc')->where('status', 1)->take(16)->get();

        return $result;
    }
}
