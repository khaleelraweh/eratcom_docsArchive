<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name'              => 'required|max:255|unique:countries',
                    'name_native'       => 'nullable',
                    'country_code'      => 'nullable',
                    'phone_code'        => 'nullable',
                    'capital'           => 'nullable',
                    'currency'          => 'nullable',
                    'currency_name'     => 'nullable',
                    'currency_name_native'     => 'nullable',
                    'currency_symbol'   => 'nullable',
                    'region'            => 'nullable',
                    'nationality'       => 'nullable',
                    'nationality_native'=> 'nullable',
                    'translations'      => 'nullable',
                    'emoji'             => 'nullable',
                    'status'            =>  'required',

                    'published_on'       =>  'nullable',
                    'published_on_time'  =>  'nullable',
                    'created_by'         =>  'nullable',
                    'updated_by'         =>  'nullable',
                    'deleted_by'         =>  'nullable',

                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'              => 'required|max:255|unique:countries,name,'.$this->route()->country->id,
                    'name_native'       => 'nullable',
                    'country_code'      => 'nullable',
                    'phone_code'        => 'nullable',
                    'capital'           => 'nullable',
                    'currency'          => 'nullable',
                    'currency_name'     => 'nullable',
                    'currency_name_native'     => 'nullable',
                    'currency_symbol'   => 'nullable',
                    'region'            => 'nullable',
                    'nationality'       => 'nullable',
                    'nationality_native'=> 'nullable',
                    'translations'      => 'nullable',
                    'emoji'             => 'nullable',
                    'status'            => 'required',

                    'published_on'       =>  'nullable',
                    'published_on_time'  =>  'nullable',
                    'created_by'         =>  'nullable',
                    'updated_by'         =>  'nullable',
                    'deleted_by'         =>  'nullable',
                ];
            }
            
            default: break;
                
        }
    }
}
