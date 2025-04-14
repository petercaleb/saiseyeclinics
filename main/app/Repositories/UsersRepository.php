<?php 

namespace App\Repositories;

use App\Models\Clinic;
use App\Models\Organization;

class UsersRepository
{
    public function all(Organization $organization)  
    {
        return $organization->user()->with(['clinic'])->latest()->get();
    }

    public function find_users_for_clinic(Clinic $clinic)  
    {
       return $clinic->user()->latest()->get();
    }

    public function store(array $attributes)  
    {
        
    }

    public function transferToAnotherClinic()  
    {
        
    }

    public function showUser($id)  
    {
        
    }

    public function updateUser()  
    {
        
    }

    public function destroyUser()  
    {
        
    }
}