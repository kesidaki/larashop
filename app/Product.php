<?php

namespace App;

use App\Brand;
use App\Price;
use App\Action;
use App\Seller;
use App\Gallery;
use App\Category;
use App\Discount;
use App\Subcategory;
use App\Transaction;
use App\Filter_product;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {

	use SoftDeletes;

	public $transformer = ProductTransformer::class;
	protected $dates    = ['deleted_at'];
	protected $hidden   = ['pivot'];
    protected $fillable = [
    	'sku',
    	'name',
    	'slug',
    	'description',
    	'quantity',
    	'status',
    	'thumb',
    	'image',
    	'seller_id',
    	'brand_id'
    ];


    const AVAILABLE_PRODUCT   = 'available';
	const UNAVAILABLE_PRODUCT = 'unavailable';

	public function isAvailable() 
	{
		return $this->status == Product::AVAILABLE_PRODUCT;
	}

    public function seller() 
    {
		return $this->belongsTo(Seller::class);
	}

	public function brand() 
	{
		return $this->belongsTo(Brand::class);
	}

	public function transactions() 
	{
		return $this->hasMany(Transaction::class);
	}

	public function categories() 
	{
		return $this->belongsToMany(Category::class);
	}

	public function subcategories() 
	{
		return $this->belongsToMany(Subcategory::class);
	}

	public function prices() 
	{
		return $this->hasMany(Price::class)->orderBy('price', 'asc');
	}

	public function gallery() 
	{
		return $this->hasMany(Gallery::class);
	}

	public function actions() 
	{
		return $this->hasMany(Action::class);
	}

	public function discount() 
	{
		return $this->hasOne(Discount::class)->where('expires', '>=', date('Y-m-d'));
	}

	public function productFilters() 
	{
		return $this->hasMany(Filter_product::class);
	}
}
