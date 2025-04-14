<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqCaseTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'to_clinic_id',
        'to_workshop_id',
        'stock_id',
        'case_id',
        'transfer_date',
        'quantity',
        'transfer_status',
        'condition',
        'received_status',
        'remarks',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function to_clinic()
    {
        return $this->belongsTo(Clinic::class, 'to_clinic_id', 'id');
    }

    public function to_workshop()
    {
        return $this->belongsTo(Workshop::class, 'to_workshop_id', 'id');
    }

    public function hq_stock()
    {
        return $this->belongsTo(HqCaseStock::class, 'stock_id', 'id');
    }

    public function frame_case()
    {
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }
}
