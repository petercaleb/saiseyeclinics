<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id', // New (Docotor who worked on the order)
        'patient_id',
        'appointment_id',
        'schedule_id',
        'payment_bill_id',
        'workshop_id',
        'technician_id', // New (Technician who worked on this order)
        'lens_power_id',
        'lens_prescription_id',
        'frame_prescription_id',
        'order_date',
        'receipt_number',
        'right_eye_lens_id', // New will nullable (Right eye lens used on this order)
        'left_eye_lens_id', // New (Left eye lens used on this order)
        'quantity', // New, Amount of lenses used on this order
        'status',
        'closed_date',
        'tat_one', // New Time difference Frame sent to workshop and Received From workshop
        'tat_two' // New Time difference Order Received from workshop and patient collection
    ];


    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }


    public function user() 
    {
        # code...
        // doctor
        return $this->belongsTo(User::class, 'user_id');
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

    public function payment_bill()
    {
        # code...
        return $this->belongsTo(PaymentBill::class, 'payment_bill_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function technician()  
    {
        # code...
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    public function right_eye_lens()  
    {
        return $this->belongsTo(Lens::class, 'right_eye_lens_id', 'id');
    }

    function left_eye_lens()  
    {
        return $this->belongsTo(Lens::class, 'left_eye_lens_id', 'id');    
    }

    public function lens_power()
    {
        # code...
        return $this->belongsTo(LensPower::class, 'lens_power_id', 'id');
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

    public function order_track()
    {
        # code...
        return $this->hasMany(OrderTrack::class, 'order_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'order_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->hasOne(Treatment::class, 'order_id', 'id');
    }

    public function workshop_sale()
    {
        # code...
        return $this->hasMany(WorkshopSale::class, 'order_id', 'id');
    }
}
