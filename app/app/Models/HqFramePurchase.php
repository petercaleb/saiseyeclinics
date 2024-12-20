<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqFramePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
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
        'vendor_id',
        'attachment',
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

    public function hq_frame_stock()
    {
        # code...
        return $this->belongsTo(HqFrameStock::class, 'stock_id', 'id');
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

    public function vendor()
    {
        # code...
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

}
