<?php

namespace App\Http\Requests\Users\Lens;

use Illuminate\Foundation\Http\FormRequest;

class SubmitLensPowerRequest extends FormRequest
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
            'diagnosis_id' => 'required|integer|exists:diagnoses,id',
            'treatment_id' => 'required|integer|exists:treatments,id',
            'right_sphere' => 'required|string|max:255',
            'right_cylinder' => 'required|string|max:255',
            'right_axis' => 'required|string|max:255',
            'right_add' => 'required|string|max:255',
            'left_sphere' => 'required|string|max:255',
            'left_cylinder' => 'required|string|max:255',
            'left_axis' => 'required|string|max:255',
            'left_add' => 'required|string|max:255',
        ];
    }
}
