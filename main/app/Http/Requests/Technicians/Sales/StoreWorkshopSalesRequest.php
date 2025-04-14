<?php

namespace App\Http\Requests\Technicians\Sales;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkshopSalesRequest extends FormRequest
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
            'order_id' => 'required|integer|exists:orders,id',
            'lens_id' => 'required|integer|exists:lenses,id',
            'status' => 'required|string',
        ];
    }
}
