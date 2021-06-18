<?php 
namespace App\Repositories\Admin\Video;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\Video\VideoRepositoryInterface;
use App\Models\Video;

class VideoRepository extends EloquentRepository implements VideoRepositoryInterface
{
	public function getModel()
	{
		return Video::class;
	}
}
