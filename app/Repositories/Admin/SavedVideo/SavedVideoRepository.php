<?php 
namespace App\Repositories\Admin\SavedVideo;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\SavedVideo\SavedVideoRepositoryInterface;
use App\Models\SavedVideo;
use Auth;
use DB;

class SavedVideoRepository extends EloquentRepository implements SavedVideoRepositoryInterface
{
	public function __construct()
	{
		$this->path_video = config('admin.default_folder_video');
		$this->path_image = config('admin.default_folder_image');
	}

	public function getModel()
	{
		return SavedVideo::class;
	}

	public function getListNameCateSV($id)
	{
		if (Auth::check()) {
			$user = Auth::user();
			$listChecked = SavedVideo::where('user_id', $user->id)->where('video_id', $id)->select('name_cate', 'video_id')->get();
			foreach ($listChecked as $key => $value) {
				$listChecked[$key]['ischecked'] = true;
			}
			$list = SavedVideo::where('user_id', $user->id)->where('video_id', '!=', $id)->groupBy('name_cate')->select('name_cate', 'video_id')->get();
			if (count($list) == 0) {
				return $listChecked;
			}
			$merge = $listChecked->merge($list);
		} else {
			$merge = [];
		}

		return $merge;
	}

	public function isExistAndDelete($t1, $a1, $t2, $a2, $t3, $a3)
	{
		$csavedVideo = SavedVideo::where($t1, $a1)->where($t2, $a2)->where($t3, $a3)->get();
		if (count($csavedVideo) > 0) {
			$csavedVideo->first()->delete();

			return true;
		} else {
			return false;
		}
	}

	public function getListSV()
	{
		$listNC = $this->getListCateName();
		$list = [];
		foreach ($listNC as $key => $value) {
			$result = $this->getListSVFCate($value->name_cate);
			$list[$value->name_cate] = $result;
		}

		return $list;
	}

	public function getListSVFCate($name_cate)
	{
		$user = Auth::user();
		$result = SavedVideo::where('user_id', $user->id)->where('name_cate', $name_cate)->with(['video' => function($q) {
			$q->with(['film' => function($q) {
				$q->with('user')->get();
			}])->get();
		}])->get();
		foreach ($result as $key => $value) {
			if ($value->video->image == null) {
				$result[$key]->video->image = asset('') . config('admin.no-image');
			} else {
				$result[$key]->video->image = asset('') . $this->path_image . $value->video->image;
			}
			$result[$key]->video->link = asset('') . $this->path_video . $value->video->link;
		}

		return $result;
	}

	public function getListCateName()
	{
		$user = Auth::user();
		$listNC = SavedVideo::where('user_id', $user->id)->select('name_cate')
		->groupBy('name_cate')
		->get();

		return $listNC;
	}

	public function save($data)
	{
		$savedVideo = new SavedVideo;
		foreach ($data as $key => $value) {
			$savedVideo->$key = $value;
		}
		$savedVideo->save();
		$savedVideo->refresh();

		return $savedVideo;
	}
}
