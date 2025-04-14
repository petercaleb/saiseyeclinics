<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SunGlassStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'glass_id',
        'color_id',
        'gender',
        'shape_id',
        'size_id',
        'opening_stock',
        'purchase_stock',
        'total_stock',
        'sold_stock',
        'closing_stock',
        'price',
        'supplier_price',
        'remarks',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function sun_glass()
    {
        # code...
        return $this->belongsTo(SunGlass::class, 'glass_id', 'id');
    }

    public function color()
    {
        # code...
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function shape()
    {
        # code...
        return $this->belongsTo(Shape::class, 'shape_id', 'id');
    }

    public function size()
    {
        # code...
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
}

