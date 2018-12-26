<?php

namespace App\Http\Controllers\Website;

use Auth;
use Cart;
use Illuminate\Http\Request;
use App\Eloquent\StateRepository;
use App\Eloquent\ShippingRepository;
use App\Http\Controllers\Website\Controller;
use App\Services\CartService;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use App\Services\TransactionService;
use App\Services\MailService;

class CheckoutController extends Controller
{
    /**
     * @var ShippingRepository
     */
    public $shipping;
    
    /**
     * @var StateRepository
     */
    public $states;

    /**
     * @param ShippingRepository $resShipping
     * @param StateRepository $resState
     */
	public function __construct(
        ShippingRepository $resShipping, 
        StateRepository $resState) 
    {
        $this->shipping     = $resShipping;
        $this->states       = $resState;
    }

    /**
     * Checkout form
     *
     * @param CartService $cartService
     * @return void
     */
    public function index(CartService $cartService) 
    {
        $cart = $cartService->getCartInfo();
    	$info = [
            'shipping' => $this->shipping->allBy('cost', 'asc'),
            'states'   => $this->states->allBy('name', 'asc')
        ];
        
        $data = $cart + $info;

		if (!count($data['cart'])) {
			return redirect('/cart');
		}

    	return view('checkout.index', $data);
    }

    /**
     * Payment Process
     *
     * @param OrderRequest $request
     * @param CartService $cartService
     * @param OrderService $orderService
     * @param TransactionService $transactionService
     * @param MailService $mailService
     * @return void
     */
    public function complete(OrderRequest $request, CartService $cartService, OrderService $orderService, TransactionService $transactionService, MailService $mailService) 
    {
        if ($request->payment == 'Κάρτα') {
            // TODO: add payment via card (placeholder, of course!)
        }
        else {
            return $this->store($request, $cartService, $orderService, $transactionService, $mailService);
        }
    }

    /**
     * Store order data
     *
     * @param Request $request
     * @param CartService $cartService
     * @param OrderService $orderService
     * @param TransactionService $transactionService
     * @param MailService $mailService
     * @return void
     */
    private function store(Request $request, CartService $cartService, OrderService $orderService, TransactionService $transactionService, MailService $mailService) 
    {
        $data     = $request->all();
        $cart     = $cartService->getCartInfo();
        $shipping = $this->shipping->find($request->shipping_id);
        $orderId  = $orderService->makeOrder($data, $shipping->cost, $cart);

        $transactionService->storeCartItems($orderId, $cart['cart']);
        $mailService->sendReceipt($data, $orderId, $cart);

        $cartService->destroyCart();

        return redirect('checkout/details/'.$orderId);
    }

    /**
     * Page for order details
     *
     * @param int $id
     * @param OrderService $orderService
     * @param TransactionService $transactionService
     * @return void
     */
    public function details($id, OrderService $orderService, TransactionService $transactionService) 
    {
        $data = [
            'order' => $orderService->findOrder($id),
            'info'  => $transactionService->getForOrder($id),
        ];

        return view('checkout.details', $data);
    }
}
