<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrameCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'color_id',
        'size_id',
        'shape_id',
        'code'
    ];

    protected $dates = ['deleted_at'];


    public function organization()  
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function case_color()  
    {
        return $this->belongsTo(CaseColor::class, 'color_id', 'id');    
    }

    public function case_size()  
    {
        return $this->belongsTo(CaseSize::class, 'size_id', 'id');    
    }

    public function case_shape()  
    {
        return $this->belongsTo(CaseShape::class, 'shape_id', 'id');    
    }
}
