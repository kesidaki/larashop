<?php

namespace App;

use App\Filter;
use App\Filter_product;
use Illuminate\Database\Eloquent\Model;

class FilterValue extends Model
{
    protected $fillable = [
    	'filter_id', 
		'value'
    ];

    public function filter() 
    {
    	return $this->Filter(Product::class);
    }

    public function productFilters() 
    {
		return $this->hasMany(Filter_product::class);
	}
}
