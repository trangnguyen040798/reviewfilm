<?php 
namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{

	protected $_model;

	public function __construct()
	{
		$this->setModel();
	}

	abstract function getModel();

	public function setModel()
	{
		$this->_model = app()->make($this->getModel());
	}

	public function all()
	{
		return $this->_model->orderBy('id', 'desc')->get();
	}

	public function delete($id)
	{
		$result = $this->_model->find($id);
		if ($result) {
			return $result->delete();
		}
	}

	public function update($id , array $attributes)
	{
		$result = $this->_model->find($id);
		if ($result) {
			$result = $result->update($attributes);
			return true;
		} else {
			return false;
		}
	}

	public function find($id)
	{
		$result = $this->_model->find($id);
		if ($result) {
			return $result;
		} else {
			return '';
		}
	}

	public function create(array $attributes)
	{
		return $this->_model->create($attributes);
	}

	public function where($a, $t)
	{
		$result = $this->_model->where($a, $t)->get();
		if ($result) {
			return $result;
		} else {
			return '';
		}
	}

	public function whereIn($a, array $t)
	{
		$result = $this->_model->whereIn($a, $t)->get();
		if ($result) {
			return $result;
		} else {
			return '';
		}
	}

	public function wherePluck($a, $t, $p)
	{
		$result = $this->_model->where($a, $t)->pluck($p)->toArray();
		if ($result) {
			return $result;
		} else {
			return '';
		}
	}

	public function whereDelete($a, $t)
	{
		$result = $this->_model->where($a, $t)->delete();

		return $result;
	}

	public function multiDelete($a, array $t)
	{
		$result = $this->_model->whereIn($a, $t)->delete();

		return $result;
	}

	public function paginate($n)
	{
		$result = $this->_model->paginate($n);

		return $result;
	}

	public function wherewhere($a1, $t1, $a2, $t2)
	{
		$result = $this->_model->where($a1, $t1)->where($a2, $t2)->get();

		return $result;
	}

	public function wherePaginate($attr, $val, $page)
	{
		$result = $this->_model->where($attr, $val)->paginate($page);

		return $result;
	}

	public function with($re)
	{
		return $this->_model->with($re);
	}

	public function load($re)
	{
		return $this->_model->load($re);
	}

	public function whereWhereDelete($t1, $a1, $t2, $a2)
	{
		return $this->_model->where($t1, $a1)->where($t2, $a2)->delete();
	}

	public function whereFirst($t, $a)
	{
		return $this->_model->where($t, $a)->first();
	}
}
