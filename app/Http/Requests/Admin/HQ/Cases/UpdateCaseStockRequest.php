<?php

namespace App\Http\Requests\Admin\HQ\Cases;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCaseStockRequest extends FormRequest
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
            'case_id' => ['required', 'integer', 'exists:frame_cases,id'],
            'opening' => ['required', 'integer'],
            'supplier_price' => ['required'],
            'price' => ['required']
        ];
    }
}
