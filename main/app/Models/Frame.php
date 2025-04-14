<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'brand_id',
        'type_id',
        'size_id',
        'material_id',
        'code',
        'photo',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function frame_brand()
    {
        return $this->belongsTo(FrameBrand::class, 'brand_id', 'id');
    }

    public function frame_type()
    {
        # code...
        return $this->belongsTo(FrameType::class, 'type_id', 'id');
    }

    public function frame_material()
    {
        # code...
        return $this->belongsTo(FrameMaterial::class, 'material_id', 'id');
    }

    public function frame_size()
    {
        # code...
        return $this->belongsTo(FrameSize::class, 'size_id', 'id');
    }

    public function frame_stock()
    {
        # code...
        return $this->hasMany(FrameStock::class, 'frame_id', 'id');
    }

    public function frame_purchase()
    {
        # code...
        return $this->hasMany(FramePurchase::class, 'frame_id', 'id');
    }

    public function hq_frame_stock()  
    {
        return $this->hasMany(HqFrameStock::class, 'frame_id', 'id');
    }
}
