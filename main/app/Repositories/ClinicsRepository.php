<?php 

namespace App\Repositories;

use App\Models\Clinic;
use App\Models\Organization;

class ClinicsRepository
{
    public function getAllClinics()  
    {
        return Clinic::latest()->get();    
    }

    public function storeClinic(array $attribute, Organization $organization, $logoNameToStore)  
    {
        $clinic = Clinic::create([
            'organization_id' => $organization->id,
            'clinic' => data_get($attribute, 'clinic'),
            'logo' => $logoNameToStore,
            'phone' => data_get($attribute, 'phone'),
            'email' => data_get($attribute, 'email'),
            'address' => data_get($attribute, 'address'),
            'location' => data_get($attribute, 'location'),
            'initials' => data_get($attribute, 'initials'),
            'etims_number' => data_get($attribute, 'etims_number'),
        ]);   

        return $clinic;
    }
}