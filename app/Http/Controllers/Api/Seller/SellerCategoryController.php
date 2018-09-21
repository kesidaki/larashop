<?php

namespace App\Http\Controllers\Api\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller) {
        $categories = $seller->products()
        					 ->whereHas('categories')
        					 ->with('categories')
        					 ->get()
        					 ->pluck('categories')
        					 ->collapse()
        					 ->unique('id')
        					 ->values();

        return $this->showAll($categories);
    }
}
