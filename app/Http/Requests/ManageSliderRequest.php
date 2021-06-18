<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageSliderRequest extends FormRequest
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
            'film_id' => 'required',
            'tag' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'film_id.required' =>  'Mời bạn nhập tên phim',
            'tag.required' =>  'Mời bạn chọn loại hiển thị trên trang home',
        ];
    }
}
