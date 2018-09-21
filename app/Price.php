<?php

namespace App;

use App\Product;
use App\Transformers\PriceTransformer;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public $transformer = PriceTransformer::class;
    
    protected $fillable = [
    	'product_id', 
    	'price', 
    	'tax', 
    	'with_tax', 
    	'description'
    ];

    public function product() 
    {
    	return $this->belongsTo(Product::class);
    }
}
