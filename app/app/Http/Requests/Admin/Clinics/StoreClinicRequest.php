<?php

namespace App\Http\Requests\Admin\Clinics;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicRequest extends FormRequest
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
            'clinic' => 'required|string|max:255',
            'logo' => 'image|mimes:png,jpg,jpeg|nullable|max:2048',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|max:255',
            'location' => 'required|string|max:255',
        ];
    }
}
