<?php

namespace App\Http\Controllers\Admin\Payments;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\Clinic;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentDetailsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'patient_id' => 'required|integer|exists:patients,id',
            'appointment_id' => 'required|integer|exists:appointments,id',
            'client_type_id' => 'required|integer|exists:client_types,id',
            'insurance_id' => 'nullable|integer|exists:insurances,id',
            'scheme' => 'nullable|string|max:255',
            'principal' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'nhif_number' => 'nullable|string|max:255',
            'nhif_principal_member' => 'nullable|string|max:255',
            'nhif_principal_member_phone' => 'nullable|string|max:255',
            'principal_workplace' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:255',
            'hospital_client_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            # code...
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);
        $patient = $clinic->patient->find($data['patient_id']);
        $appointment = $patient->appointment->find($data['appointment_id']);
        $client_type = ClientType::findOrFail($data['client_type_id']);
        $payment_details = new PaymentDetail();

        $payment_details->clinic_id = $clinic->id;
        $payment_details->patient_id = $patient->id;
        $payment_details->appointment_id = $appointment->id;
        $payment_details->client_type_id = $client_type->id;
        if($request->insurance_id) {
            $payment_details->insurance_id = $data['insurance_id'];
        }
        $payment_details->scheme = $data['scheme'];
        $payment_details->principal = $data['principal'];
        $payment_details->phone = $data['phone'];
        $payment_details->workplace = $data['workplace'];
        $payment_details->principal_workplace = $data['principal_workplace'];
        $payment_details->card_number = $data['card_number'];

        $payment_details->save();

        $response['status'] = true;
        $response['message'] = 'Payment details created successfully';
        return response()->json($response, 200);
    }
}
