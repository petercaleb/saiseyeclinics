<?php

namespace App\Http\Requests\Technicians\Lens;

use Illuminate\Foundation\Http\FormRequest;

class RequestLensRequest extends FormRequest
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
            'power' => ['required', 'string'],
            'workshop_id' => ['required', 'integer', 'exists:workshops,id'],
            'lens_type_id' => ['required', 'integer', 'exists:lens_types,id'],
            'lens_material_id' => ['required', 'integer', 'exists:lens_materials,id'],
            'lens_index' => ['required'],
            'eye' => ['required', 'string'],
            'quantity' => ['required', 'integer']
        ];
    }
}
