<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'color',
        'slug',
        'description',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function frame_stock()
    {
        # code...
        return $this->hasMany(FrameStock::class, 'color_id', 'id');
    }

    public function frame_purchase()
    {
        # code...
        return $this->hasMany(FramePurchase::class, 'color_id', 'id');
    }
}
