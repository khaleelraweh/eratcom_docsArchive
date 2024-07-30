<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
                        'currency_name.*'       =>  'required|max:255|unique_translation:currencies',
                        'currency_symbol.*'     =>  'required',
                        'currency_code'         =>  'required',
                        'exchange_rate'         =>  'required|numeric',

                        // used always 
                        'status'                =>  'required',
                        'published_on'          =>  'nullable',
                        'published_on_time'     =>  'nullable',
                        'created_by'            =>  'nullable',
                        'updated_by'            =>  'nullable',
                        'deleted_by'            =>  'nullable',
                        // end of used always 
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'currency_name.*'       =>  'required|max:255|unique_translation:currencies,currency_name,' . $this->route()->currency,
                        'currency_symbol.*'     =>  'required',
                        'currency_code'         =>  'required',
                        'exchange_rate'         =>  'required|numeric',

                        // used always 
                        'status'                =>  'required',
                        'published_on'          =>  'nullable',
                        'published_on_time'     =>  'nullable',
                        'created_by'            =>  'nullable',
                        'updated_by'            =>  'nullable',
                        'deleted_by'            =>  'nullable',
                        // end of used always 
                    ];
                }

            default:
                break;
        }
    }

    public function attributes(): array
    {
        $attr = [
            'currency_code'    =>  '( ' . __('panel.currency_code') . ' )',
            'exchange_rate'    =>  '( ' . __('panel.currency_exchange_rate') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['currency_name.' . $key       =>  "( " . __('panel.currency_name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['currency_symbol.' . $key       =>  "( " . __('panel.currency_symbol')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }

        return $attr;
    }
}
