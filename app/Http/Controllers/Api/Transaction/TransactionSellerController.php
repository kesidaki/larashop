<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction) {
        return $this->showOne($transaction->product->seller);
    }
}
