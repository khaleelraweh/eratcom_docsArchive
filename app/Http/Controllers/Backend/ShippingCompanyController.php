<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShippingCompanyRequest;
use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    public function index()
    {
        if(!auth()->user()->ability('admin','manage_shipping_companies , show_shipping_companies')){
            return redirect('admin/index');
        }

        $shipping_companies = ShippingCompany::withCount('countries')
        ->when(\request()->keyword != null , function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status != null , function($query){
            $query->where('status',\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' , \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);
        
        return view('backend.shipping_companies.index',compact('shipping_companies'));
        
    }

    public function create()
    {
        if(!auth()->user()->ability('admin','create_shipping_companies')){
            return redirect('admin/index');
        }
        
        $countries = Country::orderBy('id','asc')->get(['id','name']);
        return view('backend.shipping_companies.create',compact('countries'));
    }

    public function store(ShippingCompanyRequest $request)
    {
        if(!auth()->user()->ability('admin','create_shipping_companies')){
            return redirect('admin/index');
        }

        // لاضافة الدول بعد اضافة الشبانج كمبني يتم عبر التالي 
        if($request->validated()){
            $shipping_company = ShippingCompany::create($request->except('countries','_token','submit'));
            $shipping_company->countries()->attach(array_values($request->countries));
            
            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'تم انشاء البيانات بنجاح',
                'alert-type' => 'success'
            ]);
        
        }else{
            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'Something Wrong',
                'alert-type' => 'danger'
            ]);
        }


        
    }
    
    public function show(ShippingCompany $shipping_company)
    {
        if(!auth()->user()->ability('admin','display_shipping_companies')){
            return redirect('admin/index');
        }
        return view('backend.shipping_companies.show',compact('shipping_company'));
    }

    public function edit(ShippingCompany $shipping_company )
    {
        if(!auth()->user()->ability('admin','update_shipping_companies')){
            return redirect('admin/index');
        }

        $shipping_company->with('countries');
        $countries = Country::get(['id','name']);

        return view('backend.shipping_companies.edit',compact( 'shipping_company','countries'));
    }
    
    public function update(ShippingCompanyRequest $request, ShippingCompany $shipping_company)
    {
        if(!auth()->user()->ability('admin','update_shipping_companies')){
            return redirect('admin/index');
        }

        if($request->validated()){
            $shipping_company->update($request->except('countries','_token','submit'));
            $shipping_company->countries()->sync(array_values($request->countries));
            
            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'تم التعديل بنجاح',
                'alert-type' => 'success'
            ]);
        
        }else{
            return redirect()->route('admin.shipping_companies.index')->with([
                'message' => 'حدث شيئ ماء خطاء ',
                'alert-type' => 'danger'
            ]);
        }


        

        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'تم تعديل البيانات بنجاح',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(ShippingCompany $shipping_company)
    {
        if(!auth()->user()->ability('admin','delete_shipping_companies')){
            return redirect('admin/index');
        }

        $shipping_company->delete();

        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'تم الحذف بنجاح',
            'alert-type' => 'success'
        ]);
    }
}