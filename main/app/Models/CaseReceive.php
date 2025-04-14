<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'clinic_id',
        'from_clinic_id',
        'hq_case_stock_id',
        'user_id',
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

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function fromClinic()
    {
        return $this->belongsTo(Clinic::class, 'from_clinic_id', 'id');
    }

    public function hqCaseStock()
    {
        return $this->belongsTo(HqCaseStock::class, 'hq_case_stock_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function frame_case()
    {
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }
}
