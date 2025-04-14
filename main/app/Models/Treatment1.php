<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment1 extends Model
{
    use HasFactory;

    protected $table = "treatments_1";

    protected $fillable = [
        'diagnosis_id',
        'power_id',
        'lens_prescription_id',
        'frame_prescription_id',
        'workshop_id',
        'order_id',
        'payments',
        'status'
    ];

    public function diagnosis()
    {
        # code...
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'id');
    }

    public function lens_power()
    {
        # code...
        return $this->belongsTo(LensPower::class, 'power_id', 'id');
    }

    public function lens_power_1()
    {
        # code...
        return $this->belongsTo(LensPower1::class, 'power_id', 'id');
    }

    public function lens_prescription()
    {
        # code...
        return $this->belongsTo(LensPrescription::class, 'lens_prescription_id', 'id');
    }

    public function lens_prescription_1()
    {
        # code...
        return $this->belongsTo(LensPrescription1::class, 'lens_prescription_id', 'id');
    }

    public function frame_prescription()
    {
        # code...
        return $this->belongsTo(FramePrescription::class, 'frame_prescription_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'treatment_id', 'id');
    }
}
