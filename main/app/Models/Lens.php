<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lens extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'hq_lens_id',
        'workshop_id',
        'eye',
        'opening',
        'received',
        'transfered',
        'total',
        'sold',
        'closing',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function hq_lens()
    {
        return $this->belongsTo(HqLens::class, 'hq_lens_id', 'id');    
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
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

    public function lens_purchase()
    {
        # code...
        $this->hasMany(LensPurchase::class, 'lens_id', 'id');
    }

    public function lens_transfer()
    {
        # code...
        return $this->hasMany(LensTransfer::class, 'lens_id', 'id');
    }

    public function workshop_sale()
    {
        # code...
        return $this->hasMany(WorkshopSale::class, 'lens_id', 'id');
    }
}
