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

class BrandsController extends Controller
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

        $this->thumbnailSize    = 200;
        $this->productImgPath   = public_path('/products');
        $this->productThumbPath = public_path('/thumbnail');
    }

    /**
    * Brands Page
    */
    public function brands() 
    {
        $data = [
            'brands'     => $this->brands->allBy('name', 'asc'),
            'tinymce'    => true
        ];

        return view('admin.brands', $data);
    }

    /**
    * Create Brand
    * @param request
    */
    public function createBrand(Request $request) 
    {
        $this->validate($request, [
            'name'        => 'required',
            'slug'        => 'required'
        ]);

        $this->brands->create($request->all());

        return redirect()->back();
    }

    /**
    * Update or Delete Brand
    * @param request
    */
    public function updateBrand(Request $request) 
    {
        // Data
        $id       = $request->id;
        $action   = $request->submit;
        $category = $this->brands->find($id);

        if ($action == 'edit') {
            $rules = [
                'name'        => 'required',
                'slug'        => 'required'
            ];

            $this->validate($request, $rules);

            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description
            ];

            $this->brands->update($data, $id);
        }
        else if ($action == 'delete') {
            $brand = $this->brands->delete($id);
        }

        return redirect()->back();
    }
}