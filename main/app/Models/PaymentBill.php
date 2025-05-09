<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clinic_id',
        'patient_id',
        'appointment_id',
        'schedule_id',
        'payment_details_id',
        'open_date',
        'consultation_fee',
        'consultation_receipt_number',
        'invoice_number',
        'kra_number',
        'approval_number',
        'approval_status',
        'bill_status',
        'close_date',
        'frame_amount',
        'lens_amount',
        'agreed_amount',
        'total_amount',
        'paid_amount',
        'balance',
        'document_status',
        'remmittance_status',
        'send_date',
        'received_date',
        'remarks',
        'terms',
    ];

    public function user()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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

    public function appontment()
    {
        # code...
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function doctor_schedule()
    {
        # code...
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id', 'id');
    }

    public function payment_detail()
    {
        # code...
        return $this->belongsTo(PaymentDetail::class, 'payment_details_id', 'id');
    }

    public function billing()
    {
        # code...
        return $this->hasMany(Billing::class, 'payment_bill_id', 'id');
    }

    public function remmittance()
    {
        return $this->hasOne(Remmittance::class, 'payment_bill_id');
    }

    public function order()
    {
        # code...
        return $this->hasOne(Order::class, 'payment_bill_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'bill_id', 'id');
    }

    public function workshop_sale()
    {
        # code...
        return $this->hasMany(WorkshopSale::class, 'payment_bill_id', 'id');
    }

    public function payment_attachment()
    {
        return $this->hasMany(PaymentAttachment::class, 'bill_id', 'id');
    }
}
