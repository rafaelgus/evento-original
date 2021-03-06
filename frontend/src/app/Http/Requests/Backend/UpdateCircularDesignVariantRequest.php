<?php
namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCircularDesignVariantRequest extends FormRequest
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
            'name' => 'required|max:255|unique:EventoOriginal\Core\Entities\CircularDesignVariant,id,' .
                $this->get('id'),
            'design_material_size_id' => 'required',
            'number_of_circles' => 'required|numeric',
            'diameter_of_circles' => 'required|numeric',
            'price' => 'required|numeric',
        ];
    }
}
