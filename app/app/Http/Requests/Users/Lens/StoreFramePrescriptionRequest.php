<?php

namespace App\Http\Requests\Users\Lens;

use Illuminate\Foundation\Http\FormRequest;

class StoreFramePrescriptionRequest extends FormRequest
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
            'power_id' => ['required', 'integer', 'exists:lens_powers,id'],
            'prescription_id' => ['required', 'integer', 'exists:lens_prescriptions,id'],
            'stock_id' => ['required', 'integer', 'exists:frame_stocks,id'],
            'case_stock_id' => ['required', 'integer', 'exists:case_stocks,id'],
            'receipt_number' => ['required', 'numeric', 'unique:frame_prescriptions,receipt_number'],
            'workshop_id' => ['required', 'integer', 'exists:workshops,id'],
            'remarks' => ['nullable', 'string|max:255'],
        ];
    }
}
