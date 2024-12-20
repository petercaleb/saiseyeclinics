<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'phone',
        'email',
        'address',
        'description',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function payment_detail()
    {
        # code...
        return $this->hasMany(PaymentDetail::class, 'insurance_id', 'id');
    }
}
