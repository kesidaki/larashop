<?php
namespace App\Eloquent;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface 
{ 

	private   $app;
	protected $model;

	public function __construct(App $app) 
	{ 
		$this->app = $app;
		$this->makeModel();
	}

	// Model Initialization Process
	abstract function model();

	/**
	* Register model
	*/
	public function makeModel() 
	{ 
		$model = $this->app->make($this->model());

		if (!$model instanceof Model){
			throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
		}

		return $this->model = $model;
	}

	/**
	* Find by ID
	* @param id
	* @param columns
	*
	* @return model
	*/
	public function find($id, $columns=['*']) 
	{
		return $this->model->findOrFail($id, $columns);
	}

	/**
	* Find by attribute
	* @param attribute
	* @param value
	* @param columns
	*
	* @return model
	*/
	public function findBy($attribute, $value, $columns=['*']) 
	{
		return $this->model->where($attribute, '=', $value)->firstOrFail($columns);
	}

	/**
	* Get all
	* @param columns
	*
	* @return collection
	*/
	public function all($columns=['*']) 
	{ 
		return $this->model->get($columns);
	}

	/**
	* Get all, order by attribute
	* @param attribute
	* @param value
	* @param columns
	*
	* @return collection
	*/
	public function allBy($attribute, $value, $columns=['*']) 
	{
		return $this->model->orderBy($attribute, $value)->get($columns);
	}

	/**
	* All, filtered by where and order by
	* @param attribute
	* @param value
	* @param orderBy
	* @param order
	* @param columns
	*
	* @return collection
	*/
	public function allByOrdered($attribute, $value, $orderBy, $order, $columns=['*']) 
	{
		return $this->model->where($attribute, '=', $value)->orderBy($orderBy, $order)->get($columns);
	}

	/**
	* Paginate
	* @param perPage
	* @param columns
	*
	* @return collection
	*/
	public function paginate($perPage=15, $columns=['*']) 
	{ 
		return $this->model->paginate($perPage, $columns);
	}

	/**
	* Create
	* @param data
	*
	* @return integer
	*/
	public function create(array $data) 
	{
		return $this->model->create($data)->id;
	}

	/**
	* Update a set of data
	* @param data
	* @param id
	* @param attribute, in case we do not want to update by Id
	*
	* @return integer (number of rows affected)
	*/
	public function update(array $data, $id, $attribute='id') 
	{
		return $this->model->where($attribute, '=', $id)->update($data);
	}

	/**
	* Delete by Id
	* @param id
	*/
	public function delete($id) 
	{
		return $this->model->destroy($id);
	}

	/**
	* Delete by Attribute
	* @param attribute
	* @param value
	*/
	public function deleteBy($attribute, $value) 
	{
		return $this->model->where($attribute, '=', $value)->delete();
	}

}

?>