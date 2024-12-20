<?php

namespace App\Http\Controllers\Users\Treatment;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TreatmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id)
    {
        # code...
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $diagnosis = Diagnosis::findOrFail($id);
        $appointment = $diagnosis->appointment;
        $payment_details = $appointment->payment_detail;
        $lens_power = $diagnosis->lens_power;
        if($lens_power){
            $lens_prescription = $lens_power->lens_prescription;
            $frame_prescription = $lens_power->frame_prescription;
        }
        else{
            $lens_prescription = null;
            $frame_prescription = null;
        }
        $organization = $clinic->organization;
        $types = $organization->lens_type->sortBy('created_at', SORT_DESC);
        $materials = $organization->lens_material->sortBy('created_at', SORT_DESC);
        $workshops = $organization->workshop->sortBy('created_at', SORT_DESC);
        $procedure = $diagnosis->procedure;
        $payment_bill = $appointment->payment_bill;
        $page_title = 'Treatment';
        return view('users.treatment.create', [
            'clinic' => $clinic,
            'diagnosis' => $diagnosis,
            'appointment' => $appointment,
            'payment_details' => $payment_details,
            'lens_power' => $lens_power,
            'lens_prescription' => $lens_prescription,
            'frame_prescription' => $frame_prescription,
            'types' => $types,
            'materials' => $materials,
            'workshops' => $workshops,
            'procedure' => $procedure,
            'payment_bill' => $payment_bill,
            'page_title' => $page_title,
        ]);
    }
}
