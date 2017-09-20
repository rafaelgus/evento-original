<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->isUser();
    }

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