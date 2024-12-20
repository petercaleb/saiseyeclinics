<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
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
        return $this->hasMany(Asset::class, 'type_id', 'id');
    }

    public function asset_transfer()
    {
        # code...
        return $this->hasMany(AssetTransfer::class, 'type_id', 'id');
    }

    public function workshop_asset()
    {
        # code...
        return $this->hasMany(WorkshopAsset::class, 'type_id', 'id');
    }

    public function workshop_transfer_asset()
    {
        # code...
        return $this->hasMany(WorkshopTransferAsset::class, 'type_id', 'id');
    }
}
