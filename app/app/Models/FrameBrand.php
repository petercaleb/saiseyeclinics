<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameBrand extends Model
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
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function frame()
    {
        # code...
        return $this->hasMany(Frame::class, 'brand_id', 'id');
    }

    public function sun_glass()
    {
        # code...
        return $this->hasMany(SunGlass::class, 'brand_id', 'id');
    }
}
