<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'date',
        'appointment_time',
        'hq_approval_request_status',
        'hq_approval_code',
        'user_id',
        'status',
        'report_id',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function patient()
    {
        # code...
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function payment_detail()
    {
        # code...
        return $this->hasOne(PaymentDetail::class, 'appointment_id', 'id');
    }

    public function doctor_schedule()
    {
        # code...
        return $this->hasOne(DoctorSchedule::class, 'appointment_id', 'id');
    }

    public function appointment()
    {
        # code...
        return $this->hasOne(Appointment::class, 'patient_id', 'id');
    }

    public function lens_power()
    {
        # code...
        return $this->hasOne(LensPower::class, 'appointment_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->hasOne(PaymentBill::class, 'appointment_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasOne(Order::class, 'appointment_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'appointment_id', 'id');
    }

}
