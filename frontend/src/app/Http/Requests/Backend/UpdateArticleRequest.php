<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:500',
            'category' => 'required',
            'barCode' => 'required|max:255',
            'internalCode' => 'required|max:255',
            'costPrice' => 'required',
            'allergens' => 'required',
            'colors' => 'required',
            'flavours' => 'required',
            'tags' => 'required'
        ];
    }
}
