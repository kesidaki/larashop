<?php
namespace App\Eloquent;

use DB;
use App\Buyer;
use App\Transaction;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class BuyerRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Buyer';
	}

}

?>