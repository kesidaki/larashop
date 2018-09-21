<?php
namespace App\Eloquent;

use DB;
use App\Receipt;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class ReceiptRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Receipt';
	}

	/**
	* Find receipt(s) for an order 
	* @param order
	* @param type
	*
	* @return model
	*/
	function findReceipt($order, $type) 
	{
		return Receipt::where('order_id', $order)
					  ->where('type', $type)
					  ->first();
	}

	/**
	* Get Latest receipt number, needs fixing according to accountman's instructions
	* @param code
	*
	* @return integer
	*/
	function getLatestNumber($code = 'ΑΠΥ') 
	{
		$number =  Receipt::where('code', $code)
							->orderBy('id', 'desc')
						  	->first();

		return (!$number) ? 1 : $number->number + 1;
	}

}

?>