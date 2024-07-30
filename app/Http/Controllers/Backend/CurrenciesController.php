<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CurrencyRequest;
use App\Models\Currency;
use DateTimeImmutable;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_currencies , show_currencies')) {
            return redirect('admin/index');
        }

        $currencies = Currency::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'asc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.currencies.index', compact('currencies'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_currencies')) {
            return redirect('admin/index');
        }

        return view('backend.currencies.create');
    }

    public function store(CurrencyRequest $request)
    {

        if (!auth()->user()->ability('admin', 'create_currencies')) {
            return redirect('admin/index');
        }

        $input['currency_name']             =   $request->currency_name;
        $input['currency_symbol']           =   $request->currency_symbol;
        $input['currency_code']             =   $request->currency_code;
        $input['exchange_rate']             =   $request->exchange_rate;


        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $currency = Currency::create($input);

        if ($currency) {
            return redirect()->route('admin.currencies.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.currencies.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_sliders')) {
            return redirect('admin/index');
        }

        return view('backend.currencies.show');
    }


    public function edit($currency)
    {
        if (!auth()->user()->ability('admin', 'update_currencies')) {
            return redirect('admin/index');
        }

        $currency = Currency::where('id', $currency)->first();

        return view('backend.currencies.edit', compact('currency'));
    }

    public function update(CurrencyRequest $request,  $currency)
    {
        if (!auth()->user()->ability('admin', 'update_currencies')) {
            return redirect('admin/index');
        }

        $currency = Currency::where('id', $currency)->first();

        $input['currency_name']        =   $request->currency_name;
        $input['currency_symbol']      =   $request->currency_symbol;
        $input['currency_code']        =   $request->currency_code;
        $input['exchange_rate']        =   $request->exchange_rate;

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $currency->update($input);

        if ($currency) {
            return redirect()->route('admin.currencies.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.currencies.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($currency)
    {
        if (!auth()->user()->ability('admin', 'delete_currencies')) {
            return redirect('admin/index');
        }

        $currency = Currency::where('id', $currency)->first();
        $currency->delete();


        if ($currency) {
            return redirect()->route('admin.currencies.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.currencies.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    // in backend 
    public function updateCurrencyStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Currency::where('id', $data['currency_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'currency_id' => $data['currency_id']]);
        }
    }

    // in frontend

    // public function currencyLoad(Request $request)
    // {
    //     // dd($request->all());

    //     session()->put('currency_code', $request->currency_code);

    //     $currency = Currency::where('currency_code', $request->currency_code)->first();

    //     session()->put('currency_symbol', $currency->currency_symbol);
    //     session()->put('currency_name', $currency->currency_name);
    //     session()->put('currency_exchange_rate', $currency->exchange_rate);

    //     $response['status'] = true;

    //     return $response;
    // }
    public function currencyLoad(Request $request, $currency_code)
    {
        // dd($request->all());

        session()->put('currency_code', $currency_code);

        $currency = Currency::where('currency_code', $currency_code)->first();

        session()->put('currency_symbol', $currency->currency_symbol);
        session()->put('currency_name', $currency->currency_name);
        session()->put('currency_exchange_rate', $currency->exchange_rate);

        $response['status'] = true;

        // return $response;
        return back();
    }
}
