<?php

namespace App\Http\Requests\Frontend\Instructor;

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
                        'title.*'                 =>  'required|max:255',
                        'subtitle.*'                 =>  'nullable|max:255',
                        'description.*'                 =>  'nullable',

                        'skill_level'                      =>  'nullable|numeric',
                        'language'                      =>  'nullable|numeric',
                        'evaluation'                      =>  'nullable|numeric',
                        'lecture_numbers'                      =>  'nullable|numeric',
                        'Duration'                      =>  'nullable',

                        'instructors' => 'nullable|array|min:1',
                        'instructors.*' => 'exists:users,id',



                        'price' => 'nullable|integer|min:0|digits_between: 1,5',
                        'offer_price' => 'nullable|integer|lte:price|digits_between:1,5',

                        // 'offer_price' => 'required_with:price|integer|lte:price|digits_between:1,5',


                        'offer_ends'            =>  'nullable|date_format:Y-m-d',

                        'course_category_id'   =>  'required',
                        'tags.*'                =>  'nullable',
                        'featured'              =>  'nullable',
                        'images'                =>  'nullable',
                        'images.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'views'                 =>  'nullable', // عدد مرات العرض

                        // used always 
                        'status'             =>  'nullable',
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


                        'price' => 'nullable|integer|min:0|digits_between: 1,5',
                        'offer_price' => 'nullable|integer|lte:price|digits_between:1,5',

                        'offer_ends'            =>  'nullable|date_format:Y-m-d',

                        'course_category_id'   =>  'required',
                        'tags.*'                =>  'nullable',
                        'featured'              =>  'nullable',
                        'images'                =>  'nullable',
                        'images.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'views'                 =>  'nullable', // عدد مرات العرض

                        // used always 
                        'status'             =>  'nullable',
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
            'course_category_id'      => '( ' . __('panel.title') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'images'    =>  '( ' . __('panel.images') . ' )',
            'price'    =>  '( ' . __('panel.price') . ' )',
        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.card_name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['description.' . $key       =>  "( " . __('panel.description')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
