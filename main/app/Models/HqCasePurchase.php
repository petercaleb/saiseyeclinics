<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqCasePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'stock_id',
        'case_id',
        'receipt_number',
        'purchase_date',
        'quantity',
        'price',
        'total',
        'vendor_id',
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

    public function hq_case_stock()  
    {
        # code...
        return $this->belongsTo(HqCaseStock::class, 'stock_id', 'id');
    }

    public function frame_case()  
    {
        # code...
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }

    public function vendor()  
    {
        # code...
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
        
    }
}
