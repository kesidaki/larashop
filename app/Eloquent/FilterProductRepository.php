<?php
namespace App\Eloquent;

use DB;
use App\Filter_product;
use Carbon\Carbon;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class FilterProductRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Filter_product';
	}

}

?>