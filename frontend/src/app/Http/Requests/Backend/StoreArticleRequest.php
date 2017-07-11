<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreArticleRequest extends FormRequest
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
            'shortDescription' => 'required|max:255',
            'category' => 'required',
            'barCode' => 'required|max:255|unique:EventoOriginal\Core\Entities\Article,barCode',
            'internalCode' => 'required|max:255|unique:EventoOriginal\Core\Entities\Article,internalCode',
            'price' => 'required',
            'costPrice' => 'required',
            'allergens' => 'required',
            'colors' => 'required',
            'flavours' => 'required',
            'tags' => 'required'
        ];
    }
}
