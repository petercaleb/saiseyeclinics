<?php

namespace App\Http\Requests\Admin\Billing;

use Illuminate\Foundation\Http\FormRequest;

class StoreRemmittanceRequest extends FormRequest
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
            'payment_bill_id' => ['required', 'array'],
            'payment_bill_id.*' => ['exists:payment_bills,id']
        ];
    }
}
