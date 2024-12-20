<?php

namespace App\Http\Requests\Admin\HQ\Frames;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrameTransferRequest extends FormRequest
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
            "to_clinic_id" => ["required", "exists:clinics,id"],
            "stock_id" => ["required", "exists:hq_frame_stocks,id"],
            "transfer_date" => ["required", "date"],
            "quantity" => ["required", "numeric"],
            "transfer_status" => ["required", "string"],
            "condition" => ["required", "string"],
        ];
    }
}
