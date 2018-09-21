<?php

namespace App\Http\Controllers\Website;

use Auth;
use App\Libraries\MyLibrary;
use Illuminate\Http\Request;
use App\Eloquent\OrderRepository;
use App\Eloquent\StateRepository;
use App\Eloquent\ReceiptRepository;
use App\Eloquent\TransactionRepository;
use App\Http\Controllers\Website\Controller;

class AccountController extends Controller
{
	public $orders;
	public $transactions;
	public $receipts;
	public $states;
	public $myLibrary;

    public function __construct(
        OrderRepository $resOrder,
        TransactionRepository $resTrans,
        ReceiptRepository $resReceipt,
        StateRepository $resStates,
        MyLibrary $myLib) 
    {
        $this->middleware('auth');

        $this->orders        = $resOrder;
        $this->transactions  = $resTrans;
        $this->receipts      = $resReceipt;
        $this->states        = $resStates;

        $this->myLibrary     = $myLib;
    }

    /**
     * Account Index Page
     */
    public function index() 
    {
    	$user = Auth::user();

    	return view('account.index', [
    		'info'   => $user->address,
    		'orders' => $this->orders->allByOrdered('buyer_id', $user->id, 'created_at', 'desc')
    	]);
    }

    /**
     * Account Address Information Page
     */
    public function information() 
    {
    	$user = Auth::user();

    	return view('account.information', [
    		'states' => $this->states->allBy('name', 'asc'),
    		'info'   => $user->address
    	]);
    }
}
