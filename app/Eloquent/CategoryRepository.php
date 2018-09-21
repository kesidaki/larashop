<?php
namespace App\Eloquent;

use DB;
use App\Category;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class CategoryRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Category';
	}

	/**
	* Get an array of all the categories
	* @return array
	*/
	function getArray() {
		$data = [];

		$categories = $this->allBy('name', 'asc');
		foreach ($categories as $category) {
			array_push($data, $category->name);
		}

		return $data;
	}

}

?>