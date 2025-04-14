<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'banking_id',
        'remmittance_id',
        'paybill_id',
        'amount',
        'paid',
        'balance',
        'change'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function banking()
    {
        return $this->belongsTo(Banking::class);
    }

    public function remmittance()
    {
        return $this->belongsTo(Remmittance::class, 'remmittance_id');
    }

    public function paymentBill() 
    {
        return $this->belongsTo(PaymentBill::class, 'paybill_id');
    }
}
