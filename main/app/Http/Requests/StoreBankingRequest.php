<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankingRequest extends FormRequest
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
            "date_received" => ['required', 'date'],
            "transaction_code" => ['required'],
            "transaction_mode" => ['required', "integer"],
            "insurance_id" => ['required', 'integer', 'exists:insurances,id'],
            // "remmittance_id" => ['required', 'array'],
            // "remmittance_id.*" => ['exists:remmittances,id'],
            "paid" => ['required'],
            "notes" => ['nullable']
        ];
    }
}
