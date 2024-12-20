<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopTransferAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'asset_id',
        'from_workshop_id',
        'to_workshop_id',
        'transfer_date',
        'type_id',
        'condition_id',
        'quantity',
        'remarks',
    ];

    
    function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function asset()
    {
        # code...
        return $this->belongsTo(WorkshopAsset::class, 'asset_id', 'id');
    }

    public function from_workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'from_workshop_id', 'id');
    }

    public function to_workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'to_workshop_id', 'id');
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
