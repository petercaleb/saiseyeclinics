<?php

namespace App\Http\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolesRequest extends FormRequest
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
        // Get the role ID from the route
        $roleId = $this->route('id'); // Make sure this matches your route parameter 'id'

        return [
            //
            // Validate that the role name is required and unique except for the current role
            'role_name' => 'required|unique:roles,name,' . $roleId,
            // Ensure 'permissions' is required and is an array
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id', // Each permission ID must exist in the permissions table
        ];
    }


    public function messages()
    {
        return [
            'role_name.required' => 'The role name is required.',
            'name.unique' => 'This role name is already in use by another role.',
            'permissions.required' => 'You must select at least one permission.',
            'permissions.array' => 'Permissions must be a valid array.',
        ];
    }
}
