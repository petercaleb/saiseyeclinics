<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'order_id',
        'lens_id',
        'payment_bill_id',
        'quantity',
        'eye'
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function lens()
    {
        # code...
        return $this->belongsTo(Lens::class, 'lens_id', 'id');
    }

    public function payment_bill()
    {
        # code...
        return $this->belongsTo(PaymentBill::class, 'payment_bill_id', 'id');
    }
}
