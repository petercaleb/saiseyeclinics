<?php

namespace App\Http\Requests\Technicians\Cases;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends FormRequest
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
            'hq_case_stock_id' => ['required', 'integer', 'exists:hq_case_stocks,id'],
            'request_date' => ['required', 'date'],
            'quantity' => ['required', 'integer'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
