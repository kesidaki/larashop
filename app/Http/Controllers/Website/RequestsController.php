<?php

namespace App\Http\Controllers\Website;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Eloquent\ActionRepository;
use App\Eloquent\ProductRepository;
use App\Eloquent\TransactionRepository;
use App\Http\Controllers\Website\Controller;

class RequestsController extends Controller
{
    public $products;
    public $actions;
    public $transactions;

    public function __construct(
    	ProductRepository $resProduct,
        ActionRepository $resAction,
        TransactionRepository $resTransaction) 
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->products      = $resProduct;
        $this->actions       = $resAction;
        $this->transactions  = $resTransaction;
    }

    /**
    * Return Products for a search term
    * @param request
    */
    public function products(Request $request) 
    {
    	$products = $this->products->getProducts([], [], $request->get('term'), $request);

    	return response()->json($products);
    }

    /**
    * Return Statistics for Visits
    * @param request
    */
    public function visits(Request $request) 
    {
        return response()->json($this->actions->statVisits($request->forDays))->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    /**
    * Return Statistics for Product
    * @param id
    * @param request
    */
    public function product($id, Request $request) 
    {
        // make dates
        $from    = Carbon::now()->subDays(($request->forDays) ? $request->forDays : 30)->format('Y-m-d H:i:s');
        $to      = Carbon::now()->format('Y-m-d H:i:s');

        // get sales and store them in array
        $sales   = $this->transactions->productSalesForPeriod($id, $from, $to);

        $labels  = ['Πωλήσεις'];
        $values  = [$sales];

        // get other info and store them
        $info    = $this->actions->statProduct($id, $request->forDays);
        foreach ($info as $row) {
            if ($row->type == 'view') {
                array_push($labels, 'Προβολές σελίδας');
                array_push($values, $row->count);
            }
            else if ($row->type == 'cart_add') {
                array_push($labels, 'Προσθήκες στο καλάθι');
                array_push($values, $row->count);
            }
            else if ($row->type == 'cart_rm') {
                array_push($labels, 'Αφαιρέσεις από το καλάθι');
                array_push($values, $row->count);
            }
        }

        // construct data to send
        $data = [
            'label' => $labels, 
            'value' => $values
        ];
        return response()->json($data)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
