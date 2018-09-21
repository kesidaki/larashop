<?php
namespace App\Eloquent;

use DB;
use App\Option;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class OptionRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Option';
	}

	/**
	* Get tax as float value
	*
	* @return float
	*/
	function getTax() 
	{
		$tax = Option::where('attribute', '=', 'tax_mod')->first();

		return (float)$tax->value;
	}

}

?>