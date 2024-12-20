<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'technician_id',
        'hq_case_stock_id',
        'case_id',
        'case_code',
        'request_date',
        'quantity',
        'remarks',
        'status',
        'transfer_status'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    public function hqCaseStock()
    {
        return $this->belongsTo(HqCaseStock::class, 'hq_case_stock_id', 'id');
    }

    public function frameCase()
    {
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }
}
