<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'diagnosis_id',
        'procedure',
    ];

    public function doctor_schedule()
    {
        # code...
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id', 'id');
    }

    public function diagnosis()
    {
        # code...
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'id');
    }
}
