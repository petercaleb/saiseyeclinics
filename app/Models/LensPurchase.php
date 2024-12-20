<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'lens_id',
        'vendor_id',
        'receipt_number',
        'receipt',
        'purchased_date',
        'quantity',
        'price',
        'total_price',
        'received_date',
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

    public function lens()
    {
        # code...
        return $this->belongsTo(Lens::class, 'lens_id', 'id');
    }

    public function vendor()
    {
        # code...
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
}
