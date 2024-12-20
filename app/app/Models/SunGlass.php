<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SunGlass extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'brand_id',
        'item_code',
        'photo',
        'status',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function frame_brand()
    {
        # code...
        return $this->belongsTo(FrameBrand::class, 'brand_id', 'id');
    }

    public function sun_glass_stock()
    {
        # code...
        return $this->hasMany(SunGlassStock::class, 'glass_id', 'id');
    }
}
