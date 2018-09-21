<?php

namespace App\Http\Controllers\Api\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller) {
        $transactions = $seller->products()
        					   ->whereHas('transactions')
        					   ->with('transactions')
        					   ->get()
        					   ->pluck('transactions')
        					   ->collapse();

        return $this->showAll($transactions);
    }
}
