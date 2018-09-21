<?php
namespace App\Eloquent;

use DB;
use App\Subcategory;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class SubcategoryRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Subcategory';
	}

	/**
	* Get an array with each category and it's subcategories
	* @param categories
	*
	* @return array
	*/
	function getGrouped($categories) 
	{
		$arr = [];

		foreach ($categories as $category) {
			$arr[] = [
				'category'      => $category->name,
				'subcategories' => $category->subcategories
			];
		}

		return $arr;
	}

}

?>