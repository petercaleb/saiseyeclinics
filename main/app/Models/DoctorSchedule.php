<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id',
        'patient_id',
        'appointment_id',
        'day',
        'date',
        'time',
        'status',
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

    public function diagnosis()
    {
        # code...
        return $this->hasOne(Diagnosis::class, 'schedule_id', 'id');
    }

    public function lens_power()
    {
        # code...
        return $this->hasOne(LensPower::class, 'schedule_id', 'id');
    }

    public function medicine()
    {
        # code...
        return $this->hasMany(Medicine::class, 'schedule_id', 'id');
    }

    public function procedure()
    {
        # code...
        return $this->hasMany(Procedure::class, 'schedule_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->hasOne(PaymentBill::class, 'schedule_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasOne(Order::class, 'schedule_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'schedule_id', 'id');
    }
}
