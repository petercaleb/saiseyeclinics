<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensType extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'type',
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
        return $this->hasMany(ContactLen::class, 'type_id', 'id');
    }

    public function lens()
    {
        # code...
        return $this->hasMany(Lens::class, 'lens_type_id', 'id');
    }
}
