<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Models\Order;
use App\Models\OrderTransaction;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OrdersComponent extends Component
{
    use LivewireAlert;

    public $showOrder = false;
    public $order_show;

    public function displayOrder($id)
    {
        $this->order_show = Order::with('courses')->find($id);
        $this->showOrder = true;
    }

    public function requestReturnOrder($id)
    {

        $order = Order::whereId($id)->first();

        $order->update([
            'order_status' => Order::REFUNDED_REQUEST
        ]);

        $order->transactions()->create([
            'transaction' => OrderTransaction::REFUNDED_REQUEST,
            'transaction_number' => $order->transactions()->whereTransaction(OrderTransaction::PAYMENT_COMPLETED)->first()->transaction_number,
        ]);


        $this->alert('success', 'Your request is sent successfully');
    }

    public function render()
    {
        return view('livewire.frontend.customer.orders-component', [
            'orders' => auth()->user()->orders,
        ]);
    }
}
