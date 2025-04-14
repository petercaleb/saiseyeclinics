<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'technician_id',
        'to_workshop_id',
        'lens_id',
        'transfered_date',
        'quantity',
        'condition',
        'status',
        'remarks',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function technician()
    {
        # code...
        return $this->belongsTo(Technician::class, 'technician_id', 'id');
    }

    public function to_workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'to_workshop_id', 'id');
    }

    public function lens()
    {
        # code...
        return $this->belongsTo(Lens::class, 'lens_id', 'id');
    }
}
