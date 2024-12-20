<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'slug',
        'description',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function lens_prescription()
    {
        # code...
        return $this->hasMany(LensPrescription::class, 'type_id', 'id');
    }

    public function contact_len()
    {
        # code...
        return $this->hasMany(ContactLen::class, 'material_id', 'id');
    }

    public function lens()
    {
        # code...
        return $this->hasMany(Lens::class, 'lens_material_id', 'id');
    }
}
