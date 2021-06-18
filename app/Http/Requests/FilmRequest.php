<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
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
            'name' => 'required',
            'year' => 'required | numeric',
            'type' => 'required',
            'country_id' => 'required | numeric',
            'total_episodes' => 'required | numeric',
            'image' => 'required',
            'categories' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  'Mời bạn nhập tên tên phim',
            'year.required' =>  'Mời bạn nhập năm phát hành',
            'year.numeric' =>  'Năm phát hành phải là số',
            'country_id.required' => 'Mời chọn quốc gia',
            'country_id.numeric' => 'Quốc gia Id phải là số',
            'total_episodes.required' => 'Mời bạn nhập tổng số tập phim',
            'total_episodes.numeric' => 'Tổng số tập phim phải là số',
            'type.required' =>  'Mời bạn chọn hình thức phim',
            'image.required' =>  'Mời bạn chọn ảnh',
            'categories.required' =>  'Mời bạn chọn thể loại phim',
        ];
    }
}
