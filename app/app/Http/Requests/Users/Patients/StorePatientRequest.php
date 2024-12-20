<?php

namespace App\Http\Requests\Users\Patients;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'clinic_id' => 'required|integer|exists:clinics,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|unique:patients,id_number',
            'phone' => 'required|numeric|min:10',
            'email' => 'nullable|string|email|max:255',
            'dob' => 'required|string|max:255|date_format:Y-m-d',
            'gender' => 'required|string',
            'next_of_kin_contact' => 'nullable|numeric|min:10',
            'card_number' => 'required|unique:patients,card_number|numeric',
        ];
    }
}
