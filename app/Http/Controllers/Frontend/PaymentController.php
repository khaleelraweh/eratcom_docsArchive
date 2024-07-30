<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\User;
use App\Notifications\Frontend\Customer\OrderCreatedNotification;
use App\Services\OrderService;
use App\Services\PaypalService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PaymentController extends Controller
{
    public function checkout()
    {

        return view('frontend.checkout');
    }

    // online 
    public function checkout_now(Request $request)
    {
        if ($request->paymentMethod == 'paypal') {
            $order = (new OrderService)->createOrder($request->except(['_token', 'submit']));
            $paypal = new PaypalService('PayPal_Rest');
            $response = $paypal->purchase([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => $paypal->getReturnUrl($order->id),
                    "cancel_url" => $paypal->getCancelUrl($order->id)
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $order->total
                        ]
                    ]
                ]
            ]);



            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            } else {

                return redirect()->route('checkout.cancel', $order->id);
            }
        } elseif ($request->paymentMethod == 'creditDebit') {

            $order = (new OrderService)->createOrder($request->except(['_token', 'submit']));

            $payment_method = "all";
            $tran_type  =   "sale";
            $tran_class = "ecom";
            $cart_id = $order->id;
            $cart_amount = $order->total;
            $cart_description = "This is description ";
            $name = Auth()->user()->full_name;
            $email = auth()->user()->email;
            $phone = auth()->user()->phone ?? '';
            $street1 = "street";
            $city = "Ibb";
            $state = "Ibb";
            $country = "اليمن";
            $zip = "00000";
            $ip = "";
            $same_as_billing = "billing";
            $return = route('checkout.complete_by_paytabs', $order->id);
            $callback = route('checkout.complete_by_paytabs', $order->id);
            $language = app()->getLocale();


            $response = paypage::sendPaymentCode($payment_method)
                ->sendTransaction($tran_type, $tran_class)
                ->sendCart($cart_id, $cart_amount, $cart_description)
                ->sendCustomerDetails($name, $email, $phone, $street1, $city, $state, $country, $zip, $ip)
                ->sendShippingDetails($same_as_billing, $name = null, $email = null, $phone = null, $street1 = null, $city = null, $state = null, $country = null, $zip = null, $ip = null)
                ->sendHideShipping($on = true)
                ->sendURLs($return, $callback)
                ->sendLanguage($language)
                ->sendFramed($on = false)
                ->create_pay_page(); // to initiate payment page



            return $response;
        } elseif ($request->paymentMethod == 'kurimaBank') {
            $order = (new OrderService)->createOrder($request->except(['_token', 'submit']));

            if ($order) {

                // Handle the file upload
                if ($request->hasFile('bankReceipt')) {
                    $image  = $request->bankReceipt;
                    $file_name = $order->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $path = public_path('assets/orders/' . $file_name);
                    Image::make($image->getRealPath())->save($path);


                    $order->update([
                        'bankAccNumber' =>  $request->bankAccNumber,
                        'bankReceipt'   =>  $file_name,
                    ]);
                }

                $order->update(['order_status' => Order::PAYMENT_COMPLETED]);
                $order->transactions()->create([
                    'transaction' => OrderTransaction::PAYMENT_COMPLETED,
                    // 'transaction_number' => $response->getTransactionReference(),
                    'transaction_number' => 4,
                    'payment_result' => 'success',
                ]);

                if (session()->has('coupon')) {
                    $coupon = Coupon::where('code->' . app()->getLocale(), session()->get('coupon')['code'])->first();
                    $coupon->increment('used_times');
                }

                Cart::instance('default')->destroy();
                session()->forget([
                    'coupon',
                    'saved_customer_address_id',
                    'saved_shipping_company_id',
                    'saved_payment_method_id',
                    'shipping',
                ]);


                $admins = User::whereHas('roles', function ($query) {
                    $query->whereIn('name', ['admin', 'supervisor']);
                })->get();

                foreach ($admins as $admin) {
                    $admin->notify(new OrderCreatedNotification($order));
                }





                toast(__('panel.f_your_recent_payment_successful_with_refrence_code') . '4', 'success');

                return redirect()->route('frontend.index');
            }
        }
    }



    public function completed(Request $request, $order_id)
    {

        $order = Order::find($order_id);

        $paypal = new PaypalService('PayPal_Rest');
        $response = $paypal->complete($request->token);


        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order->update(['order_status' => Order::PAYMENT_COMPLETED]);
            $transfaction =  $order->transactions()->create([
                'transaction' => OrderTransaction::PAYMENT_COMPLETED,
                // 'transaction_number' => $response->getTransactionReference(),
                'transaction_number' => $response['id'],
                'payment_result' => 'success',
            ]);

            // ================= Start to finish the order request automaticly ========================//

            // start under  proccess 
            $order->update(['order_status' => Order::UNDER_PROCESS]);
            $transfaction->update(['transaction' => OrderTransaction::UNDER_PROCESS]);
            // end under  proccess 

            // Start finish 
            $order->update(['order_status' => Order::FINISHED]);
            $transfaction->update(['transaction' => OrderTransaction::FINISHED]);
            // End finish

            // ================= End to finish the order request automaticly ========================//


            // if (session()->has('coupon')) {
            //     $coupon = Coupon::whereCode(session()->get('coupon')['code'])->first();
            //     $coupon->increment('used_times');
            // }

            Cart::instance('default')->destroy();
            session()->forget([
                'coupon',
                'saved_customer_address_id',
                'saved_shipping_company_id',
                'saved_payment_method_id',
                'shipping',
            ]);



            // toast('Your recent payment is successful with reference code : '. $response->getTransactionReference() , 'success');
            toast(__('panel.f_your_recent_payment_successful_with_refrence_code') . $response['id'], 'success');

            return redirect()->route('frontend.index');
        } else {
            return redirect()->route('checkout.cancel', $order->id);
        }
    }

    public function cancelled($order_id)
    {
        $order = Order::find($order_id);
        $order->update([
            'order_status' => Order::CANCELED
        ]);

        $order->courses()->each(function ($order_course) {
            $course = Course::whereId($order_course->pivot->course_id)->first();
            $course->update([
                'quantity' => $course->quantity + $order_course->quantity
            ]);
        });

        toast(__('panel.f_you_have_cancelled_your_order_payment'), 'error'); //using realrashed sweet alert lab

        return redirect()->route('frontend.index');
    }

    public function webhook($order, $env)
    {
        //
    }

    public function completed_paytabs(Request $request, $order_id)
    {

        // dd($request);
        $order = Order::find($order_id);

        $order->update(['order_status' => Order::PAYMENT_COMPLETED]);
        $transfaction = $order->transactions()->create([
            'transaction' => OrderTransaction::PAYMENT_COMPLETED,
            // 'transaction_number' => $response->getTransactionReference(),
            'transaction_number' => 10,
            'payment_result' => 'success',
        ]);


        // ================= Start to finish the order request automaticly ========================//

        // start under  proccess 
        $order->update(['order_status' => Order::UNDER_PROCESS]);
        $transfaction->update(['transaction' => OrderTransaction::UNDER_PROCESS]);
        // end under  proccess 

        // Start finish 
        $order->update(['order_status' => Order::FINISHED]);
        $transfaction->update(['transaction' => OrderTransaction::FINISHED]);
        // End finish

        // ================= End to finish the order request automaticly ========================//


        if (session()->has('coupon')) {
            $coupon = Coupon::where('code->' . app()->getLocale(), session()->get('coupon')['code'])->first();
            $coupon->increment('used_times');
        }

        Cart::instance('default')->destroy();
        session()->forget([
            'coupon',
            'saved_customer_address_id',
            'saved_shipping_company_id',
            'saved_payment_method_id',
            'shipping',
        ]);


        toast(__('panel.f_your_recent_payment_successful_with_refrence_code') . '10', 'success');

        return redirect()->route('frontend.index');
    }
}
