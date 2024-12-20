<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensPrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'power_id',
        'type_id',
        'material_id',
        'index',
        'tint',
        'diameter',
        'focal_height',
    ];

    public function lens_power()
    {
        # code...
        return $this->belongsTo(LensPower::class, 'power_id', 'id');
    }

    public function lens_type()
    {
        # code...
        return $this->belongsTo(LensType::class, 'type_id', 'id');
    }

    public function lens_material()
    {
        # code...
        return $this->belongsTo(LensMaterial::class, 'material_id', 'id');
    }

    public function frame_prescription()
    {
        # code...
        return $this->hasOne(FramePrescription::class, 'power_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasOne(Order::class, 'lens_prescription_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'lens_prescription_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->hasOne(Treatment::class, 'lens_prescription_id', 'id');
    }
}
