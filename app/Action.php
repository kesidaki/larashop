<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
	protected $hidden   = ['pivot'];
    protected $fillable = [
    	'type', 
    	'product_id', 
		'url',
		'visitor'
    ];

    public function product() 
    {
    	return $this->belongsTo(Product::class);
    }
}
