<?php
namespace App\Eloquent;

use DB;
use App\Brand;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class BrandRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Brand';
	}

}

?>