<?php

namespace App\Http\Requests\Technicians\Lens;

use Illuminate\Foundation\Http\FormRequest;

class StoreLensRequest extends FormRequest
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
            'hq_lens_id' => ['required', 'integer', 'exists:hq_lenses,id'],
            'request_date' => ['required', 'date'],
            'quantity' => ['required', 'integer'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
