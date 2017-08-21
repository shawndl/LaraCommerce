<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'username' => 'required|unique:users|alpha_dash',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
