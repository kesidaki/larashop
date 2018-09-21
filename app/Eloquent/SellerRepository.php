<?php
namespace App\Eloquent;

use DB;
use App\Seller;
use App\Product;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class SellerRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Seller';
	}

}

?>