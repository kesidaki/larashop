<?php

namespace App\Http\Controllers\Website;

use Cart;
use Illuminate\Http\Request;
use App\Eloquent\PriceRepository;
use App\Eloquent\ActionRepository;
use App\Eloquent\ProductRepository;
use App\Http\Controllers\Website\Controller;

class CartController extends Controller
{
	public $products;
    public $actions;
    public $prices;

	public function __construct(
        ProductRepository $resProduct,
        ActionRepository $resAction,
        PriceRepository $resPrice) 
    {
        $this->products   = $resProduct;
        $this->actions    = $resAction;
        $this->prices     = $resPrice;

    }

	/**
	* View Cart Page
	*/
	public function index() 
    {
		return view('cart.index', [
            'cart'     => Cart::content(),
            'subtotal' => Cart::subtotal(2, '.', ','),
            'tax'      => Cart::tax(2, '.', ','),
            'total'    => Cart::total(2, '.', ',')
        ]);
	}

	/**
	* Add a Product to Cart
    * @param request
	*/
    public function add(Request $request) 
    {
        // Get Product Information
    	$id       = $request->product_id;
    	$product  = $this->products->find($id);
        $discount = $product->discount;
        $prPrice  = $request->product_price;

        // Check if product price exists
        if (!$this->prices->checkPrice($id, $prPrice)) {
            return redirect()->back()->withErrors('msg', 'Η τιμή αυτή δε βρέθηκε για το προϊόν');
        }

        // Check if there is active discount for it, and alter price accordingly
        if ($discount) {
            $price = round((($prPrice * $discount->discount) / 100), 2);
        }
        else {
            $price = $prPrice;
        }

        // Add to cart
    	Cart::add([
    		'id'      => $product->id,
    		'name'    => $product->name,
    		'qty'     => 1,
    		'price'   => $price,
    		'options' => [
    			'img' => $product->thumb
    		]
    	]);

        // Add to User History Tracking
        $this->actions->create([
            'type'       => 'cart_add',
            'product_id' => $product->id,
            'visitor'    => $request->ip()
        ]);

    	return redirect()->back()->with('productAdded', $product);
    }

    /**
	* Increase Product qty in cart
    * @param request
	*/
    public function increase(Request $request) 
    {
    	if ($id = $request->id) {
            // search for the item
    		$item    = Cart::search(function($cartItem, $rowId) use ($id) {
    			return $cartItem->id === (int)$id;
    		});
            // update quantity
    		$newQty  = $item->first()->qty + 1;

            // In case we want a quantity check
    		// if ($newQty > $product->quantity) {
    		//    return redirect()->back()->with('error', 'Δεν υπάρχουν αρκετά διαθέσιμα: '.$product->name);
    		// }

            // Add to User History Tracking
            $this->actions->create([
                'type'       => 'cart_add',
                'product_id' => $id,
                'visitor'    => $request->ip()
            ]);

            // Update cart
    		Cart::update($item->first()->rowId, $newQty);
    	}

    	return redirect()->back();
    }

    /**
	* Decrease Product qty in cart
    * @param request
	*/
    public function decrease(Request $request) 
    {
    	if ($id = $request->id) {
            // Get item
    		$item   = Cart::search(function($cartItem, $rowId) use ($id) {
    			return $cartItem->id === (int)$id;
    		});

            // Add to User History Tracking
            $this->actions->create([
                'type'       => 'cart_rm',
                'product_id' => $id,
                'visitor'    => $request->ip()
            ]);

            // Update Cart with new quantity
    		Cart::update($item->first()->rowId, $item->first()->qty-1);
    	}

    	return redirect()->back();
    }

    /**
	* Delete Product from cart
    * @param request
	*/
    public function delete(Request $request) 
    {
    	if ($id = $request->id) {
            // Get Product
    		$item   = Cart::search(function($cartItem, $rowId) use ($id) {
    			return $cartItem->id === (int)$id;
    		});

            // Add to User History Tracking
            $this->actions->create([
                'type'       => 'cart_rm',
                'product_id' => $id,
                'visitor'    => $request->ip()
            ]);

            // Remove product from cart
    		Cart::remove($item->first()->rowId);
    	}

    	return redirect()->back();
    }
}
