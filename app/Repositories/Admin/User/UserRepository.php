<?php 
namespace App\Repositories\Admin\User;

use App\Repositories\EloquentRepository;
use App\Repositories\Admin\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
	public function getModel()
	{
		return User::class;
	}
}
