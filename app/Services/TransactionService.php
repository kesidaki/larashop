<?php

namespace App\Services;

use App\Eloquent\TransactionRepository;


class TransactionService
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Undocumented function
     *
     * @param int $orderId
     * @param array $cartContent
     * @return void
     */
    public function storeCartItems($orderId, $cartContent)
    {
        foreach ($cartContent as $item) {
            $orderData = [
                'order_id'   => $orderId,
                'product_id' => $item->id,
                'quantity'   => $item->qty,
                'total'      => $item->total
            ];

            $this->storeTransaction($orderData);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function getForOrder($id)
    {
        return $this->transactionRepository->getForOrder($id);
    }

    /**
     * @param array $data
     * @return void
     */
    private function storeTransaction($data)
    {
        $this->transactionRepository->create($data);
    }
}