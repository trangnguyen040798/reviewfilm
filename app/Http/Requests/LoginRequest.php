<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|max:15',
        ];
    }

    public function messages()
    {
        return [
            'email.required' =>  __('message.Validate_email_required'),
            'email.email' =>  __('message.Validate_email'),
            'password.required' => __('message.Validate_password_required'),
            'password.min' => __('message.Validate_min') . ' :min ' . __('message.Validate_character'),
            'password.max' => __('message.Validate_max') . ' :max ' . __('message.Validate_character'),
        ];
    }
}
