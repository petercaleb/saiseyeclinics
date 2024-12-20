<?php

namespace App\Http\Requests\Users\Lens;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFramePrescriptionRequest extends FormRequest
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
            'frame_prescription_id' => 'required|integer|exists:frame_prescriptions,id',
            'stock_id' => 'required|integer|exists:frame_stocks,id',
            'case_stock_id' => 'required|integer|exists:case_stocks,id',
            'workshop_id' => 'required|integer|exists:workshops,id',
            'remarks' => 'nullable|string|max:255',
        ];
    }
}
