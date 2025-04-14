<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedFrame extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'from_clinic_id',
        'to_clinic_id',
        'stock_id',
        'transfer_id',
        'transfer_user_id',
        'received_user_id',
        'received_date',
        'frame_code',
        'quantity',
        'received_status',
        'condition',
        'remarks',
    ];

    protected $dates = ['deleted_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function from_clinic()
    {
        return $this->belongsTo(Clinic::class, 'from_clinic_id', 'id');
    }

    public function to_clinic()
    {
        return $this->belongsTo(Clinic::class, 'to_clinic_id', 'id');
    }

    public function frame_stock()
    {
        return $this->belongsTo(FrameStock::class, 'stock_id', 'id');
    }

    public function frame_transfer()
    {
        return $this->belongsTo(FrameTransfer::class, 'transfer_id', 'id');
    }

    public function transfer_user()
    {
        return $this->belongsTo(User::class, 'transfer_user_id', 'id');
    }

    public function received_user()
    {
        return $this->belongsTo(User::class, 'received_user_id', 'id');
    }
}
