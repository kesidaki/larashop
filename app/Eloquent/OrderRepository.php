<?php
namespace App\Eloquent;

use DB;
use App\Order;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class OrderRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Order';
	}

	/**
	* Get most recent orders
	* @param limit
	*
	* @return collection
	*/
	function recent($limit) 
	{
		return Order::orderBy('id', 'desc')
					->limit($limit)
					->get();
	}

	/**
	* Get either all orders or filtered, paginated results
	* @param request
	*
	* @return paginated collection
	*/
	function getOrders($request) 
	{
		$orders = Order::select('*');

		if ($request->term) {
			$orders->where('name', 'like', '%'.$request->term.'%');
			$orders->orWhere('name', 'like', '%'.$request->term.'%');
			$orders->orWhere('address', 'like', '%'.$request->term.'%');
			$orders->orWhere('phone', 'like', '%'.$request->term.'%');
			$orders->orWhere('phone_2', 'like', '%'.$request->term.'%');
		}

		$orders->orderBy('id', 'desc');

		return $orders->paginate(15);
	}

}

?>