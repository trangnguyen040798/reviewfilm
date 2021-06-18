<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'slug' => 'required | unique:news',
            'image' => 'required',
            'content' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' =>  'Mời bạn nhập tên danh mục',
            'slug.required' =>  'Mời bạn nhập slug',
            'slug.unique' =>  'Slug đã tồn tại',
            'image.required' => 'Mời chọn ảnh',
            'content.required' => 'Mời nhập nội dung bản tin',
            'category_id.required' => 'Mời nhập nội dung bản tin'
        ];
    }
}
