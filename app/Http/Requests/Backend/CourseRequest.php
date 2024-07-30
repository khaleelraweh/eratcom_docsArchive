<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
                        'title'                 =>  'required|max:255',
                        'subtitle.*'                 =>  'nullable|max:255',
                        'description.*'                 =>  'nullable',

                        'skill_level'                      =>  'nullable|numeric',
                        'language'                      =>  'nullable|numeric',
                        'evaluation'                      =>  'nullable|numeric',
                        'lecture_numbers'                      =>  'nullable|numeric',
                        'Duration'                      =>  'nullable',

                        'instructors' => 'required|array|min:1',
                        'instructors.*' => 'exists:users,id',



                        'price' => 'required|integer|min:0|digits_between: 1,5',
                        'offer_price' => 'nullable|integer|lte:price|digits_between:1,5',

                        // 'offer_price' => 'required_with:price|integer|lte:price|digits_between:1,5',


                        'offer_ends'            =>  'nullable|date_format:Y-m-d',

                        'course_category_id'   =>  'required',
                        'tags.*'                =>  'required',
                        'featured'              =>  'required',
                        'images'                =>  'required',
                        'images.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'views'                 =>  'nullable', // عدد مرات العرض

                        // used always 
                        'status'             =>  'required',
                        'published_on'       =>  'nullable',
                        'published_on_time'  =>  'nullable',
                        'created_by'         =>  'nullable',
                        'updated_by'         =>  'nullable',
                        'deleted_by'         =>  'nullable',
                        // end of used always 
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title.*'                  =>  'required|max:255',
                        'subtitle.*'                 =>  'nullable|max:255',
                        'description.*'           =>  'nullable',

                        'skill_level'                      =>  'nullable|numeric',
                        'language'                      =>  'nullable|numeric',
                        'evaluation'                      =>  'nullable|numeric',
                        'lecture_numbers'                      =>  'nullable|numeric',
                        'Duration'                      =>  'nullable',


                        'price' => 'required|integer|min:0|digits_between: 1,5',
                        'offer_price' => 'nullable|integer|lte:price|digits_between:1,5',

                        'offer_ends'            =>  'nullable|date_format:Y-m-d',

                        'course_category_id'   =>  'required',
                        'tags.*'                =>  'required',
                        'featured'              =>  'required',
                        'images'                =>  'nullable',
                        'images.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'views'                 =>  'nullable', // عدد مرات العرض

                        // used always 
                        'status'             =>  'required',
                        'published_on'       =>  'nullable',
                        'published_on_time'  =>  'nullable',
                        'created_by'         =>  'nullable',
                        'updated_by'         =>  'nullable',
                        'deleted_by'         =>  'nullable',
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
            'title'                 =>  '(' . __('panel.title') . ')',
            'description'           =>  '(' . __('panel.description') . ')',
            'course_category_id'      => '( ' . __('panel.course_title') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'images'    =>  '( ' . __('panel.images') . ' )',
            'price'    =>  '( ' . __('panel.price') . ' )',
        ];

        return $attr;
    }
}
