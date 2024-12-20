<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensPower extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'schedule_id',
        'diagnoisis_id',
        'right_sphere',
        'right_cylinder',
        'right_axis',
        'right_add',
        'left_sphere',
        'left_cylinder',
        'left_axis',
        'left_add',
        'notes',
    ];

    public function patient()
    {
        # code...
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function appointment()
    {
        # code...
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function doctor_schedule()
    {
        # code...
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id', 'id');
    }

    public function diagnosis()
    {
        # code...
        return $this->belongsTo(Diagnosis::class, 'diagnoisis_id', 'id');
    }

    public function lens_prescription()
    {
        # code...
        return $this->hasOne(LensPrescription::class, 'power_id', 'id');
    }

    public function frame_prescription()
    {
        # code...
        return $this->hasOne(FramePrescription::class, 'power_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasOne(Order::class, 'lens_power_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'power_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->hasOne(Treatment::class, 'power_id', 'id');
    }
}

