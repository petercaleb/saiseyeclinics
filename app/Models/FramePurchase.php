<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FramePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'clinic_id',
        'stock_id',
        'frame_id',
        'code',
        'color_id',
        'shape_id',
        'receipt_number',
        'purchase_date',
        'gender',
        'quantity',
        'price',
        'total',
        'supplier',
        'receipt',
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

    public function frame_stock()
    {
        # code...
        return $this->belongsTo(FrameStock::class, 'stock_id', 'id');
    }

    public function frame()
    {
        # code...
        return $this->belongsTo(Frame::class, 'frame_id', 'id');
    }

    public function frame_color()
    {
        # code...
        return $this->belongsTo(FrameColor::class, 'color_id', 'id');
    }

    public function frame_shape()
    {
        # code...
        return $this->belongsTo(FrameShape::class, 'shape_id', 'id');
    }
}
