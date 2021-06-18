<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => 'required | unique:categories,slug,'. $this->id,
            'type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' =>  'Mời bạn nhập tên danh mục',
            'slug.required' =>  'Mời bạn nhập slug',
            'slug.unique' =>  'Slug đã tồn tại',
            'type.required' => 'Mời chọn loại danh mục'
        ];
    }
}
