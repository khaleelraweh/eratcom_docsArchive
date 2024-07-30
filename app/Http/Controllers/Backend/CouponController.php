<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CouponRequest;
use App\Models\Coupon;
use Carbon\Carbon;
use DateTime;
use DateTimeImmutable;

class CouponController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_coupons , show_coupons')) {
            return redirect('admin/index');
        }

        $coupons = Coupon::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.coupons.index', compact('coupons'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_coupons')) {
            return redirect('admin/index');
        }
        return view('backend.coupons.create');
    }


    public function store(CouponRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_coupons')) {
            return redirect('admin/index');
        }

        $input['code']              =   $request->code;
        $input['type']              =   $request->type;
        $input['value']             =   $request->value;
        $input['description']       =   $request->description;
        $input['use_times']         =   $request->use_times;
        $input['start_date']        =   $request->start_date;
        $input['expire_date']       =   $request->expire_date;
        $input['greater_than']      =   $request->greater_than;

        // always added 
        $input['status']            =   $request->status;
        $input['published_on']      =   $request->published_on;
        $input['views']             =   0;
        $input['created_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        // end of always added 

        // Coupon::create($request->validated());
        $coupon = Coupon::create($input);

        if ($coupon) {
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.coupons.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_coupons')) {
            return redirect('admin/index');
        }
        return view('backend.coupons.show');
    }

    public function edit(Coupon $coupon)
    {
        if (!auth()->user()->ability('admin', 'update_coupons')) {
            return redirect('admin/index');
        }

        // $time = \Carbon\Carbon::parse('')->isoFormat('h:mm a');


        return view('backend.coupons.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        if (!auth()->user()->ability('admin', 'update_coupons')) {
            return redirect('admin/index');
        }

        $input['code']              =   $request->code;
        $input['type']              =   $request->type;
        $input['value']             =   $request->value;
        $input['description']       =   $request->description;
        $input['use_times']         =   $request->use_times;
        $input['start_date']        =   $request->start_date;
        $input['expire_date']       =   $request->expire_date;
        $input['greater_than']      =   $request->greater_than;

        // always added 
        $input['status']            =   $request->status;
        $input['published_on']      =   $request->published_on;
        $input['views']             =   0;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        // end of always added 

        //    $coupon->update($request->validated());
        $coupon->update($input);

        if ($coupon) {
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.coupons.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        if (!auth()->user()->ability('admin', 'delete_coupons')) {
            return redirect('admin/index');
        }

        $coupon->delete();


        if ($coupon) {
            return redirect()->route('admin.coupons.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.coupons.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
