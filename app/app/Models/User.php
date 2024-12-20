<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'clinic_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'status',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function patient()
    {
        # code...
        return $this->hasMany(Patient::class, 'user_id', 'id');
    }

    public function doctor_schedule()
    {
        # code...
        return $this->hasMany(DoctorSchedule::class, 'user_id', 'id');
    }

    public function diagnosis()
    {
        # code...
        return $this->hasMany(Diagnosis::class, 'user_id', 'id');
    }

    public function order_track()
    {
        # code...
        return $this->hasMany(OrderTrack::class, 'user_id', 'id');
    }

    public function payment_bill()  
    {
        return $this->hasMany(PaymentBill::class, 'user_id', 'id');    
    }

    public function payment_attachment()  
    {
        return $this->hasMany(PaymentAttachment::class, 'user_id', 'id');  
    }
}
