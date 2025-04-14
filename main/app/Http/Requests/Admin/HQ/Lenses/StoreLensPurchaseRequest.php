<?php

namespace App\Http\Requests\Admin\HQ\Lenses;

use Illuminate\Foundation\Http\FormRequest;

class StoreLensPurchaseRequest extends FormRequest
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
            'lens_id' => ['required', 'integer', 'exists:hq_lenses,id'],
            'vendor_id' => ['required', 'integer', 'exists:vendors,id'],
            'receipt_number' => ['required'],
            'attachment' => ['nullable', 'mimes:pdf,doc,docx,ppt,xls,txt'],
            'purchase_date' => ['required', 'date'],
            'quantity' => ['required', 'integer'],
            'price' => ['required']
        ];
    }
}
