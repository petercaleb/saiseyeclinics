<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'clinic_id',
        'user_id',
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

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
