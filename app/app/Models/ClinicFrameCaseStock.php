<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicFrameCaseStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'clinic_id',
        'frame_case_id',
        'code',
        'stock',
        'remarks'
    ];
}
