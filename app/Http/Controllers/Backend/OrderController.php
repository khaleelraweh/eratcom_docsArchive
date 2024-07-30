<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\User;
use App\Notifications\Backend\Orders\OrderNotification;

class OrderController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_orders , show_orders')) {
            return redirect('admin/index');
        }

        $orders = Order::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereOrderStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);


        return view('backend.orders.index', compact('orders'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_orders')) {
            return redirect('admin/index');
        }
        //return view('backend.orders.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_orders')) {
            return redirect('admin/index');
        }

        //
    }

    public function show(Order $order)
    {
        if (!auth()->user()->ability('admin', 'display_orders')) {
            return redirect('admin/index');
        }


        $order_status_array = [
            '0' =>  __('panel.order_new_order'),
            '1' =>  __('panel.order_paid'),
            '2' =>  __('panel.order_under_process'),
            '3' =>  __('panel.order_finished'),
            '4' =>  __('panel.order_rejected'),
            '5' =>  __('panel.order_canceled'),
            '6' =>  __('panel.order_refund_requested'),
            '7' =>  __('panel.order_returned_order'),
            '8' =>  __('panel.order_refunded')
        ];

        $key = array_search($order->order_status, array_keys($order_status_array));

        // This will delete order status element from order_status_array if its key is les or equail t order status in the table orders
        foreach ($order_status_array as $k => $v) {
            if ($k <= $key) {
                unset($order_status_array[$k]);
            }
        }

        // dd($order_status_array);



        return view('backend.orders.show', compact('order', 'order_status_array'));
    }

    public function edit(Order $order)
    {
        if (!auth()->user()->ability('admin', 'update_orders')) {
            return redirect('admin/index');
        }
        //return view('backend.orders.edit',compact( 'order'));
    }

    public function update(Request $request, Order $order)
    {
        if (!auth()->user()->ability('admin', 'update_orders')) {
            return redirect('admin/index');
        }

        $customer = User::find($order->user_id);

        $order->update(['order_status' => $request->order_status]);

        $order->transactions()->create([
            'transaction' => $request->order_status,
            'transaction_number' => null,
            'payment_result' => null,
        ]);

        $customer->notify(new OrderNotification($order));

        if ($order) {
            return back()->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return back()->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy(Order $order)
    {
        if (!auth()->user()->ability('admin', 'delete_orders')) {
            return redirect('admin/index');
        }

        $order->delete();


        if ($order) {
            return redirect()->route('admin.orders.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.orders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
