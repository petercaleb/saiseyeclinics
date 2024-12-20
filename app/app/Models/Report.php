<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'appointment_id',
        'payment_details_id',
        'schedule_id',
        'diagnosis_id',
        'treatment_id',
        'power_id',
        'lens_prescription_id',
        'frame_prescription_id',
        'bill_id',
        'order_id',
        'appointment_date',
        'bill_status',
        'consultation_fee',
        'claimed_amount',
        'agreed_amount',
        'total_amount',
        'paid_amount',
        'balance',
        'order_status',
        'report_status',
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

    public function appointment()
    {
        # code...
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function payment_detail()
    {
        # code...
        return $this->belongsTo(PaymentDetail::class, 'payment_details_id', 'id');
    }

    public function doctor_schedule()
    {
        # code...
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id', 'id');
    }

    public function diagnosis()
    {
        # code...
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function lens_power()
    {
        # code...
        return $this->belongsTo(LensPower::class, 'power_id', 'id');
    }

    public function lens_prescription()
    {
        # code...
        return $this->belongsTo(LensPrescription::class, 'lens_prescription_id', 'id');
    }

    public function frame_prescription()
    {
        # code...
        return $this->belongsTo(FramePrescription::class, 'frame_prescription_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->belongsTo(PaymentBill::class, 'bill_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
