<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCaseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'workshop_id',
        'hq_stock_id',
        'case_id',
        'code',
        'opening',
        'received',
        'transfered',
        'total',
        'sold',
        'closing',
        'price',
        'remarks'
    ];


    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function hqStock()
    {
        return $this->belongsTo(HqCaseStock::class, 'hq_stock_id', 'id');
    }

    public function case()
    {
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }
}
