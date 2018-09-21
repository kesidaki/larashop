<?php

namespace App\Http\Controllers\Api\Product;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class ProductCategoryController extends ApiController
{
    public function __construct() {
        # $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product) {
        $categories = $product->categories;

        return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category) {

        //attach, sync, syncWithoutDetaching
        //attach: add a category to the product
        //sync: adds the category BUT detatches everything else
        //syncWithoutDetaching: add but without removing previous ones
        $product->categories()
                ->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category) {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('The product does not have specified category', 404);
        }

        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);
    }
}
