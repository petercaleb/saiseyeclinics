<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'type_id',
        'condition_id',
        'asset',
        'serial_number',
        'quantity',
        'description',
        'purchase_date',
        'purchase_cost',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
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

    public function asset_transfer()
    {
        # code...
        return $this->hasMany(AssetTransfer::class, 'asset_id', 'id');
    }
}
