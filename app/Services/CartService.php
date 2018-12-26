<?php

namespace App\Services;

use Cart;
use Illuminate\Http\Request;
use App\Product;

class CartService
{
    /**
     * Get all the Cart's Information
     *
     * @return array
     */
    public function getCartInfo(): array
    {
        return [
            'cart'     => Cart::content(),
            'subtotal' => Cart::subtotal(2, '.', ','),
            'tax'      => Cart::tax(2, '.', ','),
            'total'    => Cart::total(2, '.', ',')
        ];
    }

    /**
     * Add Product to cart
     *
     * @param Product $product
     * @param float $price
     * @return void
     */
    public function addToCart(Product $product, $price)
    {
        $discount = $product->discount;

        if ($discount) {
            $price = round((($price * $discount->discount) / 100), 2);
        }

        Cart::add([
    		'id'      => $product->id,
    		'name'    => $product->name,
    		'qty'     => 1,
    		'price'   => $price,
    		'options' => [
    			'img' => $product->thumb
    		]
    	]);
    }

    /**
     * Increase qty of product in cart
     *
     * @param int $id
     * @return void
     */
    public function increaseQty($id)
    {
        $item   = $this->searchCart($id);
        $newQty = $item->first()->qty + 1;

        Cart::update($item->first()->rowId, $newQty);
    }

    /**
     * Decrease qty of product in cart
     *
     * @param int $id
     * @return void
     */
    public function decreaseQty($id)
    {
        $item   = $this->searchCart($id);
        $newQty = $item->first()->qty - 1;

        Cart::update($item->first()->rowId, $newQty);
    }

    /**
     * Delete an item from the cart
     *
     * @param int $id
     * @return void
     */
    public function deleteItem($id)
    {
        $item   = $this->searchCart($id);

        Cart::remove($item->first()->rowId);
    }

    /**
     * Destroy cart content
     *
     * @return void
     */
    public function destroyCart()
    {
        Cart::destroy();
    }

    /**
     * Search cart for a product with the given $id
     *
     * @param int $id
     * @return void
     */
    private function searchCart($id)
    {
        return Cart::search(function($cartItem, $rowId) use ($id) {
            return $cartItem->id === (int)$id;
        });
    }
}