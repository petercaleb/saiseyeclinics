<?php

namespace App\Http\Controllers\Users\Lens;

use App\Http\Controllers\Controller;
use App\Models\LensPower;
use App\Models\LensPower1;
use App\Models\LensPrescription;
use App\Models\Treatment;
use App\Models\Treatment1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LensPrescriptionController extends Controller
{
    private $response = [];

    public function __construct()
    {
        $this->middleware('auth');
    }


    private function validateRequest($data, $table)
    {
        $validator = Validator::make($data, [
            'power_id' => 'required|integer|exists:' . $table . ',id',
            'type_id' => 'required|integer|exists:lens_types,id',
            'material_id' => 'required|integer|exists:lens_materials,id',
            'index' => 'required|string|max:255',
            'tint' => 'nullable|string|max:255',
            'pupil' => 'nullable|string|max:255',
            'focal_height' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            array_push($this->response, $response);
            return false;
        }
        return true;
    }

    public function displayError()
    {
        foreach ($this->response as $response) {
            return response()->json($response, 401);
        }
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();
        if (isset($data['form_type'])) {
            $formtype = $data['form_type'];
            $tint = $data['tint'] ?? 'null';
            // Handle treatment 2 logic
            if ($formtype === "Treatment 2") {
                if (!$this->validateRequest($data, 'lens_powers_1')) {
                    return $this->displayError();
                }
                $lens_power_1 = LensPower1::findOrFail($data['power_id']);

                $lens_prescription_1 = $lens_power_1->lens_prescription_1()->create([
                    'type_id' => $data['type_id'],
                    'material_id' => $data['material_id'],
                    'index' => $data['index'],
                    'tint' => $tint,
                    'diameter' => $data['pupil'],
                    'focal_height' => $data['focal_height'],
                ]);
                $treatment = Treatment1::findOrFail($lens_power_1->treatment_1->id);

                $treatment->update([
                    'lens_prescription_id' => $lens_prescription_1->id,
                    'status' => 'lens prescription'
                ]);
                $response['status'] = true;
                $response['power_id'] = $lens_power_1->id;
                $response['prescription_id'] = $lens_power_1->lens_prescription_1->id;
                $response['message'] = 'You have successfully created prescription 2 for a lens power 2';
                return response()->json($response, 200);
            } else {
                //Handle treatment 1 logic
                if (!$this->validateRequest($data, 'lens_powers')) {
                    return $this->displayError();
                }
                $lens_power = LensPower::findOrFail($data['power_id']);
                $tint = $data['tint'] ?? 'null';

                $lens_prescription = $lens_power->lens_prescription()->create([
                    'type_id' => $data['type_id'],
                    'material_id' => $data['material_id'],
                    'index' => $data['index'],
                    'tint' => $tint,
                    'diameter' => $data['pupil'],
                    'focal_height' => $data['focal_height'],
                ]);

                $treatment = Treatment::findOrFail($lens_power->treatment->id);

                $treatment->update([
                    'lens_prescription_id' => $lens_prescription->id,
                    'status' => 'lens prescription'
                ]);

                $clinic = $lens_power->diagnosis->clinic;

                $report_id = $lens_power->appointment->report_id;

                $report = $clinic->report()->findOrFail($report_id);

                $report->update([
                    'lens_prescription_id' => $lens_prescription->id,
                ]);

                $response['status'] = true;
                $response['power_id'] = $lens_power->id;
                $response['prescription_id'] = $lens_power->lens_prescription->id;
                $response['message'] = 'You have successfully created prescription for a lens power';
                return response()->json($response, 200);
            }
        }
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'prescription_id' => 'required|integer|exists:lens_prescriptions,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens_prescription = LensPrescription::findOrFail($data['prescription_id']);

        $response['status'] = true;
        $response['data'] = $lens_prescription;

        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'prescription_id' => 'required|integer|exists:lens_prescriptions,id',
            'type_id' => 'required|integer|exists:lens_types,id',
            'material_id' => 'required|integer|exists:lens_materials,id',
            'index' => 'required|string|max:255',
            'tint' => 'nullable|string|max:255',
            'pupil' => 'nullable|string|max:255',
            'focal_height' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens_prescription = LensPrescription::findOrFail($data['prescription_id']);

        $lens_prescription->update([
            'id' => $lens_prescription->id,
            'power_id' => $lens_prescription->power_id,
            'type_id' => $data['type_id'],
            'material_id' => $data['material_id'],
            'index' => $data['index'],
            'tint' => $data['tint'],
            'diameter' => $data['pupil'],
            'focal_height' => $data['focal_height']
        ]);



        $response['status'] = true;
        $response['power_id'] = $lens_prescription->power_id;
        $response['prescription_id'] = $lens_prescription->id;
        $response['message'] = 'You have successfully updated lens prescription';
        return response()->json($response, 200);
    }
}
