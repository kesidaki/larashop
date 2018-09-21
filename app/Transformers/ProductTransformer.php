<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'   => (int) $product->id,
            'sku'          => (string) $product->sku,
            'title'        => (string) $product->name,
            'details'      => (string) $product->description,
            'qty'          => (int) $product->quantity,
            'situation'    => (string) $product->status,
            'thumb'        => url("public/thumbnail/{$product->thumb}"),
            'img'          => url("public/products/{$product->image}"),
            'seller'       => (int) $product->seller_id,
            'creationDate' => (string) date('d/m/Y H:i', strtotime($product->created_at)),
            'lastChanged'  => (string) date('d/m/Y H:i', strtotime($product->updated_at)),
            'deletedDate'  => isset($product->deleted_at) ? (string) $product->deleted_at : null,

            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('products.show', $product->id)
                ],
                [
                    'rel'  => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id)
                ],
                [
                    'rel'  => 'product.categories',
                    'href' => route('products.categories.index', $product->id)
                ],
                [
                    'rel'  => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id)
                ],
                [
                    'rel'  => 'product.seller',
                    'href' => route('sellers.show', $product->seller_id)
                ],
                [
                    'rel'  => 'product.prices',
                    'href' => route('products.prices.index', $product->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index) 
    {
        $attributes = [
            'identifier'   => 'id',
            'sku'          => 'sku',
            'title'        => 'name',
            'details'      => 'description',
            'qty'          => 'quantity',
            'situation'    => 'status',
            'img'          => 'image',
            'seller'       => 'seller_id',
            'creationDate' => 'created_at',
            'lastChanged'  => 'updated_at',
            'deletedDate'  => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) 
    {
        $attributes = [
            'id'          => 'identifier',
            'sku'         => 'sku',
            'name'        => 'title',
            'description' => 'details',
            'quantity'    => 'qty',
            'status'      => 'situation',
            'image'       => 'image',
            'seller_id'   => 'seller',
            'created_at'  => 'creationDate',
            'updated_at'  => 'lastChanged',
            'deleted_at'  => 'deletedDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
