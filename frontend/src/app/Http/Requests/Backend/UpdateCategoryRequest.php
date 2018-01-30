<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|max:255|unique:EventoOriginal\Core\Entities\Category,name,' . $this->route('id'),
            'slug' => 'max:255|unique:EventoOriginal\Core\Entities\Category,slug,' . $this->route('id'),
            'description' => 'required',
            'affiliate_commission' => 'required|numeric',
        ];
    }
}
