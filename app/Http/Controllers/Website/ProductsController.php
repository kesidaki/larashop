<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\ActionService;

class ProductsController extends Controller
{
    /**
    * Products Page
    * @param cat1
    * @param cat2
    * @param cat3
    * @param request
    * @param ProductService
    */
    public function index($cat1='', $cat2='', $cat3='', Request $request, ProductService $productService) 
    {
    	$data = $productService->prepareProductsIndex($cat1, $cat2, $cat3, $request);

    	return view('products.index', $data);
    }

    /**
     * Search for product by term criteria
     *
     * @param string $term
     * @param Request $request
     * @param ProductService $productService
     * @return void
     */
    public function search($term, Request $request, ProductService $productService) 
    {
        $products = $productService->searchProducts($term, $request);

        return view('products.search', [
            'products' => $products,
        ]);
    }

    /**
     * Single Product Page
     *
     * @param string $slug
     * @param Request $request
     * @param ProductService $productService
     * @param ActionService $actionService
     * @return void
     */
    public function product($slug, Request $request, ProductService $productService, ActionService $actionService) 
    {
        $product = $productService->findProduct($slug);
        $actionService->storeVisit('view', $product->id, '', $request->ip());

        return view('products.info', [
            'product' => $product
        ]);
    }

}
