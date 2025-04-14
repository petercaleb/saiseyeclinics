<?php

namespace App\Http\Requests\Users\Payments;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentsAttachmentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'mimes:pdf,docx,txt']
        ];
    }
}
