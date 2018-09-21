<?php
namespace App\Eloquent;

use DB;
use App\User;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class UserRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\User';
	}

}

?>