<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
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
            'occupation' => 'required',
            'country_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  'Mời bạn nhập tên',
            'occupation.required' =>  'Mời bạn nhập nghề nghiệp',
            'country_id.required' => 'Mời bạn chọn quốc gia'
        ];
    }
}
