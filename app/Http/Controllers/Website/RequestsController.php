<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Website\Controller;
use App\Services\ProductService;
use App\Services\ActionService;

class RequestsController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /**
    * Return Products for a search term
    * @param request
    * @param ProductService $productService
    */
    public function products(Request $request, ProductService $productService) 
    {
        $data = $productService->getProducts([], [], $request->get('term'), $request);

    	return response()->json($data);
    }

    /**
    * Return Statistics for Visits
    * @param request
    * @param ActionService $actionService
    */
    public function visits(Request $request, ActionService $actionService) 
    {
        $days = $request->forDays;
        $data = $actionService->mostVisits($days);
        return response()->json($data)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    /**
    * Return Statistics for Product
    * @param id
    * @param request
    */
    public function product($id, Request $request, ActionService $actionService) 
    {
        $data = $actionService->productStatistics($id, $request);
        return response()->json($data)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
