<?php

namespace App\Http\Requests\Admin\HQ\Frames;

use Illuminate\Foundation\Http\FormRequest;

class StoreFramePurchaseRequest extends FormRequest
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
            'stock_id' => 'required|integer|exists:hq_frame_stocks,id',
            'receipt_number' => 'required',
            'quantity' => 'required|numeric',
            'receipt' => 'nullable|mimes:pdf,doc,docx,ppt,xls,txt',
        ];
    }
}
