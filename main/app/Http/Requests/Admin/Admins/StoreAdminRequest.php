<?php

namespace App\Http\Requests\Admin\Admins;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
            'phone' => 'required|string|max:255|unique:admins,phone,' . Auth::guard('admin')->user()->id,
            'email' => 'required|string|email|max:255|unique:admins,email,' . Auth::guard('admin')->user()->id,
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ];
    }
}
