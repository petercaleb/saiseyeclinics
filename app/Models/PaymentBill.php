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
        'lpo_number',
        'approval_number',
        'approval_status',
        'bill_status',
        'close_date',
        'claimed_amount',
        'agreed_amount',
        'total_amount',
        'paid_amount',
        'balance',
        'remittance_amount',
        'remittance_balance',
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

    public function order()
    {
        # code...
        return $this->hasOne(Order::class, 'payment_bill_id', 'id');
    }

    public function remittance()
    {
        # code...
        return $this->hasOne(Remittance::class, 'bill_id', 'id');
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
