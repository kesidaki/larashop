<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class TransactionCategoryController extends ApiController
{
	public function __construct() {
        $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction) {
        return $this->showAll($transaction->product->categories);
    }
}
