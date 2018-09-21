<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
    	'product_id', 
    	'image', 
    	'description'
    ];

    public function product() 
    {
    	return $this->belongsTo(Product::class);
    }
}
