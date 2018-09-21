<?php

namespace App;

use App\Product;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
    	'category_id',
    	'name',
    	'slug',
    	'description'
    ];

    public function products() 
    {
    	return $this->belongsToMany(Product::class);
    }
}
