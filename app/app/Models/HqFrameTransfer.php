<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqFrameTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'to_clinic_id',
        'stock_id',
        'frame_code',
        'transfer_date',
        'quantity',
        'transfer_status',
        'condition',
        'received_status',
        'remarks',
    ];

    public function organization() 
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function admin()
    {
        # code...
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function to_clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'to_clinic_id', 'id');
    }

    public function hq_frame_stock() 
    {
        # code...
        return $this->belongsTo(HqFrameStock::class, 'stock_id', 'id');
    }

}
