<?php 
namespace App\Repositories;

interface RepositoryInterface {

	public function all();

	public function delete($id);

	public function update($id , array $attributes);

	public function create(array $attributes);

	public function find($id);

	public function where($a, $t);

	public function wherewhere($a1, $t1, $a2, $t2);

	public function wherePluck($a, $t, $p);

	public function whereDelete($a, $t);

	public function multiDelete($a, array $t);

	public function wherePaginate($attr, $val, $page);

	public function with($re);

	public function load($re);

	public function whereWhereDelete($t1, $a1, $t2, $a2);

	public function whereFirst($t, $a);
}