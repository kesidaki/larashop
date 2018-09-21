<?php
namespace App\Eloquent;

use DB;
use App\FilterValue;
use Carbon\Carbon;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class FilterValueRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\FilterValue';
	}

}

?>