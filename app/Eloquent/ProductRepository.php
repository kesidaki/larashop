<?php
namespace App\Eloquent;

use DB;
use App\Seller;
use App\Product;
use App\Category;
use App\Transaction;
use App\Eloquent\Repository;
use Illuminate\Http\Request;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends Repository 
{ 

	public $categories;

	function model() 
	{ 
		return 'App\Product';
	}

	/**
	* Website's backbone
	* Returns the products
	* Filters when necessary
	* @param $categories
	* @param $subcategories
	* @param $search
	*
	* @return collection
	*/
	public function getProducts($categories, $subcategories, $search, Request $request) 
	{
		$today = date('Y-m-d');

		// Select
		$product = Product::select(
			'products.*', 
			'prices.price as product_price',
			'prices.with_tax as product_price_wt', 
			'discounts.discount as discount',
			DB::raw('(prices.with_tax * discount / 100) as discounted')
		);

		// Left Join Lowest Price (for sorting purpose)
		$product->leftJoin('prices', function($leftJoin) {
			$leftJoin->on('prices.product_id', '=', 'products.id');
			$leftJoin->on('prices.with_tax', '=', DB::raw('
					(SELECT MIN(prices.with_tax)
					FROM prices
					WHERE prices.product_id = products.id)
				')
			);
		});

		// Left Join Discount if exists
		$product->leftJoin('discounts', function($leftJoin) use ($today) {
			$leftJoin->on('discounts.product_id', '=', 'products.id');
			$leftJoin->where('discounts.expires', '>=', $today);
		});

		// Filter by category if necessary
		foreach ($categories as $category) {
			$product->whereHas('categories', function ($whereHas) use ($category) {
				$whereHas->where('slug', '=', $category);
			});
		}

		// Filter by Search Term
		if ($search != '') {
			// Like product name, slug or sku
			$product->where('name', 'like', '%'.$search.'%');
			$product->orWhere('slug', 'like', '%'.$search.'%');
			$product->orWhere('sku', 'like', '%'.$search.'%');

			// Where like category name or sku
			$product->orWhereHas('categories', function ($whereHas) use ($search) {
				$whereHas->where('name', 'like', '%'.$search.'%');
				$whereHas->orWhere('slug', 'like', '%'.$search.'%');
			});
		}

		// Filter by subcategory if necessary
		foreach ($subcategories as $subcategory) {
			$product->whereHas('subcategories', function ($whereHas) use ($subcategory) {
				$whereHas->where('slug', '=', $subcategory);
			});
		}

		// Filter by Brand
		if ($request->brand) {
			$product->whereHas('brand', function ($whereHas) use ($request) {
				$whereHas->where('name', '=', $request->brand);
				$whereHas->orWhere('slug', '=', $request->brand);
			});
		}

		// Filter by Minimum Price
		if ($request->minPrice) {
			$product->where('prices.with_tax', '>=', $request->minPrice);
		}

		// Filter by Maximum Price
		if ($request->maxPrice) {
			$product->where('prices.with_tax', '<=', $request->maxPrice);
		}

		// Only if product has prices and categories
		$product->whereHas('categories');
		$product->whereHas('prices');

		// Only if there is any product left
		// $product->where('quantity', '>', 0);

		// Sorting of the results
		if ($request->sort) {
			if ($request->sort == 'priceAsc') {
				$product->orderBy('product_price', 'asc');
			}
			else if ($request->sort == 'priceDesc') {
				$product->orderBy('product_price', 'desc');
			}
			else if ($request->sort == 'recent') {
				$product->orderBy('created_at', 'desc');
			}
		}
		else {
			$product->orderBy('product_price', 'asc');
		}

		// Get relationship information
		$product->with([
			'prices'
		]);
		
		// Return collection
		return $product->get();
	}

	/**
	* Website's backbone
	* Returns the products all the products for categories
	* Used to generate filters
	* @param $categories
	* 
	* @return collection
	*/
	public function getUnfilteredProducts($categories) 
	{
		$product = Product::select(
			'products.*'
		);

		// Filter by category if necessary
		foreach ($categories as $category) {
			$product->whereHas('categories', function ($whereHas) use ($category) {
				$whereHas->where('slug', '=', $category);
			});
		}

		// Only if product has prices and categories
		$product->whereHas('categories');
		$product->whereHas('prices');

		return $product->get();
	}

	/**
	* Returns minimum and maximum price for a set collection
	* @param product
	*
	* @return array
	*/
	public function getMinMax(Collection $product) 
	{
		$prices = $product->pluck('prices')
						  ->collapse()
						  ->unique('with_tax')
						  ->values();

		return [
			'minPrice' => $prices->min('with_tax'),
			'maxPrice' => $prices->max('with_tax')
		];
	}

	/**
	* Returns categories of a set collection
	* @param product, collection of products
	* @param category
	*
	* @return array
	*/
	public function getSubcategories(Collection $product, $category) 
	{
		$response   = [];

		$categories = $product->pluck('subcategories')
						  ->collapse()
						  ->unique('name')
						  ->values();

		foreach ($categories as $category) {
			$response[] = [
				'name' => $category->name,
				'slug' => $category->slug
			];
		}

		return $response;
	}

	/**
	* Returns brands of products
	* @param product, collection of products
	*
	* @return collection
	*/
	public function getBrands(Collection $product) 
	{
		$array  = []; 
		$brands = $product->pluck('brand')
						  ->unique('name')
						  ->pluck('name')
						  ->values();

		return $brands;
	}

	/**
	* Get a single product with it's relationships
	* @param slug
	*
	* @return model
	*/	
	public function getProduct($slug) 
	{
		$today = date('Y-m-d');

		// Select
		$query = Product::select(
			'products.*', 
			'prices.price as product_price',
			'prices.with_tax as product_price_wt',
			'discounts.discount as discount',
			DB::raw('(prices.with_tax * discount / 100) as discounted')
		);

		// Left Join Lowest Price (for sorting purpose)
		$query->leftJoin('prices', function($leftJoin) {
			$leftJoin->on('prices.product_id', '=', 'products.id');
			$leftJoin->on('prices.with_tax', '=', DB::raw('
					(SELECT MIN(prices.with_tax)
					FROM prices
					WHERE prices.product_id = products.id)
				')
			);
		});

		// Left Join Discount if exists
		$query->leftJoin('discounts', function($leftJoin) use ($today) {
			$leftJoin->on('discounts.product_id', '=', 'products.id');
			$leftJoin->where('discounts.expires', '>=', $today);
		});

		// Where Slug matches
		$query->where('slug', '=', $slug);

		// Get Product Entry
		$product  = $query->firstOrFail(); 

		// Get rest of the information
		$product->with([
			'categories',
			'subcategories',
			'gallery',
			'transactions',
			'prices'
		]);

		return $product;
	}

}

?>