<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier'   => (int) $transaction->id,
            'qty'          => (int) $transaction->quantity,
            'buyer'        => (int) $transaction->buyer_id,
            'product'      => (int) $transaction->product_id,
            'creationDate' => (string) date('d/m/Y H:i', strtotime($transaction->created_at)),
            'lastChanged'  => (string) date('d/m/Y H:i', strtotime($transaction->updated_at)),
            'deletedDate'  => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,

            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('transactions.show', $transaction->id)
                ],
                [
                    'rel'  => 'transaction.categories',
                    'href' => route('transactions.categories.index', $transaction->id)
                ],
                [
                    'rel'  => 'transaction.seller',
                    'href' => route('transactions.sellers.index', $transaction->id)
                ],
                [
                    'rel'  => 'buyer',
                    'href' => route('buyers.show', $transaction->buyer_id)
                ],
                [
                    'rel'  => 'product',
                    'href' => route('products.show', $transaction->product_id)
                ],
            ]
        ];
    }

    public static function originalAttribute($index) 
    {
        $attributes = [
            'identifier'   => 'id',
            'qty'          => 'quantity',
            'buyer'        => 'buyer_id',
            'product'      => 'product_id',
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
            'quantity'    => 'qty',
            'buyer_id'    => 'buyer',
            'product_id'  => 'product',
            'created_at'  => 'creationDate',
            'updated_at'  => 'lastChanged',
            'deleted_at'  => 'deletedDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
