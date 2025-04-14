<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_bill_id',
        'item',
        'amount',
        'receipt_number',
        'date',
    ];

    public function paymentBill()
    {
        return $this->belongsTo(PaymentBill::class, 'payment_bill_id', 'id');
    }
}
