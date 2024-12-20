<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id', 
        'clinic_id',
        'hq_stock_id',
        'frame_id',
        'code',
        'opening',
        'received',
        'transfered',
        'total',
        'sold',
        'closing',
        'price',
        'remarks',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function hq_stock()
    {
        # code...
        return $this->belongsTo(HqFrameStock::class, 'hq_stock_id', 'id');
    }

    public function frame()
    {
        # code...
        return $this->belongsTo(Frame::class, 'frame_id', 'id');
    }

    public function frame_purchase()
    {
        # code...
        return $this->hasMany(FramePurchase::class, 'stock_id', 'id');
    }

    public function frame_prescription()
    {
        # code...
        return $this->hasMany(FramePrescription::class, 'stock_id', 'id');
    }

    public function received_frame() 
    {
        return $this->hasMany(ReceivedFrame::class, 'stock_id', 'id');    
    }
}
