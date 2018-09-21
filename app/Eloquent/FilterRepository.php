<?php
namespace App\Eloquent;

use DB;
use App\Filter;
use Carbon\Carbon;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class FilterRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Filter';
	}

}

?>