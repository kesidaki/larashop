<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Eloquent\ActionRepository;
use App\Eloquent\ProductRepository;
use App\Traits\CollectionManipulationTrait;

class HomeController extends Controller
{
    use CollectionManipulationTrait;
    
    public $actions;
    public $products;

    public function __construct(ActionRepository $resAction, ProductRepository $resProducts) 
    {
        $this->actions  = $resAction;
        $this->products = $resProducts;
    }

    /**
    * Website Index Page
    */
    public function index(Request $request) 
    {
        $request->request->add(['sort' => 'recent']);
        $products = $this->products->getProducts([], [], '', $request);

        $data = [
            'mostViewed' => $this->actions->mostViewedProducts(30, 10),
            'mostRecent' => $this->paginateData($products)
        ];

        return view('welcome', $data);
    }

    /**
    * Website Contact Us Page
    */
    public function epikoinonia(Request $request) 
    {
        return view('epikoinonia', []);
    }

    /**
    * Website Terms of Use Page
    */
    public function oroiXrisis(Request $request) 
    {
        return view('oroi-xrisis', []);
    }
}
