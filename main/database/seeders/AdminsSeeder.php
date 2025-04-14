<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admins = [
            [
                'organization_id' => 1,
                'first_name' => 'Sri',
                'last_name' => 'Harsha',
                'profile' => 'noimage.png',
                'phone' => '0781666999',
                'email' => 'admin@saiseyeclinics.com',
                'gender' => 'Male', 
                'dob' => '2008-07-30',
                'status' => 1,
                'username' => 'Admin',
                'password' => Hash::make('Harsha')
            ]
        ];
        foreach($admins as $admin)
        {
            if(!DB::table('admins')->where('username', $admin['username'])->orWhere('email', $admin['email'])->exists())
            {
                DB::table('admins')->insert($admin);
            }
        }
        
    }
}
