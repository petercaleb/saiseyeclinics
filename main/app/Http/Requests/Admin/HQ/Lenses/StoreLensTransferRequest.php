<?php

namespace App\Http\Requests\Admin\HQ\Lenses;

use Illuminate\Foundation\Http\FormRequest;

class StoreLensTransferRequest extends FormRequest
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
            "to_workshop_id" => ["required", "exists:workshops,id"],
            "lens_id" => ["required", "exists:hq_lenses,id"],
            "transfered_date" => ["required", "date"],
            "quantity" => ["required", "numeric"],
            "transfer_status" => ["required", "string"],
            "condition" => ["required", "string"],
        ];
    }
}
