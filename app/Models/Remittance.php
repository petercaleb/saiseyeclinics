<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'bill_id',
        'bill_invoice',
        'item',
        'amount',
        'paid',
        'balance',
        'remittance_date',
        'closed_date',
        'status',
    ];

    public function clinic()
    {
        # code...
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->belongsTo(PaymentBill::class, 'bill_id', 'id');
    }
}
