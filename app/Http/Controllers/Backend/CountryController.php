<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CountryRequest;
use App\Models\Country;
use DateTimeImmutable;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    { 
        if(!auth()->user()->ability('admin','manage_countries , show_countries')){
            return redirect('admin/index');
        }

        $countries = Country::with('states')
        ->when(\request()->keyword != null , function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status != null , function($query){
            $query->where('status',\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' , \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);
        
        return view('backend.countries.index',compact('countries'));
        
    }

    public function create()
    {
        if(!auth()->user()->ability('admin','create_countries')){
            return redirect('admin/index');
        }
        return view('backend.countries.create');
    }

    public function store(CountryRequest $request)
    {
        if(!auth()->user()->ability('admin','create_countries')){
            return redirect('admin/index');
        }
        $input['name']              = $request->name ;
        $input['name_native']       = $request->name_native ;
        $input['country_code']      = $request->country_code ;
        $input['phone_code']        = $request->phone_code ;
        $input['capital']           = $request->capital ;
        $input['currency']          = $request->currency ;
        $input['currency_name']     = $request->currency_name ;
        $input['currency_name_native']     = $request->currency_name_native ;
        $input['currency_symbol']   = $request->currency_symbol ;
        $input['region']            = $request->region ;
        $input['nationality']       = $request->nationality ;
        $input['nationality_native']= $request->nationality_native ;
        $input['translations']      = $request->translations ;
        $input['emoji']             = $request->emoji ;
        $input['status']            = $request->status ;
        $input['created_by']        = auth()->user()->full_name;

        $published_on = $request->published_on.' '.$request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        // Country::create($request->validated());
        Country::create($input);


        return redirect()->route('admin.countries.index')->with([
            'message' => 'created successfully',
            'alert-type' => 'success'
        ]);
    }
    
    public function show(Country $country)
    {
        if(!auth()->user()->ability('admin','display_countries')){
            return redirect('admin/index');
        }
        return view('backend.countries.show',compact('country'));
    }

    public function edit(Country $country)
    {
        if(!auth()->user()->ability('admin','update_countries')){
            return redirect('admin/index');
        }
        return view('backend.countries.edit',compact( 'country'));
    }
    
    public function update(CountryRequest $request, Country $country)
    {
        if(!auth()->user()->ability('admin','update_countries')){
            return redirect('admin/index');
        }

        $input['name']              = $request->name ;
        $input['name_native']       = $request->name_native ;
        $input['country_code']      = $request->country_code ;
        $input['phone_code']        = $request->phone_code ;
        $input['capital']           = $request->capital ;
        $input['currency']          = $request->currency ;
        $input['currency_name']     = $request->currency_name ;
        $input['currency_name_native']     = $request->currency_name_native ;
        $input['currency_symbol']   = $request->currency_symbol ;
        $input['region']            = $request->region ;
        $input['nationality']       = $request->nationality ;
        $input['nationality_native']= $request->nationality_native ;
        $input['translations']      = $request->translations ;
        $input['emoji']             = $request->emoji ;
        $input['status']            = $request->status ;
        $input['updated_by']        = auth()->user()->full_name;

        $published_on = $request->published_on.' '.$request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        

        // $country->update($request->validated());
        $country->update($input);

        return redirect()->route('admin.countries.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Country $country)
    {
        if(!auth()->user()->ability('admin','delete_countries')){
            return redirect('admin/index');
        }

        $country->delete();

        return redirect()->route('admin.countries.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}

