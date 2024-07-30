<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            case 'POST': {
                    return [
                        'name'          =>  'required|max:255',
                        'user_id'       =>  'nullable',
                        'reviewable_id' =>  'required',
                        'email'         =>  'required|email',
                        'title'         =>  'required',
                        'message'       =>  'required',
                        'rating'        =>  'required|numeric',
                        'status'        =>  'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'          =>  'required|max:255',
                        'user_id'       =>  'nullable',
                        'reviewable_id' =>  'required',
                        'email'         =>  'required|email',
                        'title'         =>  'required',
                        'message'       =>  'required',
                        'rating'        =>  'required|numeric',
                        'status'        =>  'required',
                    ];
                }

            default:
                break;
        }
    }
}
