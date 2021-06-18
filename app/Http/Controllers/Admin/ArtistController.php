<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Artist\ArtistRepositoryInterface;
use App\Repositories\Admin\Country\CountryRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ArtistRequest;

class ArtistController extends Controller
{
	public function __construct(ArtistRepositoryInterface $artistRepoInter, CountryRepositoryInterface $countryRepoInter)
	{
		$this->artistRepoInter = $artistRepoInter;
        $this->countryRepoInter = $countryRepoInter;
	}

    public function index()
    {
    	$data = $this->artistRepoInter->with('country')->get();
        foreach ($data as $key => $value) {
            if ($value['image'] == null) {
                $data[$key]['image'] = config('admin.no-image');
            } else {
                $data[$key]['image'] = config('admin.default_folder_image') . $data[$key]['image'];
            }
            $data[$key]['occupation'] = $this->artistRepoInter::LIST_OP[$value['occupation']];
        }
        $countries = $this->countryRepoInter->all();
        $list_types = $this->artistRepoInter::LIST_OP;

        return view('admin.artist.artist', ['data' => $data, 'countries' => $countries, 'types' => $list_types]);
    }

    public function create(ArtistRequest $request)
    {
        $data = $request->all();
        if (isset($data['input-b1'])) {
            $data['image'] = uploadFile(config('admin.default_folder_image'), $data['input-b1']);
        }
        $data['birthday'] = date("Y-m-d", strtotime($data['birthday']));
        $data['story'] = $data['editor'];
        $artist = $this->artistRepoInter->create($data);
        if ($artist['image'] == null) {
            $artist['image'] = asset('') . config('admin.no-image');
        } else {
            $artist['image'] = asset('') . config('admin.default_folder_image') . $artist['image'];
        }
        $country = $this->countryRepoInter->find($artist['country_id']);
        if (!is_null($country)) {
            $artist['country'] = $country['title'];
        } else {
            $artist['country'] = '...';
        }
        $artist['name_occupation'] = $this->artistRepoInter::LIST_OP[$artist['occupation']];

        return response()->json(['error' => false, 'success' => 'Thêm mới thành công', 'data' => $artist]);
    }

    public function detail($id)
    {
        $data = $this->artistRepoInter->with('country')->find($id);
        if ($data['image'] == null) {
            $data['image'] = asset('') . config('admin.no-image');
        } else {
            $data['image'] = asset('') . config('admin.default_folder_image') . $data['image'];
        }
        $data['birthday'] = date("d-m-Y", strtotime($data['birthday']));
        $data['height'] = round($data['height'], 2);
        $data['name_occupation'] = $this->artistRepoInter::LIST_OP[$data['occupation']];

        return $data;
    }

    public function update(ArtistRequest $request)
    {
        $data = $request->all();
        $data['birthday'] = date("Y-m-d", strtotime($data['birthday']));
        if (isset($data['input-repl-1a'])) {
            $data['image'] = uploadFile(config('admin.default_folder_image'), $data['input-repl-1a']);
        }
        $artist = $this->artistRepoInter->update($data['id'], $data);
        $artist = $this->artistRepoInter->with('country')->find($data['id']);
        if ($artist['image'] == null) {
            $artist['image'] = config('admin.no-image');
        } else {
            $artist['image'] = config('admin.default_folder_image') . $artist['image'];
        }
        $country = $this->countryRepoInter->find($artist['country_id']);
        if (!is_null($country)) {
            $artist['country'] = $country['title'];
        } else {
            $artist['country'] = '...';
        }
        $artist['name_occupation'] = $this->artistRepoInter::LIST_OP[$artist['occupation']];

        return response()->json(['error' => false, 'success' => 'Sửa thành công', 'data' => $artist]);
    }

    public function delete($id)
    {
        $result = $this->artistRepoInter->delete($id);

        return response()->json(['success' => 'Xóa thành công']);
    }

    public function multiDelete(Request $request)
    {
        $listIds = $request->listids;
        $result = $this->artistRepoInter->multiDelete('id', $listIds);
       

        return response()->json(['success' => 'Xóa thành công']);
    }
}
