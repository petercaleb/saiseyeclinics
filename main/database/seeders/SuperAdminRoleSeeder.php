<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voids
     */
    public function run()
    {
        // Create the "super-admin" role for the admin guard
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);

        // Attach permissions to the admin role
        $permissions = Permission::where('guard_name', 'admin')->get();
        $superAdminRole->syncPermissions($permissions);

        // Optionally: Give "super-admin" all permissions
        $permissions = Permission::all();
        $superAdminRole->syncPermissions($permissions);

        // Optionally: Assign this role to a specific admin user
        $admin = Admin::where('email', 'admin@saiseyeclinics.com')->first();

        if ($admin) {
            $admin->assignRole($superAdminRole->name);
        }
    }
}
