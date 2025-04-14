<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'from_clinic_id',
        'to_clinic_id',
        'stock_id',
        'transfer_user_id',
        'frame_code',
        'transfer_date',
        'quantity',
        'transfer_status',
        'condition',
        'remarks',
    ];

    public function from_clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'from_clinic_id', 'id');
    }

    public function to_clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'to_clinic_id', 'id');
    }

    public function frame_stock() 
    {
        # code...
        return $this->belongsTo(FrameStock::class, 'stock_id', 'id');
    }

    public function received_frame() 
    {
        return $this->hasMany(ReceivedFrame::class, 'transfer_id', 'id');   
    }
}
