<?php

namespace App\Http\Requests\Users\Frames;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrameReceivedRequest extends FormRequest
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
            'hq_frame_transfer_id' => ['required', 'integer', 'exists:hq_frame_transfers,id'],
            'received_date' => ['required', 'date'],
            'received_status' => ['required', 'boolean'],
            'condition' => ['required', 'string'],
            'from_clinic_id' => ['required_if:is_hq,0'],
            'is_hq' => ['required', 'boolean'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
