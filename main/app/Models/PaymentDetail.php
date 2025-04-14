<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'appointment_id',
        'client_type_id',
        'insurance_id',
        'scheme',
        'principal',
        'phone',
        'workplace',
        'principal_workplace',
        'card_number',
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

    public function client_type()
    {
        # code...
        return $this->belongsTo(ClientType::class, 'client_type_id', 'id');
    }

    public function insurance()
    {
        # code...
        return $this->belongsTo(Insurance::class, 'insurance_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->hasOne(PaymentBill::class, 'payment_detail_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'payment_details_id', 'id');
    }
}
