<?php 
namespace App\Repositories\Admin\InfoVideo;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\InfoVideo\InfoVideoRepositoryInterface;
use App\Models\InfoVideo;

class InfoVideoRepository extends EloquentRepository implements InfoVideoRepositoryInterface
{
	public function getModel()
	{
		return InfoVideo::class;
	}

	public function wherewhereSmallVideo($t1, $a1, $t2, $a2)
	{
		return $this->_model->where($t1, $a1)->where($t2, $a2)->where('column_name', 'link_small_combine_video');
	}

	public function wherewhereAudio($t1, $a1, $t2, $a2)
	{
		return $this->_model->where('column_name', 'link_audio')->where($t1, $a1)->where($t2, $a2);
	}

	public function wherewhereCombineAudio($t1, $a1, $t2, $a2)
	{
		return $this->_model->where('column_name', 'link_combine_audio')->where($t1, $a1)->where($t2, $a2);
	}

	public function wherewhereBGSound($t1, $a1, $t2, $a2)
	{
		return $this->_model->where('column_name', 'link_bg_audio')->where($t1, $a1)->where($t2, $a2);
	}

	public function wherewhere($t1, $a1, $t2, $a2)
	{
		return $this->_model->where($t1, $a1)->where($t2, $a2)->get();
	}

	public function whereNotIn($t1, $a1, $t2, $a2, $list_id)
	{

		if (is_null($list_id)) {
			return $this->_model->where('column_name', 'link_small_combine_video')->where($t1, $a1)->where($t2, $a2);
		}
		return $this->_model->where('column_name', 'link_small_combine_video')->where($t1, $a1)->where($t2, $a2)->whereNotIn('id', explode(',', $list_id));
	}

	public function wherewhereCombineVideo($t1, $a1, $t2, $a2)
	{
		return $this->_model->where('column_name', 'link_combine_video')->where($t1, $a1)->where($t2, $a2);
	}

	public function whereWhereInfo($t1, $a1, $t2, $a2)
	{
		return $this->_model->where($t1, $a1)->where($t2, $a2);
	}
}
