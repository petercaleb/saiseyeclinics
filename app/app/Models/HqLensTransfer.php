<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqLensTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'to_workshop_id',
        'lens_id',
        'transfered_date',
        'quantity',
        'condition',
        'status',
        'received_status',
        'remarks',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function admin()
    {
        # code...
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function to_workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'to_workshop_id', 'id');
    }

    public function hq_lens()
    {
        # code...
        return $this->belongsTo(HqLens::class, 'lens_id', 'id');
    }
}
