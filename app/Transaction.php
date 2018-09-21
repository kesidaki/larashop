<?php

namespace App;

use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\TransactionTransformer;

class Transaction extends Model {

    public $transformer = TransactionTransformer::class;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
    	'quantity',
    	'order_id',
    	'product_id',
        'total'
    ];

    public function order() 
    {
		return $this->belongsTo(Order::class);
	}

	public function product() 
    {
		return $this->belongsTo(Product::class);
	}
}
