<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Eloquent\ActionRepository;
use App\Eloquent\ProductRepository;
use App\Eloquent\CategoryRepository;
use App\Eloquent\SubcategoryRepository;
use App\Traits\CollectionManipulationTrait;

class ProductsController extends Controller
{
    use CollectionManipulationTrait;

	public $products;
    public $categories;
    public $subcategories;
    public $actions;

    public function __construct(ProductRepository $resProduct, CategoryRepository $resCategory, SubcategoryRepository $resSubcategory, ActionRepository $resAction) 
    {
        $this->products      = $resProduct;
        $this->categories    = $resCategory;
        $this->subcategories = $resSubcategory;
        $this->actions       = $resAction;
    }

    /**
    * Products Page
    * @param cat1
    * @param cat2
    * @param cat3
    * @param request
    */
    public function index($cat1='', $cat2='', $cat3='', Request $request) 
    {
        // Data: Product Categories
        $categories = [];
        if ($cat1 != '') {
            array_push($categories, $cat1);
        }
        if ($cat2 != '') {
            array_push($categories, $cat2);
        }
        if ($cat3 != '') {
            array_push($categories, $cat3);
        }

        // Data: Product Subcategories
        if ($request->get('categories') == '') {
            $subcategories = [];
        }
        else {
            $subcategories = explode(',',$request->get('categories'));
        }

        // Data: Filtered Products and the filters they provide
        $products = $this->products->getProducts($categories, $subcategories, '', $request);
        $prices   = $this->products->getMinMax($products);

        // Data: Unfiltered Products and the filters they provide
        $ufProducts = $this->products->getUnfilteredProducts($categories);
        $subCats    = $this->products->getSubcategories($ufProducts, '');
        $brands     = $this->products->getBrands($ufProducts);

        // Further Products Manipulation
        $products = $this->paginateData($products, 8);
        $products = $this->cacheResponse($products);

        // Send to View
    	$data = [
            'categories'      => implode('/' , $categories),
    		'products'        => $products,
            'active'          => [
                'subcategories'   => implode(',' , $subcategories),
                'brand'           => $request->brand,
                'minPrice'        => ($request->minPrice != '') ? $request->minPrice : $prices['minPrice'],
                'maxPrice'        => ($request->maxPrice != '') ? $request->maxPrice : $prices['maxPrice']
            ],
            'filter'          => [
                'prices'          => $prices,
                'avSubcategories' => $subCats,
                'brands'          => $brands
            ]
    	];

    	return view('products.index', $data);
    }

    /**
    * Search for product by term criteria
    * @param term
    */
    public function search($term, Request $request) 
    {
        $products = $this->products->getProducts([], [], $term, $request);
        $products = $this->paginateData($products);
        $products = $this->cacheResponse($products);

        return view('products.search', [
            'products' => $products,
        ]);
    }

    /**
    * Single Product Page
    * @param slug
    * @param ip
    */
    public function product($slug, Request $request) 
    {
        $product =  $this->products->getProduct($slug);
        $data    = [
            'product' => $product
        ];

        $this->actions->create([
            'type'       => 'view',
            'product_id' => $product->id,
            // 'visitor'    => $request->ip()
        ]);

        return view('products.info', $data);
    }

}
