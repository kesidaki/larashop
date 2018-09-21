<?php

namespace App\Http\Controllers\Api\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product) {
        $buyers = $product->transactions()
                          ->with('buyer')
                          ->get()
                          ->pluck('buyer')
                          ->unique('id')
                          ->values();

        return $this->showAll($buyers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
    }
}
