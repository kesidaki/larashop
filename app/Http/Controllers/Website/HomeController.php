<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Traits\CollectionManipulationTrait;
use App\Services\ProductService;
use App\Services\ActionService;

class HomeController extends Controller
{    
    /**
     * Index Page
     *
     * @param Request $request
     * @param ActionService $actionService
     * @param ProductService $productService
     * @return void
     */
    public function index(Request $request, ActionService $actionService, ProductService $productService) 
    {
        $data = [
            'mostViewed' => $actionService->mostViewedProducts(),
            'mostRecent' => $productService->getRecentProducts($request),
        ];

        return view('welcome', $data);
    }

    /**
     * Contact Us
     *
     * @param Request $request
     * @return void
     */
    public function epikoinonia(Request $request) 
    {
        return view('epikoinonia', []);
    }

    /**
     * Terms of use
     *
     * @param Request $request
     * @return void
     */
    public function oroiXrisis(Request $request) 
    {
        return view('oroi-xrisis', []);
    }
}
