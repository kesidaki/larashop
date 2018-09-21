<?php

namespace App;

use App\User;
use App\Product;
use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\Model;

class Seller extends User {

	public $transformer = SellerTransformer::class;

	/**
	* We want to extend the functionality of the model's boot method.
	* So, we call the parent to make sure we don't loose basic functions
	* And add a call to the Scope, so that every time it wants to retrieve the sellers
	* it will automatically apply the restriction has('products')
	*/
	protected static function boot() 
	{
		parent::boot();

		static::addGlobalScope(new SellerScope);
	}

    public function products() 
    {
		return $this->hasMany(Product::class);
	}
}
