<?php
namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOccasionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return current_user_is_admin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:EventoOriginal\Core\Entities\Occasion,id' . $this->get('id'),
        ];
    }
}
