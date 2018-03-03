<?php
namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMaterialDesignSizeRequest extends FormRequest
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
            'name' => 'required|max:255|unique:EventoOriginal\Core\Entities\DesignMaterialSize,id,' . $this->get('id'),
            'horizontal_size' => 'required',
            'vertical_size' => 'required',
            'horizontal_size_in_px' => 'required',
            'vertical_size_in_px' => 'required',
        ];
    }
}
