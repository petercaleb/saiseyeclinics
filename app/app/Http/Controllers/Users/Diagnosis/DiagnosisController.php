<?php

namespace App\Http\Controllers\Users\Diagnosis;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Diagnosis;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'patient_id' => 'required|integer|exists:patients,id',
            'appointment_id' => 'required|integer|exists:appointments,id',
            'user_id' => 'required|integer|exists:users,id',
            'schedule_id' => 'required|integer|exists:doctor_schedules,id',
            'signs' => 'required|string',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);
        $patient = Patient::findOrFail($data['patient_id']);
        $appointment = Appointment::findOrFail($data['appointment_id']);
        $user = User::findOrFail($data['user_id']);
        $schedule = DoctorSchedule::findOrFail($data['schedule_id']);
        $diagnosis = new Diagnosis;
        $diagnosis->clinic_id = $clinic->id;
        $diagnosis->user_id = $user->id;
        $diagnosis->patient_id = $patient->id;
        $diagnosis->appointment_id = $appointment->id;
        $diagnosis->schedule_id = $schedule->id;
        $diagnosis->signs = $data['signs'];
        $diagnosis->symptoms = $data['symptoms'];
        $diagnosis->diagnosis = $data['diagnosis'];

        if ($diagnosis->save()) {

            // creae treatment 
            $treatment = new Treatment;

            $treatment->diagnosis_id = $diagnosis->id;
            $treatment->status = "diagnosis";

            if($treatment->save()){

                $report_id = $appointment->report_id;

                $report = $clinic->report()->findOrFail($report_id);

                $report->update([
                    'diagnosis_id' => $diagnosis->id,
                    'treatment_id' => $treatment->id
                ]);

                $response['status'] = true;
                $response['message'] = 'Diagnosis created successfully';
                return response()->json($response, 200);
            }    
           
        }
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'diagnosis_id' => 'required|integer|exists:diagnoses,id'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $diagnosis = Diagnosis::findOrFail($data['diagnosis_id']);

        $response['status'] = true;
        $response['data'] = $diagnosis;
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'diagnosis_id' => 'required|integer|exists:diagnoses,id',
            'signs' => 'required|string',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $diagnosis = $clinic->diagnosis()->findOrFail($data['diagnosis_id']);

        $diagnosis->id = $diagnosis->id;
        $diagnosis->clinic_id = $diagnosis->clinic_id;
        $diagnosis->user_id = $diagnosis->user_id;
        $diagnosis->patient_id = $diagnosis->patient_id;
        $diagnosis->appointment_id = $diagnosis->appointment_id;
        $diagnosis->schedule_id = $diagnosis->schedule_id;
        $diagnosis->signs = $data['signs'];
        $diagnosis->symptoms = $data['symptoms'];
        $diagnosis->diagnosis = $data['diagnosis'];

        $diagnosis->save();

        $response['status'] = true;
        $response['message'] = 'Diagnosis updated successfully';
        return response()->json($response, 200);
    }
}
