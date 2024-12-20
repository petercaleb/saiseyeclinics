<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'schedule_id',
        'diagnosis_id',
        'medicine',
        'dose',
    ];

    public function patient()
    {
        # code...
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

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
