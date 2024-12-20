<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'from_workshop_id',
        'hq_lens_id',
        'technician_id',
        'lens_code',
        'received_date',
        'quantity',
        'is_hq',
        'received_status',
        'condition',
        'remarks',
    ];

    public function organization() 
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function workshop()  
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    public function from_workshop()  
    {
        return $this->belongsTo(Workshop::class, 'from_workshop_id')->withTrashed();
    }
    
    public function hq_lens()  
    {
        return $this->belongsTo(HqLens::class, 'hq_lens_id');
    }

    public function technician()  
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }
}
