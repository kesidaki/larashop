<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer) {
        return $this->showAll($buyer->transactions);
    }

}
