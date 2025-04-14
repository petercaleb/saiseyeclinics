<?php

namespace App\Http\Controllers\Users\Procedure;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcedureController extends Controller
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
            'diagnosis_id' => 'required|integer|exists:diagnoses,id',
            'procedure' => 'required',
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $diagnosis = Diagnosis::findOrFail($data['diagnosis_id']);

        $diagnosis->procedure()->create([
            'schedule_id' => $diagnosis->doctor_schedule->id,
            'procedure' => $data['procedure'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Procedure added successfully';
        return response()->json($response, 200);
    }
}
