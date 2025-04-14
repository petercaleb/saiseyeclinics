<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RolesRepository
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function storeRole(array $attributes)
    {
        // Create the new role
        $role = Role::create([
            'name' => data_get($attributes, 'role_name'),
            'guard_name' => 'admin'
        ]);

        // Assign selected permissions to the new role
        $role->syncPermissions();
        
        return $role;
    }
}
