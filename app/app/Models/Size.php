<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'size',
        'slug',
        'description',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function sun_glass_stock()
    {
        # code...
        return $this->hasMany(SunGlassStock::class, 'size_id', 'id');
    }
}
