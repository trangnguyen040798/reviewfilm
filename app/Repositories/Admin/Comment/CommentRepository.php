<?php 
namespace App\Repositories\Admin\Comment;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\Comment\CommentRepositoryInterface;
use App\Models\Comment;
use Carbon\Carbon;

class CommentRepository extends EloquentRepository implements CommentRepositoryInterface
{
	public function getModel()
	{
		return Comment::class;
	}
}
