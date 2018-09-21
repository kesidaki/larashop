<?php
namespace App\Eloquent;

use DB;
use App\Price;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class PriceRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Price';
	}

	/**
	 * Check if price exists for our product
	 * @param $productId
	 * @param $price
	 *
	 * @return boolean
	 */
	public function checkPrice($productId, $price)
	{
	    return Price::where('product_id', $productId)
	    			->where('price', $price)
	    			->count() > 0;
	}

}

?>