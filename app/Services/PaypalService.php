<?php

namespace App\Services;


use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalService
{

    public $provider = '';

    public function __construct($payment_method = 'PayPal_Rest')
    {
        if (is_null($payment_method) || $payment_method == 'PayPal_Rest') {
            $this->provider = new PayPalClient;
            $this->provider->setApiCredentials(config('paypal'));
            $paypalToken = $this->provider->getAccessToken();
        }

        return $this->provider;
    }


    public function purchase(array $parameter)
    {
        $response = $this->provider->createOrder($parameter);
        return $response;
    }



    public function complete($token)
    {  //This is success 
        $response = $this->provider->capturePaymentOrder($token);
        return $response;
    }

    public function getReturnUrl($order_id)
    {
        return route('checkout.complete', $order_id);
    }

    public function getCancelUrl($order_id)
    { // This is canceled

        return route('checkout.cancel', $order_id);
    }


    public function getNotifyUrl($order_id)
    {

        $env = config('services.paypal.sandbox') ? 'sandbox' : 'live';
        return route('checkout.webhook.ipn', [$order_id, $env]);
    }
}
