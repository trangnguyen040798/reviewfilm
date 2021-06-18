<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            'link' => 'required',
            'film_id' => 'required | numeric',
            'image' => 'required',
            'episode' => 'required | numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  'Mời bạn điền link phim',
            'film_id.required' =>  'Id phim không được để trống',
            'ilm_id.numeric' =>  'Id phim phải là số',
            'episode.required' => 'Mời nhập quốc số tập phim',
            'episode.numeric' => 'Số tập phim phải là số',
        ];
    }
}
