<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//TODO change to must be logged in
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|alpha_spaces',
            'category' => 'required|numeric',
            'description' => 'required',
            'price' => 'required|regex:/^(\d{1,8})\.(\d{2})$/',
            'weight' => 'required|regex:/^\d*\.?\d*$/',
            'image' => 'required_without:upload|url',
            'upload' => 'required_without:image|image',
            'thumbnail' => 'url'
        ];
    }
}
