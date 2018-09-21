<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public $transformer = TransactionTransformer::class;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
    	'order_id',
        'code',
    	'type',
    	'series',
        'number',
        'cancelled'
    ];

    public function order() 
    {
		return $this->belongsTo(Order::class);
	}
}
