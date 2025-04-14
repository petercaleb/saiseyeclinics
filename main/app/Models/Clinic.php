<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'clinic',
        'logo',
        'phone',
        'email',
        'address',
        'location',
        'initials',
        'etims_number',
        'self_registration_link',
        'qr_code_path'
    ];

    protected $dates = ['deleted_at'];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function user()
    {
        # code...
        return $this->hasMany(User::class, 'clinic_id', 'id');
    }

    public function patient()
    {
        # code...
        return $this->hasMany(Patient::class, 'clinic_id', 'id');
    }

    function patients_per_clinic()
    {
        return $this->patient()->where('status', 1)->latest()->count();
    }

    public function appointment()
    {
        # code...
        return $this->hasMany(Appointment::class, 'clinic_id', 'id');
    }

    public function payment_detail()
    {
        # code...
        return $this->hasMany(PaymentDetail::class, 'clinic_id', 'id');
    }

    public function doctor_schedule()
    {
        # code...
        return $this->hasMany(DoctorSchedule::class, 'clinic_id', 'id');
    }

    public function diagnosis()
    {
        # code...
        return $this->hasMany(Diagnosis::class, 'clinic_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->hasMany(PaymentBill::class, 'clinic_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasMany(Order::class, 'clinic_id', 'id');
    }

    public function asset()
    {
        # code...
        return $this->hasMany(Asset::class, 'clinic_id', 'id');
    }

    public function from_asset_transfer()
    {
        # code...
        return $this->hasMany(AssetTransfer::class, 'from_clinic_id', 'id');
    }

    public function to_asset_transfer()
    {
        # code...
        return $this->hasMany(AssetTransfer::class, 'to_clinic_id', 'id');
    }

    public function frame()
    {
        # code...
        return $this->hasMany(Frame::class, 'clinic_id', 'id');
    }

    public function frame_stock()
    {
        # code...
        return $this->hasMany(FrameStock::class, 'clinic_id', 'id');
    }

    public function sun_glass()
    {
        # code...
        return $this->hasMany(SunGlass::class, 'clinic_id', 'id');
    }

    public function contact_len()
    {
        # code...
        return $this->hasMany(ContactLen::class, 'clinic_id', 'id');
    }

    public function sun_glass_stock()
    {
        # code...
        return $this->hasMany(SunGlassStock::class, 'clinic_id', 'id');
    }

    public function report()
    {
        # code...
        return $this->hasMany(Report::class, 'clinic_id', 'id');
    }

    public function frame_purchase()
    {
        # code...
        return $this->hasMany(FramePurchase::class, 'clinic_id', 'id');
    }



    public function frame_transfer_from()
    {
        # code...
        return $this->hasMany(FrameTransfer::class, 'from_clinic_id', 'id');
    }

    public function frame_transfer_to()
    {
        # code...
        return $this->hasMany(FrameTransfer::class, 'to_clinic_id', 'id');
    }

    public function frame_received_from()
    {
        return $this->hasMany(ReceivedFrame::class, 'from_clinic_id', 'id');
    }

    public function frame_received_to()
    {
        return $this->hasMany(ReceivedFrame::class, 'to_clinic_id', 'id');
    }

    public function clinic_frame_case_stock()
    {
        return $this->hasMany(ClinicFrameCaseStock::class, 'clinic_id', 'id');
    }

    public function to_hq_case_transfer()
    {
        return $this->hasMany(HqCaseTransfer::class, 'to_clinic_id', 'id');
    }

    public function frame_received()
    {
        return $this->hasMany(FrameReceived::class, 'clinic_id', 'id');
    }

    public function from_frame_received()
    {
        return $this->hasMany(FrameReceived::class, 'from_clinic_id', 'id');
    }

    public function frame_request()
    {
        return $this->hasMany(FrameRequest::class, 'clinic_id', 'id');
    }

    public function hq_frame_transfer_to()  
    {
        return $this->hasMany(HqFrameTransfer::class, 'to_clinic_id', 'id');   
    } 

    public function case_stock()
    {
        return $this->hasMany(CaseStock::class, 'clinic_id', 'id');
    }

    public function case_receive()
    {
        return $this->hasMany(CaseReceive::class, 'clinic_id', 'id');
    }

    public function from_case_receive()
    {
        return $this->hasMany(CaseReceive::class, 'from_clinic_id', 'id');
    }

    public function case_request()
    {
        return $this->hasMany(CaseRequest::class, 'clinic_id', 'id');
    }
}
