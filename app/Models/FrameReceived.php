<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameReceived extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'clinic_id',
        'from_clinic_id',
        'hq_frame_stock_id',
        'user_id',
        'frame_id',
        'frame_code',
        'received_date',
        'quantity',
        'received_status',
        'is_hq',
        'condition',
        'remarks',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function fromClinic()
    {
        return $this->belongsTo(Clinic::class, 'from_clinic_id');
    }

    public function hqFrameStock()
    {
        return $this->belongsTo(HqFrameStock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }
}
