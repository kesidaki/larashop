<?php

namespace App\Http\Controllers\Api\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Eloquent\ProductRepository;
use App\Http\Controllers\Api\ApiController;

class ProductController extends ApiController {
    public $products;

    public function __construct(ProductRepository $resProducts) {
        // $this->middleware('client.credentials')->only(['index', 'show']);

        $this->products = $resProducts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        # inputs from get request
        $getCat    = $request->categories;
        $getSubCat = $request->subcategories;

        # format inputs to arrays if they are not empty
        $categories    = ($getCat != '') ? explode(',',$getCat) : [];
        $subcategories = ($getSubCat != '') ? explode(',',$getSubCat) : [];

        # get products
        $products = $this->products->getProducts($categories, $subcategories, '', $request);

        return $this->showAll($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $product =  $this->products->getProduct($slug);
        
        return $this->showOne($product);
    }
}
