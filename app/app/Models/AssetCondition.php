<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCondition extends Model
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

    public function asset()
    {
        # code...
        return $this->hasMany(Asset::class, 'condition_id', 'id');
    }

    public function asset_tranfer()
    {
        # code...
        return $this->hasMany(AssetTransfer::class, 'condition_id', 'id');
    }

    public function workshop_asset()
    {
        # code...
        return $this->hasMany(WorkshopAsset::class, 'condition_id', 'id');
    }

    public function workshop_transfer_asset()
    {
        # code...
        return $this->hasMany(WorkshopTransferAsset::class, 'condition_id', 'id');
    }
}
