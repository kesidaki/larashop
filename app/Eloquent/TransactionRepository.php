<?php
namespace App\Eloquent;

use DB;
use App\Buyer;
use App\Transaction;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class TransactionRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Transaction';
	}

	/**
	* Get all transactions of an order
	* @param id
	*
	* @return object
	*/
	function getForOrder($id) 
	{
		return Transaction::where('order_id', $id)
						  ->with('product')
						  ->get();
	}

	/**
	* Return Product Sales for a Set Period
	* @param id
	* @param from
	* @param to
	* @param type
	*
	* @return integer
	*/
	public function productSalesForPeriod($id, $from, $to, $type='ΑΠΥ') 
	{
		return DB::Table('transactions')->select('transactions.order_id')
					   ->join('receipts', function($join) use ($type) {
					   		$join->on('receipts.order_id', '=', 'transactions.order_id');
					   		$join->on('receipts.code', '=', DB::raw('"'.$type.'"'));
					   })
					   ->where('transactions.product_id', '=', $id)
					   ->where('transactions.created_at', '>=', $from)
					   ->where('transactions.created_at', '<=', $to)
					   ->get()
					   ->count();
	}

}

?>