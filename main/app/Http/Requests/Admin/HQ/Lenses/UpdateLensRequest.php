<?php

namespace App\Http\Requests\Admin\HQ\Lenses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLensRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'power' => ['required'],
            'lens_type_id' => ['required', 'integer', 'exists:lens_types,id'],
            'lens_material_id' => ['required', 'integer', 'exists:lens_materials,id'],
            'lens_index' =>[ 'required'],
            'eye' => ['required', 'string'],
            'opening' => ['nullable', 'integer'],
        ];
    }
}
