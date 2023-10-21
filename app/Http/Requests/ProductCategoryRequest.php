<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
        return [
            'Type' => ['required'],
            'price' => ['required'],
            'name' => ['required'],
            'image' => 'required|image|mimes:jpg,png|max:2048',
            'product_code' => ['required'],
            'Brand' => ['required'],
            'desc' => ['required'],
            'Quntity' => ['required'],
        ];
    }
}
