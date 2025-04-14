<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameShape extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'shape',
        'slug',
        'description',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function frame_stock()
    {
        # code...
        return $this->hasMany(FrameStock::class, 'shape_id', 'id');
    }

    public function frame_purchase()
    {
        # code...
        return $this->hasMany(FramePurchase::class, 'shape_id', 'id');
    }
}
