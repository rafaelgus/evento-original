<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required',
            'addressNumber' => 'required',
            'billingAddress' => 'required',
            'billingAddressNumber' => 'required',
            'phone' => 'required',
            'postalCode' => 'required',
            'city' => 'required',
            'country' => 'required'
        ];
    }
}
