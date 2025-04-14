<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqLensPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'lens_id',
        'vendor_id',
        'receipt_number',
        'purchased_date',
        'quantity',
        'price',
        'total_price',
        'attachment',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function admin()
    {
        # code...
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function hq_lens()
    {
        # code...
        return $this->belongsTo(HqLens::class, 'lens_id', 'id');
    }

    public function vendor()
    {
        # code...
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

}
