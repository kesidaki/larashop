<?php

namespace App\Services;

use App\Libraries\MailLibrary;


class MailService
{
    /**
     * @var MailLibrary
     */
    private $mailing;

    public function __construct(MailLibrary $mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * Create receipt information
     *
     * @param array $data
     * @param int $orderId
     * @param array $cart
     * @return void
     */
    public function sendReceipt($data, $orderId, $cart)
    {
        $to = [
            [
                'Name'  => $data['name'],
                'Email' => $data['email'],
            ],
        ];

        $subject = 'Παραγγελία #'.$orderId.' '.env('APP_NAME');
        $view    = 'mail.order-new';
        $viewData = [
            'order'    => $orderId,
            'data'     => $data, 
            'items'    => $cart['cart'],
            'subtotal' => $cart['subtotal'],
            'tax'      => $cart['tax'],
            'total'    => $cart['total']
        ];

        $this->send($to, $subject, $view, $viewData);
    }

    /**
     * Send email
     *
     * @param array $to
     * @param string $subject
     * @param string $view
     * @param array $viewData
     * @return void
     */
    public function send($to, $subject, $view, $viewData)
    {
        $this->mailing->send([
            'from'    => env('SEND_FROM'),
            'name'    => env('APP_NAME'),
            'to'      => $to,
            'subject' => $subject.' '.env('APP_NAME'),
            'html'    => view($view, $viewData)->render()
        ]);
    }
}