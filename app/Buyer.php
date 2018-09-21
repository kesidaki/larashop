<?php

namespace App;

use App\User;
use App\Order;
use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User {

	public $transformer = BuyerTransformer::class;

	/**
	* We want to extend the functionality of the model's boot method.
	* So, we call the parent to make sure we don't loose if basic functions
	* And add a call to a the Scope, so that every time it wants to retrieve the buyers
	* it will automatically apply the restriction has('transations')
	*/
	protected static function boot() 
	{
		parent::boot();

		static::addGlobalScope(new BuyerScope);
	}

    public function orders() 
    {
		return $this->hasMany(Order::class);
	}
}
