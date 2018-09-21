<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
	protected $hidden   = ['pivot'];
    protected $fillable = [
    	'product_id', 
		'discount',
		'expires'
    ];

    public function product() 
    {
    	return $this->belongsTo(Product::class);
    }
}
