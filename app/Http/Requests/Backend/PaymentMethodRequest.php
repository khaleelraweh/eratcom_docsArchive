<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
                    'name'                  =>  'required|max:255',
                    'code'                  =>  'required|max:255|unique:payment_methods,code',
                    'driver_name'           =>  'required|max:255|unique:payment_methods,driver_name',
                    

                    // for live start 
                    'merchant_email'        =>  'nullable|email',
                    'merchant_password'     =>  'nullable',
                    'client_id'             =>  'nullable',
                    'client_secret'         =>  'nullable',
                    'username'              =>  'nullable',
                    'password'              =>  'nullable',
                    'signature'             =>  'nullable',
                    //for live end 

                    // for live start 
                    'sandbox_merchant_email'      =>  'nullable|email',
                    'sandbox_merchant_password'   =>  'nullable',
                    'sandbox_client_id'           =>  'nullable',
                    'sandbox_client_secret'       =>  'nullable',
                    'sandbox_username'            =>  'nullable',
                    'sandbox_password'            =>  'nullable',
                    'sandbox_signature'           =>  'nullable',
                    //for live end

                    'sandbox'                     =>  'nullable',
                    'status'                      =>  'required',
                    'images'                      =>  'required',  
                    'images.*'                    =>  'mimes:jpg,jpeg,png,gif|max:3000',

                    //common start 
                    'published_on'       =>  'nullable',
                    'published_on_time'  =>  'nullable',
                    'created_by'         =>  'nullable',
                    'updated_by'         =>  'nullable',
                    'deleted_by'         =>  'nullable',
                    //common end 

                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'                  =>  'required|max:255',
                    'code'                  =>  'required|max:255|unique:payment_methods,code,' .$this->route()->payment_method->id,
                    'driver_name'           =>  'required|max:255|unique:payment_methods,driver_name,'.$this->route()->payment_method->id,
                    

                    // for live start 
                    'merchant_email'        =>  'nullable|email',
                    'merchant_password'     =>  'nullable',
                    'client_id'             =>  'nullable',
                    'client_secret'         =>  'nullable',
                    'username'              =>  'nullable',
                    'password'              =>  'nullable',
                    'signature'             =>  'nullable',
                    //for live end 

                    // for live start 
                    'sandbox_merchant_email'        =>  'nullable|email',
                    'sandbox_merchant_password'     =>  'nullable',
                    'sandbox_client_id'             =>  'nullable',
                    'sandbox_client_secret'         =>  'nullable',
                    'sandbox_username'              =>  'nullable',
                    'sandbox_password'              =>  'nullable',
                    'sandbox_signature'             =>  'nullable',
                    //for live end

                    'sandbox'                     =>  'nullable',
                    'status'                      =>  'required',
                    'images'                      =>  'nullable',  
                    'images.*'                    =>  'mimes:jpg,jpeg,png,gif|max:3000',

                    //common start 
                    'published_on'       =>  'nullable',
                    'published_on_time'  =>  'nullable',
                    'created_by'         =>  'nullable',
                    'updated_by'         =>  'nullable',
                    'deleted_by'         =>  'nullable',
                    //common end 
                ];
            }
            
            default: break;
                
        }
    }
}
