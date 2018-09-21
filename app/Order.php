<?php

namespace App;

use App\Buyer;
use App\Receipt;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'buyer_id',
        'type',
    	'name',
        'profession',
        'doy',
        'afm',
    	'address',
    	'tk',
    	'city',
    	'state',
    	'country',
    	'phone',
    	'phone_2',
    	'email',
        'shipping_id',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'payment'
    ];

    public function buyer() 
    {
    	return $this->belongsTo(Buyer::class);
    }

    public function transactions() 
    {
    	return $this->hasMany(Transaction::class);
    }

    public function receipts() 
    {
        return $this->hasMany(Receipt::class);
    }
}
