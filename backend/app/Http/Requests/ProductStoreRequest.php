<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'brand' => 'required',
            'price' => 'required', // same as before. for this purpose i went with integer prices
            'stock' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product id is required!',
            'name.required' => 'Name is required!',
            'description.required' => 'Description is required!',
            'brand.required' => 'Brand is required!',
            'price.required' => 'Price is required!',
            'stock.required' => 'Stock is required!'
        ];
    }
}
