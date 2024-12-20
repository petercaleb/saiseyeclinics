<?php

namespace App\Http\Requests\Admin\Clinic\Cases;

use Illuminate\Foundation\Http\FormRequest;

class CasesStockRequest extends FormRequest
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
            'clinic_id' => ['required', 'exists:clinics,id'],
            'case_id' => ['required', 'exists:frame_cases,id'],
            'stock' => ['required'],
            'remarks' => ['nullable']
        ];
    }
}
