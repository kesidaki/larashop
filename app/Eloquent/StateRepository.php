<?php
namespace App\Eloquent;

use DB;
use App\State;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class StateRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\State';
	}

}

?>