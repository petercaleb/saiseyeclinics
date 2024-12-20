<?php

namespace App\Http\Controllers\Users\Lens;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Lens\SubmitLensPowerRequest;
use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Models\Diagnosis;
use App\Models\LensPower;
use App\Models\Treatment;
use Illuminate\Support\Facades\Validator;

class LensPowerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(SubmitLensPowerRequest $request)
    {
        # code...
        $data = $request->except("_token");

        $diagnosis = Diagnosis::findOrFail($data['diagnosis_id']);

        $lens_power = $diagnosis->lens_power()->create([
            'patient_id' => $diagnosis->patient_id,
            'appointment_id' => $diagnosis->appointment_id,
            'schedule_id' => $diagnosis->schedule_id,
            'diagnoisis_id' => $diagnosis->id,
            'right_sphere' => $data['right_sphere'],
            'right_cylinder' => $data['right_cylinder'],
            'right_axis' => $data['right_axis'],
            'right_add' => $data['right_add'],
            'left_sphere' => $data['left_sphere'],
            'left_cylinder' => $data['left_cylinder'],
            'left_axis' => $data['left_axis'],
            'left_add' => $data['left_add'],
            'notes' => $data['notes'],
        ]);


        // update treament 
        $treatment = Treatment::findOrFail($data['treatment_id']);

        $treatment->update([
            'power_id' => $lens_power->id,
            'status' => 'lens power'
        ]);

        $clinic = $diagnosis->clinic;

        $report_id = $diagnosis->appointment->report_id;

        $report = $clinic->report()->findOrFail($report_id);

        $report->update([
            'power_id' => $lens_power->id,
        ]);

        $response['status'] = true;
        $response['power_id'] = $diagnosis->lens_power->id;
        $response['message'] = 'You have success created lens power for a patient';

        return response()->json($response, 200);
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'power_id' => 'required|integer|exists:lens_powers,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $power = LensPower::findOrFail($data['power_id']);
        $response['status'] = true;
        $response['data'] = $power;
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'power_id' => 'required|integer|exists:lens_powers,id',
            'right_sphere' => 'required|string|max:255',
            'right_cylinder' => 'required|string|max:255',
            'right_axis' => 'required|string|max:255',
            'right_add' => 'required|string|max:255',
            'left_sphere' => 'required|string|max:255',
            'left_cylinder' => 'required|string|max:255',
            'left_axis' => 'required|string|max:255',
            'left_add' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $power = LensPower::findOrFail($data['power_id']);

        $power->update([
            'id' => $power->id,
            'patient_id' => $power->patient_id,
            'appointment_id' => $power->appointment_id,
            'schedule_id' => $power->schedule_id,
            'diagnoisis_id' => $power->diagnoisis_id,
            'right_sphere' => $data['right_sphere'],
            'right_cylinder' => $data['right_cylinder'],
            'right_axis' => $data['right_axis'],
            'right_add' => $data['right_add'],
            'left_sphere' => $data['left_sphere'],
            'left_cylinder' => $data['left_cylinder'],
            'left_axis' => $data['left_axis'],
            'left_add' => $data['left_add'],
            'notes' => $data['notes'],
        ]);

        $response['status'] = true;
        $response['power_id'] = $power->id;
        $response['message'] = 'You have success updated lens power for a patient before order';
        return response()->json($response, 200);
    }
}
