<?php

namespace App\Http\Requests\Admin\HQ\Cases;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseTransferRequest extends FormRequest
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
            "to_clinic_id" => ["required_if:to_workshop_id,null", "exists:clinics,id"],
            "to_workshop_id" => ["required_if:to_clinic_id,null", "exists:workshops,id"],
            "stock_id" => ["required", "exists:hq_case_stocks,id"],
            "transfer_date" => ["required", "date"],
            "quantity" => ["required", "numeric"],
            "transfer_status" => ["required", "string"],
            "condition" => ["required", "string"],
        ];
    }
}
