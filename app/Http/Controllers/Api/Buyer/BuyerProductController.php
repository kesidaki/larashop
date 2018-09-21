<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer) {
        // Transactions is a collection, since a buyer can have many transactions
        // - The standard $buyer->transactions->products
        // would not work since it has to return all products for each transaction
        // - So, what we do is get the collection by using $buyer->transactions()
        // and then, on that collection we say to combine it with the products it refers to
        // using the ->with('products')->get()
        // - Use the pluck('product') method as an extender to tell it to only return the product part
        // of the collection
        return $this->showAll($buyer->transactions()
                                    ->with('product')
                                    ->get()
                                    ->pluck('product')
                                );
    }
}
