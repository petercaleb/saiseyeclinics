<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FramePrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'power_id',
        'prescription_id',
        'stock_id',
        'case_stock_id', // new field
        'frame_code',
        'case_code', // new field
        'receipt_number',
        'workshop_id',
        'quantity',
        'remarks',
    ];

    public function lens_power()
    {
        # code...
        return $this->belongsTo(LensPower::class, 'power_id', 'id');
    }

    public function lens_prescription()
    {
        # code...
        return $this->belongsTo(LensPrescription::class, 'prescription_id', 'id');
    }

    public function frame_stock()
    {
        # code...
        return $this->belongsTo(FrameStock::class, 'stock_id', 'id');
    }

    public function case_stock()
    {
        # code...
        return $this->belongsTo(CaseStock::class, 'case_stock_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'frame_prescription_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->hasOne(Treatment::class, 'frame_prescription_id', 'id');
    }
}
