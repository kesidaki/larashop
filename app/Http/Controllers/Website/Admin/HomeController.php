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

class HomeController extends Controller
{
    public $orders;

    public function __construct(OrderRepository $resOrder) 
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->orders        = $resOrder;
    }

    /**
    * Admin Home Page
    * @param request
    */
    public function index(Request $request) {
    	return view('admin.index', [
            'orders' => $this->orders->recent(5, $request)
        ]);
    }
}
