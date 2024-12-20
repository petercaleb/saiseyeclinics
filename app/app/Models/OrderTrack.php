<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'workshop_id',
        'track_date',
        'track_status',
        'tat',
    ];

    public function order()
    {
        # code...
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function workshop()
    {
        # code...
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }
}
