<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id',
        'patient_id',
        'appointment_id',
        'schedule_id',
        'signs',
        'symptoms',
        'diagnosis',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function user()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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

    public function lens_power()
    {
        # code...
        return $this->hasOne(LensPower::class, 'diagnoisis_id', 'id');
    }

    public function medicine()
    {
        # code...
        return $this->hasMany(Medicine::class, 'diagnosis_id', 'id');
    }

    public function procedure()
    {
        # code...
        return $this->hasOne(Procedure::class, 'diagnosis_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'diagnosis_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->hasOne(Treatment::class, 'diagnosis_id', 'id');
    }
}
