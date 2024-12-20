<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'technician_id',
        'hq_lens_id',
        'lens_code',
        'request_date',
        'quantity',
        'status',
        'transfer_status',
        'remarks'
    ];

    public function organization()  
    {
        return $this->belongsTo(Organization::class, 'organization_id');    
    }

    public function workshop()  
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');    
    }

    public function technician()  
    {
        return $this->belongsTo(Technician::class, 'technician_id');   
    }

    public function hq_lens()  
    {
        return $this->belongsTo(HqLens::class, 'hq_lens_id');    
    }
}
