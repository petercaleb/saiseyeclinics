<?php

namespace App\Http\Requests\Users\Appointments;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'patient_id' => 'required|integer|exists:patients,id',
            'client_type_id' => 'required|integer|exists:client_types,id',
            'insurance_id' => 'nullable|integer|exists:insurances,id',
            'scheme' => 'nullable|string|max:255',
            'principal' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'nhif_number' => 'nullable|string|max:255',
            'nhif_principal_member' => 'nullable|string|max:255',
            'nhif_principal_member_phone' => 'nullable|string|max:255',
            'principal_workplace' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:255',
            'hospital_client_number' => 'nullable|string|max:255',
        ];
    }
}
