<?php

namespace App\Transformers;

use App\Price;
use League\Fractal\TransformerAbstract;

class PriceTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Price $price)
    {
        return [
            'identifier'   => (int) $price->id,
            'product'      => (int) $price->product_id,
            'price'        => (float) $price->price,
            'tax'          => (float) $price->tax,
            'full_price'   => (float) $price->with_tax,
            'desc'         => (string) $price->description,
            'creationDate' => (string) date('d/m/Y H:i', strtotime($price->created_at)),
            'lastChanged'  => (string) date('d/m/Y H:i', strtotime($price->updated_at)),
        ];
    }

    public static function originalAttribute($index) 
    {
        $attributes = [
            'identifier'   => 'id',
            'product'      => 'product_id',
            'price'        => 'price',
            'tax'          => 'tax',
            'full_price'   => 'with_tax',
            'creationDate' => 'created_at',
            'lastChanged'  => 'updated_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) 
    {
        $attributes = [
            'id'          => 'identifier',
            'product_id'  => 'product',
            'price'       => 'price',
            'tax'         => 'tax',
            'with_tax'    => 'full_price',
            'created_at'  => 'creationDate',
            'updated_at'  => 'lastChanged'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
