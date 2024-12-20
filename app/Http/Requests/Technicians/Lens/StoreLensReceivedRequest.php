<?php

namespace App\Http\Requests\Technicians\Lens;

use Illuminate\Foundation\Http\FormRequest;

class StoreLensReceivedRequest extends FormRequest
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
            'hq_lens_transfer_id' => ['required', 'integer', 'exists:hq_lens_transfers,id'],
            'received_date' => ['required', 'date'],
            'received_status' => ['required', 'boolean'],
            'condition' => ['required', 'string'],
            'from_workshop_id' => ['required_if:is_hq,0'],
            'is_hq' => ['required', 'boolean'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
