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

class OrdersController extends Controller
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
    * Orders Page
    * @param request
    */
    public function orders(Request $request) 
    {
        $data = [
            'orders' => $this->orders->getOrders($request),
            'term'   => $request->term
        ];

        return view('admin.orders', $data);
    }

    /**
    * Order Page
    * @param id
    */
    public function order($id) 
    {
        $order = $this->orders->find($id);
        $data = [
            'order'    => $order,
            'info'     => $this->transactions->getForOrder($id),
            'states'   => $this->states->allBy('name', 'asc'),
            'shipping' => $this->shipping->allBy('cost', 'asc'),
            'receipts' => $order->receipts
        ];

        return view('admin.order', $data);
    }

    /**
    * Generate Parastatiko
    * @param id
    */
    public function parastatiko($id) 
    {
        $receipt  = $this->receipts->find($id);
        $order    = $this->orders->find($receipt->order_id);
        $products = $this->transactions->getForOrder($order->id);

        $data = [
            'receipt'  => $receipt,
            'order'    => $order,
            'products' => $products
        ];

        if ($receipt->type == 'Τιμολόγιο') {
            //return view('pdf.invoice', $data);
            $data['olografos'] = $this->myLibrary->numberToGreekText($order->total); 

            return PDF::loadView('pdf.invoice', $data)->setPaper('a4', 'portrait')->stream();
        }
        else if ($receipt->type == 'Απόδειξη') {
            //return view('pdf.receipt', $data);
            return PDF::loadView('pdf.receipt', $data)->setPaper('a4', 'portrait')->stream();
        }
    }

    /**
    * Update Order
    * @param request
    */
    public function updateOrder(Request $request) 
    {
        $id    = $request->post('order');
        $order = $this->orders->find($id);
        $total = 0;

        // Remove old product entries and add new
        $order->transactions()->delete();
        $productsIds    = $request->post('pId');
        $productsNames  = $request->post('pName');
        $productsQtys   = $request->post('pQty');
        $productsPrices = $request->post('pPrice');

        foreach ($productsIds as $key=>$value) {
            $product  = $this->products->find($value);
            $discount = $product->discount;

            if ($discount) {
                $price = round((($product->prices{0}->price * $product->discount->discount) / 100), 2);
            }
            else {
                $price = $product->prices{0}->price;
            }

            $transaction = [
                'order_id'   => $id,
                'product_id' => $value,
                'quantity'   => $productsQtys[$key],
                'total'      => $productsQtys[$key] * $price
            ];

            $this->transactions->create($transaction);

            $total += $transaction['total'];
        }

        $shipping = $this->shipping->find($request->post('shipping_id'));
        $total   += $shipping->cost;
        $tax      = $total / (1 + $this->options->getTax());

        $info = [
            'type'        => $request->post('type'),
            'name'        => $request->post('name'),
            'doy'         => $request->post('doy'),
            'afm'         => $request->post('afm'),
            'profession'  => $request->post('profession'),
            'address'     => $request->post('address'),
            'tk'          => $request->post('tk'),
            'city'        => $request->post('city'),
            'state'       => $request->post('state'),
            'phone'       => $request->post('phone'),
            'phone_2'     => $request->post('phone_2'),
            'email'       => $request->post('email'),
            'shipping_id' => $request->post('shipping_id'),
            'subtotal'    => round($total - $tax, 2),
            'tax'         => round($tax, 2),
            'shipping'    => round($shipping->cost, 2),
            'total'       => round($total, 2)
        ];

        $this->orders->update($info, $id);

        return redirect()->back();
    }

    /**
    * Create and View Receipt
    * @param id
    * @param type
    */
    public function createParastatiko ($id, $type) 
    {
        // check if there is a receipt to the corresponding order and type
        $receipt = $this->receipts->findReceipt($id, $type);

        if (!$receipt) {
            $newReceipt = $this->receipts->create([
                'order_id'  => $id,
                'code'      => 'ΑΠΥ',
                'type'      => $type,
                'series'    => '',
                'number'    => $this->receipts->getLatestNumber(),
                'cancelled' => 0, 
            ]);

            return redirect('/parastatiko/'.$newReceipt);
        }
        else {
            return redirect('/parastatiko/'.$receipt->id);
        }
    }

    /**
    * Cancel Parastatiko
    * @param request
    */
    public function cancelParastatiko(Request $request) 
    {
        $id      = $request->post('id');
        $receipt = $this->receipts->find($id);

        if ($receipt) {
            $updateReceipt = $this->receipts->update(['cancelled' => 1], $id);

            $newCancelReceipt = $this->receipts->create([
                'order_id'  => $receipt->order_id,
                'code'      => 'Πιστωτικό',
                'type'      => $receipt->type,
                'series'    => $receipt->series,
                'number'    => $this->receipts->getLatestNumber('Πιστωτικό'),
                'cancelled' => 1
            ]);

            return redirect()->back();
        }
    }
}
