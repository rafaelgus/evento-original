<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShippingInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delivery' => 'required',
            'addressId' => 'required_if:newAddress,==,false',
            'address' => 'required_if:newAddress,==,true',
            'city' => 'required_if:newAddress,==,true',
            'state' => 'required_if:newAddress,==,true',
            'country' => 'required_if:newAddress,==,true',
            'postalCode' => 'required_if:newAddress,==,true'
        ];
    }
}
