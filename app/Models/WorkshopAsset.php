<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'type_id',
        'condition_id',
        'asset',
        'serial_number',
        'quantity',
        'description',
        'purchase_date',
        'purchase_cost',
    ];

    public function organzation()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
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

    public function workshop_transfer_asset()
    {
        # code...
        return $this->hasMany(WorkshopTransferAsset::class, 'asset_id', 'id');
    }
}
