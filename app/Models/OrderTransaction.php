<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    const NEW_ORDER = 0;
    const PAYMENT_COMPLETED = 1;
    const UNDER_PROCESS = 2;
    const FINISHED = 3;
    const REJECTED = 4;
    const CANCELED = 5;
    const REFUNDED_REQUEST = 6;
    const RETURNED = 7;
    const REFUNDED = 8;
    const Free = 9;


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function status($transaction_number = null)
    {

        $transaction = $transaction_number != '' ? $transaction_number : $this->transaction;

        switch ($transaction) {
            case 0:
                $result = __('panel.order_new_order');
                break;
            case 1:
                $result = __('panel.order_paid');
                break;
            case 2:
                $result = __('panel.order_under_process');
                break;
            case 3:
                $result = __('panel.order_finished');
                break;
            case 4:
                $result = __('panel.order_rejected');
                break;
            case 5:
                $result = __('panel.order_canceled');
                break;
            case 6:
                $result = __('panel.order_refund_requested');
                break;
            case 7:
                $result = __('panel.order_returned_order');
                break;
            case 8:
                $result = __('panel.order_refunded');
                break;
        }



        return $result;
    }
}
