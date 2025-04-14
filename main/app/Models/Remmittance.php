<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remmittance extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_bill_id',
        'date',
        'status'
    ];

    public function paymentBill()  
    {
        return $this->belongsTo(PaymentBill::class, 'payment_bill_id');    
    }

    public function receivedPayment() 
    {
        return $this->hasOne(ReceivedPayment::class, 'remmittance_id');    
    }
}
