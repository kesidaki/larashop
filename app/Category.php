<?php

namespace App;

use App\Product;
use App\Subcategory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model 
{
	public $transformer = CategoryTransformer::class;
	protected $dates    = ['deleted_at'];
	protected $hidden   = ['pivot'];
    protected $fillable = [
    	'name', 
    	'slug', 
    	'description'
    ];

    public function products() 
    {
		return $this->belongsToMany(Product::class);
	}

	public function subcategories() 
	{
		return $this->hasMany(Subcategory::class);
	}
}
