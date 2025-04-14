<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HqFrameStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'frame_id',
        'code',
        'gender',
        'color_id',
        'shape_id',
        'opening',
        'purchased',
        'transfered',
        'total',
        'supplier_price',
        'price',
    ];

    protected $dates = ['deleted_at'];

    public function organization()  
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');    
    }

    public function admin()  
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function frame()  
    {
        return $this->belongsTo(Frame::class, 'frame_id', 'id');
    }

    public function frame_color()  
    {
        return $this->belongsTo(FrameColor::class, 'color_id', 'id');    
    }

    public function frame_shape()  
    {
        return $this->belongsTo(FrameShape::class, 'shape_id', 'id');
    }

    public function frame_stock() 
    {
        return $this->hasOne(FrameStock::class, 'hq_stock_id', 'id');
    }
}
