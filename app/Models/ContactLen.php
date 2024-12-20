<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactLen extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'type_id',
        'material_id',
        'item_code',
        'photo',
        'status',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
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
}
