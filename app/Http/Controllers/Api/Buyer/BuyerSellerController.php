<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer) {
        // A little more complex operation
        // - We go to buyers and get the transactions
        // - Connect those transactions with the Product.Seller (seller function on product model)
        // and get the result
        // - Use pluck to only get the seller information inside of the product object
        // - Use unique id to not get duplicate sellers
        // - Use values() to make sure there are no empty spaces when duplicate sellers

        $sellers = $buyer->transactions()
                         ->with('product.seller')
                         ->get()
                         ->pluck('product.seller')
                         ->unique('id')
                         ->values();

        return $this->showAll($sellers);
    }
}
