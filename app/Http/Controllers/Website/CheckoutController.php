<?php

namespace App\Http\Controllers\Website;

use Auth;
use Cart;
use Illuminate\Http\Request;
use App\Libraries\MailLibrary;
use App\Eloquent\OrderRepository;
use App\Eloquent\StateRepository;
use App\Eloquent\ShippingRepository;
use App\Eloquent\TransactionRepository;
use App\Http\Controllers\Website\Controller;

class CheckoutController extends Controller
{
	public $shipping;
    public $states;
    public $orders;
    public $transactions;
    public $mailing;

	public function __construct(
        ShippingRepository $resShipping, 
        StateRepository $resState, 
        OrderRepository $resOrder, 
        TransactionRepository $resTransaction,
        MailLibrary $libMail) 
    {
        $this->shipping     = $resShipping;
        $this->states       = $resState;
        $this->orders       = $resOrder;
        $this->transactions = $resTransaction;
        $this->mailing      = $libMail;
    }

    /**
    * Check out Form
    */
    public function index() 
    {
    	$data = [
			'cart'     => Cart::content(),
			'subtotal' => Cart::subtotal(2, '.', ','),
			'tax'      => Cart::tax(2, '.', ','),
			'total'    => Cart::total(2, '.', ','),
			'shipping' => $this->shipping->allBy('cost', 'asc'),
            'states'   => $this->states->allBy('name', 'asc')
		];

		if (!count($data['cart'])) {
			return redirect('/cart');
		}

    	return view('checkout.index', $data);
    }

    /**
    * Completing Payment Process
    * @param request
    */
    public function complete(Request $request) 
    {
        // Validate
    	$rules = [
            'name'        => 'required',
            'address'     => 'required',
            'tk'          => 'required',
            'city'        => 'required',
            'state'       => 'required',
            'phone'       => 'required',
            'email'       => 'required',
            'shipping_id' => 'required',
            'payment'     => 'required'
        ];

        if ($request->type == 'Τιμολόγιο') {
            $rules['doy']                  = 'required';
            $rules['afm']                  = 'required';
            $rules['profession']           = 'required';
        }

        $this->validate($request, $rules);

        if ($request->payment == 'Κάρτα') {

        }
        else {
            return $this->store($request);
        }
    }

    /**
    * Store Order
    * @param request
    */
    public function store($request) 
    {
        # Create order information
        $shipping         = $this->shipping->find($request->shipping_id);
        $data             = $request->all();
        $data['buyer_id'] = (auth()->user()) ? auth()->user()->id : null;
        $data['subtotal'] = Cart::subtotal();
        $data['tax']      = Cart::tax();
        $data['shipping'] = $shipping->cost;
        $data['total']    = Cart::total() + $data['shipping'];
        
        # Create order
        $orderId          = $this->orders->create($data);

        # Store Order Products
        foreach (Cart::content() as $item) {
            $orderData = [
                'order_id'   => $orderId,
                'product_id' => $item->id,
                'quantity'   => $item->qty,
                'total'      => $item->total
            ];

            $this->transactions->create($orderData);
        }

        # Send Email with order information
        $this->mailing->send([
            'from'    => env('SEND_FROM'),
            'name'    => env('APP_NAME'),
            'to'      => [
                [
                'Name'  => $request->name,
                'Email' => $request->email
                ]
            ],
            'subject' => 'Παραγγελία #'.$orderId.' '.env('APP_NAME'),
            'html'    => view('mail.order-new', [
                'order'    => $orderId,
                'data'     => $data, 
                'items'    => Cart::content(),
                'subtotal' => Cart::subtotal(2, '.', ','),
                'tax'      => Cart::tax(2, '.', ','),
                'total'    => Cart::total(2, '.', ',')
            ])->render()
        ]);

        # Empty cart
        Cart::destroy();

        return redirect('checkout/details/'.$orderId);
    }

    /**
    * Order Details Page
    * @param id
    */
    public function details($id) 
    {
        $data = [
            'order'    => $this->orders->find($id),
            'info'     => $this->transactions->getForOrder($id)
        ];

        return view('checkout.details', $data);
    }
}
