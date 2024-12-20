<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'asset_id',
        'from_clinic_id',
        'to_clinic_id',
        'transfer_date',
        'type_id',
        'condition_id',
        'quantity',
        'remarks',
    ];

    public function asset()
    {
        # code...
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function from_clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'from_clinic_id', 'id');
    }

    public function to_clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'to_clinic_id', 'id');
    }

    public function asset_type()
    {
        # code...
        return $this->belongsTo(AssetType::class, 'type_id', 'id');
    }

    public function asset_condition()
    {
        # code...
        return $this->belongsTo(AssetCondition::class, 'condition_id', 'id');
    }
}
