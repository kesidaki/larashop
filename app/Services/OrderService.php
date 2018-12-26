<?php

namespace App\Services;

use Auth;
use App\Eloquent\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Create order
     *
     * @param array $data
     * @param float $shippingCost
     * @param array $cart
     * @return Object
     */
    public function makeOrder($data, $shippingCost, $cart)
    {
        $data['buyer_id'] = Auth::user()->id ?? null;
        $data['subtotal'] = $cart['subtotal'];
        $data['tax']      = $cart['tax'];
        $data['shipping'] = $shippingCost;
        $data['total']    = $cart['total'] + $shippingCost;

        return $this->orderRepository->create($data);
    }

    /**
     * Get Order Information by ID
     *
     * @param int $id
     * @return Object
     */
    public function findOrder($id)
    {
        return $this->orderRepository->find($id);
    }
}