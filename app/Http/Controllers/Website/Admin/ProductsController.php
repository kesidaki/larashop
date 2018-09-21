<?php

namespace App\Http\Controllers\Website\Admin;

use PDF;
use Image;
use App\Product;
use App\Libraries\MyLibrary;
use Illuminate\Http\Request;
use App\Eloquent\BrandRepository;
use App\Eloquent\OrderRepository;
use App\Eloquent\PriceRepository;
use App\Eloquent\StateRepository;
use App\Eloquent\OptionRepository;
use App\Eloquent\ProductRepository;
use App\Eloquent\ReceiptRepository;
use App\Eloquent\CategoryRepository;
use App\Eloquent\ShippingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Eloquent\SubcategoryRepository;
use App\Eloquent\TransactionRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Website\Controller;

class ProductsController extends Controller
{
    public $products;
    public $categories;
    public $subcategories;
    public $brands;
    public $prices;
    public $options;
    public $orders;
    public $transactions;
    public $states;
    public $shipping;
    public $receipts;

    public $myLibrary;

    public $thumbnailSize;
    private $productImgPath;
    private $productThumbPath;

    public function __construct(
    	ProductRepository $resProduct, 
    	CategoryRepository $resCategory,
        SubcategoryRepository $resSubcategory,
    	BrandRepository $resBrand,
    	PriceRepository $resPrice,
        OptionRepository $resOption,
        OrderRepository $resOrder,
        TransactionRepository $resTrans,
        StateRepository $resStates,
        ShippingRepository $resShip,
        ReceiptRepository $resReceipt,
        MyLibrary $myLib) 
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->products      = $resProduct;
        $this->categories    = $resCategory;
        $this->subcategories = $resSubcategory;
        $this->brands        = $resBrand;
        $this->prices        = $resPrice;
        $this->options       = $resOption;
        $this->orders        = $resOrder;
        $this->transactions  = $resTrans;
        $this->states        = $resStates;
        $this->shipping      = $resShip;
        $this->receipts      = $resReceipt;

        $this->myLibrary     = $myLib;

        $this->thumbnailSize    = 253;
        $this->productImgPath   = public_path('/products');
        $this->productThumbPath = public_path('/thumbnail');
    }

    /**
    * Admin Home Page
    * @param request
    */
    public function index(Request $request) 
    {
    	return view('admin.index', [
            'orders' => $this->orders->recent(5, $request)
        ]);
    }

    /**
    * Products Page
    * @param category
    */
    public function products($category='') 
    {
        $cat      = ($category == '') ? '' : $this->categories->findBy('slug', $category);
        $products = $this->products->allBy('name', 'asc');
    	$data = [
            'category' => $cat,
    		'products' => $products,
            'brands'   => $this->brands->allBy('name', 'asc'),
    		'tinymce'  => true
    	];

    	return view('admin.products', $data);
    }

    /**
    * Product Page, expects product ID
    * @param id
    */
    public function product($id) 
    {
        $product = $this->products->getProduct($id);
    	$data = [
    		'product'       => $product,
    		'categories'    => $this->categories->allBy('name', 'asc'),
            'subcategories' => $this->subcategories->getGrouped($product->categories),
    		'brands'        => $this->brands->all(),
    		'tinymce'       => true
    	];

    	return view('admin.product', $data);
    }

    /**
    * Create Product
    * @param request
    */
    public function createProduct(Request $request) 
    {
    	$rules = [
            'name'        => 'required',
            'sku'         => 'required',
            'slug'        => 'required',
            'quantity'    => 'required|integer|min:0',
            'image'       => 'required|image',
            'description' => 'required'
        ];

        $this->validate($request, $rules);

        $data              = $request->all();
        $data['seller_id'] = Auth::user()->id;
        $data['status']    = ($request->quantity > 0) ? Product::AVAILABLE_PRODUCT : Product::UNAVAILABLE_PRODUCT;
        
        // Upload Image and get some data for it
		$image              = $request->file('image');
		$imagename          = $this->storeImage($image, $data['slug']);

        $data['image'] = $imagename;
        $data['thumb'] = $imagename;

        $newId = $this->products->create($data);

        return redirect('/admin/products/');
    }

    /**
    * Delete Product
    * @param request
    */
    public function deleteProduct(Request $request) 
    {
        $id      = $request->id;
        $product = $this->products->delete($id);

        return redirect('/admin/products');
    }

    /**
    * Update Product Information
    * @param request
    */
    public function updateProductInfo(Request $request) 
    {
    	$id      = $request->id;
    	$product = $this->products->find($id);

    	// Validate input
    	$rules   = [
            'name'        => 'required',
            'slug'        => 'required',
            'sku'         => 'required',
            'quantity'    => 'required|integer|min:0'
        ];
        $this->validate($request, $rules);

        // Load input on a Data array
        $data = [
        	'name'        => $request->name,
        	'slug'        => $request->slug,
        	'sku'         => $request->sku,
        	'quantity'    => $request->quantity,
        	'description' => $request->description,
        	'status'      => ($request->quantity > 0) ? Product::AVAILABLE_PRODUCT : Product::UNAVAILABLE_PRODUCT,
            'brand_id'    => $request->brand
        ];

        // Replace image if necessary by deleting the previous one
        if ($request->hasFile('image')) {
            // Delete Previous File
            Storage::delete($product->image);

            // Upload Image and get some data for it
            $image              = $request->file('image');
            $imagename          = $this->storeImage($image, $product->slug);

            $data['image'] = $imagename;
            $data['thumb'] = $imagename;
        }

        $this->products->update($data, $id);

        return redirect()->back();
    }

    /**
    * Update Product Prices
    * @param request
    */
    public function updateProductPrices(Request $request) 
    {
    	// Read input
    	$id          = $request->id;
    	$prices      = $request->price;
    	$description = $request->description;

    	// Delete stored prices
    	$this->prices->deleteBy('product_id', $id);

    	if (is_array($prices)) {
            $tax = $this->options->getTax();

    		// Loop prices to add them anew
	    	foreach ($prices as $key=>$price) {
	    		$data = [
	    			'product_id'  => $id,
	    			'price'       => (float)$price,
                    'tax'         => (float)$price * $tax,
                    'with_tax'    => (float)$price * (1 + $tax),
	    			'description' => $description[$key]
	    		];
	    		$this->prices->create($data);
	    	}
    	}

    	return redirect()->back();
    }

    /**
    * Update Product Categories
    * @param request
    */
    public function updateProductCategories(Request $request) 
    {
    	// Data
    	$id         = $request->id;
    	$product    = $this->products->find($id);
    	$toSync     = [];
    	$categories = $request->categories;

    	if (is_array($categories) > 0) {
    		// Store the id of the categories
	    	foreach ($categories as $category) {
	    		$get = $this->categories->findBy('name', $category);
	    		if ($get) {
	    			array_push($toSync, $get->id);
	    		}
	    	}
    	}

    	// Sync to pivot table
    	$product->categories()->sync($toSync);

    	return redirect()->back();
    }

    /**
    * Update Product Categories
    * @param request
    */
    public function updateProductSubcategories(Request $request) 
    {
        // Data
        $id            = $request->id;
        $product       = $this->products->find($id);
        $toSync        = [];
        $subcategories = $request->subcategories;

        if (is_array($subcategories) > 0) {
            // Store the id of the categories
            foreach ($subcategories as $category) {
                $get = $this->subcategories->findBy('name', $category);
                if ($get) {
                    array_push($toSync, $get->id);
                }
            }
        }

        // Sync to pivot table
        $product->subcategories()->sync($toSync);

        return redirect()->back();
    }

    /**
    * Store Product Image and creates a thumbnail
    * For thumbnail: 
    *   Resizes image to set proportions ($thumbnailSize) while keeping the aspect intact
    *   Then, place the image at the center of a square canvas, 
    *   to make sure the thumbnail is a set height and width
    * Save Image and Thumbnail on their respective directories
    * And return the name used to store the images
    * @param image
    * @param name
    */
    private function storeImage($image, $name) {
        $imagename          = $name.'.'.$image->getClientOriginalExtension();
        $img                = Image::make($image->getRealPath());

        // Create Canvas for thumbnail
        $canvas = Image::canvas($this->thumbnailSize, $this->thumbnailSize);
        // Save to thumbnail
        $img->resize($this->thumbnailSize, $this->thumbnailSize, function ($constraint) {
            $constraint->aspectRatio();
        });
        // Insert the image on the center of the canvas and then save it
        $canvas->insert($img, 'center');
        $canvas->save($this->productThumbPath.'/'.$imagename);
        // Save to Image
        $image->move($this->productImgPath, $imagename);

        return $imagename;
    }
}
