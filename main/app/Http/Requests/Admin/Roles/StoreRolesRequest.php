<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRolesRequest extends FormRequest
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
            'role_name' => ['required', 'string', 'unique:roles,name', 'max:255'],
            'permissions' => 'array', // Validate that permissions is an array
            'permissions.*' => 'exists:permissions,id', // Each permission ID must exist in the permissions table
        ];
    }
}
