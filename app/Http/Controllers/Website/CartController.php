<?php

namespace App\Http\Controllers\Website;

use Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\ProductService;
use App\Services\ActionService;
use App\Http\Controllers\Website\Controller;

class CartController extends Controller
{
	/**
     * Cart Page
     *
     * @param CartService $cartService
     * @return void
     */
	public function index(CartService $cartService) 
    {
        $cart = $cartService->getCartInfo();
		return view('cart.index', $cart);
	}

	/**
     * Add a Product to Cart
     *
     * @param Request $request
     * @param ProductService $productService
     * @param CartService $cartService
     * @param ActionService $actionService
     * @return void
     */
    public function add(Request $request, ProductService $productService, CartService $cartService, ActionService $actionService) 
    {
        $price   = $request->product_price;
        $product = $productService->checkProduct($request->product_id, $price);

        if (!$product) {
            return redirect()->back()->withErrors('msg', 'Η τιμή αυτή δε βρέθηκε για το προϊόν');
        }

        $cartService->addToCart($product, $price);
        $actionService->storeVisit('cart_add', $product->id, '', $request->ip());

    	return redirect()->back()->with('productAdded', $product);
    }

    /**
     * Increase Product qty in cart
     *
     * @param Request $request
     * @param CartService $cartService
     * @param ActionService $actionService
     * @return void
     */
    public function increase(Request $request, CartService $cartService, ActionService $actionService) 
    {
    	if ($id = $request->id) {
            $cartService->increaseQty($id);
            $actionService->storeVisit('cart_add', $id, '', $request->ip());
    	}

    	return redirect()->back();
    }

    /**
     * Decrease Product qty in cart
     *
     * @param Request $request
     * @param CartService $cartService
     * @param ActionService $actionService
     * @return void
     */
    public function decrease(Request $request, CartService $cartService, ActionService $actionService) 
    {
    	if ($id = $request->id) {
            $cartService->decreaseQty($id);
            $actionService->storeVisit('cart_rm', $id, '', $request->ip());
    	}

    	return redirect()->back();
    }

    /**
     * Delete Product from cart
     *
     * @param Request $request
     * @param CartService $cartService
     * @param ActionService $actionService
     * @return void
     */
    public function delete(Request $request, CartService $cartService, ActionService $actionService) 
    {
    	if ($id = $request->id) {
            $cartService->deleteItem($id);
            $actionService->storeVisit('cart_rm', $id, '', $request->ip());
    	}

    	return redirect()->back();
    }
}
