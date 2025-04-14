<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'size',
        'slug',
        'description',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function frame()
    {
        # code...
        return $this->hasMany(Frame::class, 'size_id', 'id');
    }
}
