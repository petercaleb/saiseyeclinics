<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLens extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'technician_id',
        'power',
        'lens_type_id',
        'lens_material_id',
        'lens_index',
        'eye',
        'date_requested',
        'quantity',
        'status',
    ];

    public function organuzation() 
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');    
    }

    public function workshop()  
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function technician()  
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'id');   
    }

    public function lens_type()  
    {
        return $this->belongsTo(LensType::class, 'lens_type_id', 'id');
    }

    public function lens_material() 
    {
        return $this->belongsTo(LensMaterial::class, 'lens_material_id', 'id');    
    }
}
