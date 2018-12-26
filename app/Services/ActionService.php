<?php

namespace App\Services;

use Carbon\Carbon;
use App\Eloquent\ActionRepository;
use Illuminate\Http\Request;
use App\Eloquent\TransactionRepository;

class ActionService
{
    /**
     * @var ActionRepository
     */
    private $actionRepository;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @param ActionRepository $actionRepository
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(ActionRepository $actionRepository, TransactionRepository $transactionRepository)
    {
        $this->actionRepository = $actionRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Return the most viewed products for a set timeframe
     *
     * @param integer $days
     * @param integer $limit
     * @return Collection
     */
    public function mostViewedProducts($days = 30, $limit = 10)
    {
        return $this->actionRepository->mostViewedProducts($days, $limit);
    }

    /**
     * Get statistics for most visited pages for a number of days
     *
     * @param integer $days
     * @return array
     */
    public function mostVisits($days = 30)
    {
        return $this->actionRepository->statVisits($days);
    }

    /**
     * Get statistics for product
     *
     * @param int $productID
     * @param Request $request
     * @return array
     */
    public function productStatistics($productID, Request $request)
    {
        // make dates
        $from    = Carbon::now()->subDays(($request->forDays) ? $request->forDays : 30)->format('Y-m-d H:i:s');
        $to      = Carbon::now()->format('Y-m-d H:i:s');

        // get sales and store them in array
        $sales   = $this->transactionRepository->productSalesForPeriod($productID, $from, $to);

        $labels  = ['Πωλήσεις'];
        $values  = [$sales];

        // get other info and store them
        $info    = $this->actionRepository->statProduct($productID, $request->forDays);
        foreach ($info as $row) {
            if ($row->type == 'view') {
                array_push($labels, 'Προβολές σελίδας');
                array_push($values, $row->count);
            }
            else if ($row->type == 'cart_add') {
                array_push($labels, 'Προσθήκες στο καλάθι');
                array_push($values, $row->count);
            }
            else if ($row->type == 'cart_rm') {
                array_push($labels, 'Αφαιρέσεις από το καλάθι');
                array_push($values, $row->count);
            }
        }

        return [
            'label' => $labels, 
            'value' => $values
        ];
    }

    /**
     * Store visit information
     *
     * @param string $type
     * @param string $productId
     * @param string $url
     * @param string $visitor
     * @return void
     */
    public function storeVisit($type, $productId = '', $url = '', $visitor = '')
    {
        return $this->actionRepository->create([
            'type'       => $type,
            'product_id' => $productId,
            'url'        => $url
            // 'visitor'    => $visitor
        ]);
    }
}