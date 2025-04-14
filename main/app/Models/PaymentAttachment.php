<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_id',
        'title',
        'slug',
        'file'
    ];

    public function user()  
    {
        return $this->belongsTo(User::class, 'user_id', 'id');    
    }

    public function payment_bill()  
    {
        return $this->belongsTo(PaymentBill::class, 'bill_id', 'id');    
    }
}
