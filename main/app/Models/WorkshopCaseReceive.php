<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCaseReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'from_workshop_id',
        'hq_case_stock_id',
        'technician_id',
        'case_id',
        'case_code',
        'receive_date',
        'quantity',
        'received_status',
        'is_hq',
        'condition',
        'remarks',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function fromWorkshop()
    {
        return $this->belongsTo(Workshop::class, 'from_workshop_id', 'id');
    }

    public function hqCaseStock()
    {
        return $this->belongsTo(HqCaseStock::class, 'hq_case_stock_id', 'id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'id');
    }

    public function frame_case()
    {
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }
}
