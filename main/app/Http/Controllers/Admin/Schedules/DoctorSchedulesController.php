<?php

namespace App\Http\Controllers\Admin\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorSchedule as ResourcesDoctorSchedule;
use App\Models\Clinic;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorSchedulesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            $data = $clinic->doctor_schedule()
                ->join('patients', 'patients.id', '=', 'doctor_schedules.patient_id')
                ->join('users', 'users.id', '=', 'doctor_schedules.user_id')
                ->select('doctor_schedules.*', 'users.first_name as dr_first', 'users.last_name as dr_last', 'patients.first_name  as patient_first', 'patients.last_name as patient_last')
                ->where('patients.status', 1)
                ->latest()
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('patient_name', function ($row) {
                    return $row->patient_first . ' ' . $row->patient_last;
                })
                ->addColumn('dr_name', function ($row) {
                    return $row->dr_first . ' ' . $row->dr_last;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="btn btn-tool btn-sm viewDoctorSchedule"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'patient_name', 'dr_name'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $page_title = trans('pages.schedule');
        return view('admin.schedules.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'patients' => $patients,
        ]);
    }

    public function show($schedule_id)
    {
        # code...
        $schedule = DoctorSchedule::findOrFail($schedule_id);
        return new ResourcesDoctorSchedule($schedule);
    }

    public function view($id, $schedule_id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $schedule = $clinic->doctor_schedule()->findOrFail($schedule_id);
        $patient = $schedule->patient;
        $doctor = $schedule->user; // This users with the roles of doctor or optimist
        $appointment = $schedule->appointment;
        $payment_details = $appointment->payment_detail;
        $diagnosis = $schedule->diagnosis;
        if ($diagnosis) {
            $lens_power = $diagnosis->lens_power;
            if ($lens_power) {
                $lens_prescription = $lens_power->lens_prescription;
                $frame_prescription = $lens_power->frame_prescription;
            } else {
                $lens_prescription = null;
                $frame_prescription = null;
            }
            $procedure = $diagnosis->procedure;
            $appointment = $diagnosis->appointment;
            $payment_bill = $appointment->payment_bill;
        } else {
            $lens_power = null;
            $lens_prescription = null;
            $frame_prescription = null;
            $procedure = null;
            $appointment = null;
            $payment_bill = null;
        }
        $page_title = trans('pages.schedule');

        return view('admin.schedules.view', [
            'page_title' => $page_title,
            'schedule' => $schedule,
            'clinic' => $clinic,
            'patient' => $patient,
            'doctor' => $doctor,
            'appointment' => $appointment,
            'payment_details' => $payment_details,
            'diagnosis' => $diagnosis,
            'lens_power' => $lens_power,
            'lens_prescription' => $lens_prescription,
            'frame_prescription' => $frame_prescription,
            'procedure' => $procedure,
            'payment_bill' => $payment_bill,
        ]);
    }
}
