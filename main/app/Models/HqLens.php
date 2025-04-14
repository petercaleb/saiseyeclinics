<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqLens extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'power',
        'code',
        'lens_type_id',
        'lens_material_id',
        'lens_index',
        'date_added',
        'eye',
        'opening',
        'purchased',
        'transfered',
        'total',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function admin()
    {
        # code...
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function lens_type()
    {
        # code...
        return $this->belongsTo(LensType::class, 'lens_type_id', 'id');
    }

    public function lens_material()
    {
        # code...
        return $this->belongsTo(LensMaterial::class, 'lens_material_id', 'id');
    }
}
