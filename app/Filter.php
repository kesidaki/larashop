<?php

namespace App;

use App\FilterValue;
use App\Filter_product;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
    	'category_id', 
		'name',
		'slug'
    ];

    public function values() 
    {
    	return $this->hasMany(FilterValue::class);
    }

    public function productFilters() 
    {
		return $this->hasMany(Filter_product::class);
	}
}
