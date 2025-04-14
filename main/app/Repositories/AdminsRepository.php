<?php 

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Organization;
use App\Mail\Admins\NewAdminMail;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminsRepository
{
    public function storeAdmin(array $attributes, Organization $organization, $profileNameToStore)  
    {

        $password = Str::random(6);

        $admin = $organization->admin()->create([
            'first_name' => data_get($attributes, 'first_name'),
            'last_name' => data_get($attributes, 'last_name'),
            'profile' => $profileNameToStore,
            'phone' => data_get($attributes, 'phone'),
            'email' => data_get($attributes, 'email'),
            'gender' => data_get($attributes, 'gender'),
            'dob' => data_get($attributes, 'dob'),
            'username' =>  data_get($attributes, 'first_name') . ' ' .  data_get($attributes, 'last_name'),
            'password' => Hash::make($password)
        ]);

        $role = Role::where('id', data_get($attributes, 'role_id'))->where('guard_name', 'admin')->firstOrFail();

        $admin->assignRole($role->name);

        $login = route('admin.login');

        $details = [
            'name' => data_get($attributes, 'first_name') . ' ' .  data_get($attributes, 'last_name'),
            'email' => data_get($attributes, 'email'),
            'password' => $password,
            'login' => $login
        ];

        Mail::to(data_get($attributes, 'email'))->send(new NewAdminMail($details));

        return $admin;
    }

    public function deleteAdmin(Admin $admin)  
    {
        if($admin->delete())
        {
            return true;
        }
        return false;
    }
}