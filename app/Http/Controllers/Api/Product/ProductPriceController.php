<?php

namespace App\Http\Controllers\Api\Product;

use App\Product;
use App\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class ProductPriceController extends ApiController
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
        $prices = $product->prices;

        return $this->showAll($prices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Price $price) {

        //attach, sync, syncWithoutDetaching
        //attach: add a price to the product
        //sync: adds the price BUT detatches everything else
        //syncWithoutDetaching: add but without removing previous ones
        $product->prices()
                ->syncWithoutDetaching([$price->id]);

        return $this->showAll($product->prices);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Price $price) {
        if (!$product->prices()->find($price->id)) {
            return $this->errorResponse('The product does not have specified price', 404);
        }

        $product->prices()->detach($price->id);

        return $this->showAll($product->prices);
    }
}
