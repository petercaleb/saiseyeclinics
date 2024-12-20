<?php

namespace App\Http\Controllers\Admin\Lens;

use App\Http\Controllers\Controller;
use App\Models\LensPrescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LensPrescriptionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'prescription_id' => 'required|integer|exists:lens_prescriptions,id',
        ]);

        if($validator->fails()){
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
}
