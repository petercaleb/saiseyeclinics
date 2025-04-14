<?php

namespace App\Http\Controllers\Users\Patients;

use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Insurance;
use App\Models\ClientType;
use App\Models\Appointment;
use App\Models\PaymentDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Patients\StoreSelfRegistrationRequest;

class SelfRegistrationController extends Controller
{
    //
    public function register(Clinic $clinic)
    {
        $page_title = "Patient Registration";
        $client_types = ClientType::latest()->get();
        $insurances = Insurance::latest()->get();
        return view('users.patients.register', [
            'clinic' => $clinic,
            'page_title' => $page_title,
            'client_types' => $client_types,
            'insurances' => $insurances
        ]);
    }

    public function store(StoreSelfRegistrationRequest $request, Clinic $clinic)
    {
        $data = $request->all();

        $patient = new Patient;

        $patient->clinic_id = $clinic->id;
        $patient->first_name = $data['first_name'];
        $patient->last_name = $data['last_name'];
        $patient->id_number = $data['id_number'];
        $patient->phone = $data['phone'];
        $patient->email = $data['email'];
        $patient->dob = $data['dob'];
        $patient->gender = $data['gender'];
        $patient->address = $data['address'];
        $patient->next_of_kin = $data['next_of_kin'];
        $patient->next_of_kin_contact = $data['next_of_kin_contact'];
        $patient->date_in = Carbon::now()->format('Y-m-d');

        if ($patient->save()) {

            $client_type = ClientType::findOrFail($data['client_type_id']);

            $appointment = new Appointment();
            $appointment->clinic_id = $clinic->id;
            $appointment->patient_id = $patient->id;
            $appointment->date = Carbon::now()->format('Y-m-d');
            $appointment->appointment_time = Carbon::now()->format('H:i:s');
            $appointment->status = 1;

            if ($appointment->save()) {
                // create payment detail
                $payment_detail = new PaymentDetail;
                $payment_detail->clinic_id = $clinic->id;
                $payment_detail->patient_id = $patient->id;
                $payment_detail->appointment_id = $appointment->id;
                $payment_detail->client_type_id = $client_type->id;
                if ($request->insurance_id) {
                    $payment_detail->insurance_id = $data['insurance_id'];
                }
                $payment_detail->scheme = $data['scheme'];
                $payment_detail->principal = $data['principal'];
                $payment_detail->phone = $data['principal_phone'];
                $payment_detail->workplace = $data['workplace'];
                $payment_detail->principal_workplace = $data['workplace'];
                $payment_detail->card_number = $data['card_number'];

                if ($payment_detail->save()) {
                    $response['status'] = true;
                    $response['message'] = 'Patient created successfully';
                    return response()->json($response, 200);
                }
            }
        }
    }

    public function findClientTypeById($id)
    {
        $clientType = ClientType::findOrFail($id);
        return $clientType;
    }
}
