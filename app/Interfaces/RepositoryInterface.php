<?php
namespace App\Interfaces;

interface RepositoryInterface 
{
	public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function all($columns = array('*'));

    public function allBy($attribute, $value, $columns=['*']);

    public function allByOrdered($attribute, $value, $orderBy, $order, $columns=['*']);

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function deleteBy($attribute, $value);
}

?>