<?php

namespace App\Http\Requests\Users\Frames;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrameRequest extends FormRequest
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
            'hq_stock_id' => ['required', 'integer', 'exists:hq_frame_stocks,id'],
            'request_date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }
}
