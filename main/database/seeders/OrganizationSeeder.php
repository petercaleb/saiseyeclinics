<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        $organizations = [
            [
                'organization' => 'Sais Eye Clinic',
                'tagline' => 'Sais Eye Clinic',
                'logo' => 'noimage.png',
                'phone' => '0701666667',
                'email' => 'info@saiseyeclinics.com',
                'address' => 'Nairobi',
                'location' => 'Nairobi, Kenya',
                'website' => 'https://saiseyeclinics.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach($organizations as $org)
        {
            if(!DB::table('organizations')->where('organization', $org['organization'])->exists())
            {
                DB::table('organizations')->insert($org);
            }
        }
    }
}
