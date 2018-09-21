<?php
namespace App\Eloquent;

use DB;
use App\Shipping;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class ShippingRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Shipping';
	}

}

?>