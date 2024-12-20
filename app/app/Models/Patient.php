<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'clinic_id',
        'user_id', // Added by user
        'first_name',
        'last_name',
        'id_number',
        'phone',
        'email',
        'dob',
        'gender',
        'address',
        'next_of_kin',
        'next_of_kin_contact',
        'date_in',
        'status',
        'card_number'
    ];

    protected $dates = ['deleted_at'];


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

    public function appointment()
    {
        # code...
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }

    public function payment_detail()
    {
        # code...
        return $this->hasMany(PaymentDetail::class, 'patient_id', 'id');
    }

    public function docor_schedule()
    {
        # code...
        return $this->hasMany(DoctorSchedule::class, 'patient_id', 'id');
    }

    public function diagnosis()
    {
        # code...
        return $this->hasMany(Diagnosis::class, 'patient_id', 'id');
    }

    public function lens_power()
    {
        # code...
        return $this->hasMany(LensPower::class, 'patient_id', 'id');
    }

    public function medicine()
    {
        # code...
        return $this->hasMany(Medicine::class, 'patient_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->hasMany(PaymentBill::class, 'patient_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasMany(Order::class, 'patient_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'patient_id', 'id');
    }
}
