<?php

namespace App\Http\Controllers\Admin\Appointments;

use App\Exports\AppointmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment as ResourcesAppointment;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
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
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->appointment()
                    ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                    ->join('payment_details', 'appointments.id', '=', 'payment_details.appointment_id')
                    ->join('client_types', 'payment_details.client_type_id', '=', 'client_types.id')
                    ->select('appointments.*', 'patients.first_name', 'patients.last_name', 'client_types.type')
                    ->where('appointments.clinic_id', $clinic->id)
                    ->where('patients.status', 1)
                    ->whereBetween('appointments.date', [$request->from_date, $request->to_date])
                    ->get();
            } else {
                $data = $clinic->appointment()
                    ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                    ->join('payment_details', 'appointments.id', '=', 'payment_details.appointment_id')
                    ->join('client_types', 'payment_details.client_type_id', '=', 'client_types.id')
                    ->select('appointments.*', 'patients.first_name', 'patients.last_name', 'client_types.type')
                    ->where('appointments.clinic_id', $clinic->id)
                    ->where('patients.status', 1)
                    ->orderBy('appointments.created_at', 'desc')
                    ->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('appointment_status', function ($row) {
                    if ($row->status == 0) {
                        $output = '<span class="badge badge-danger">Not Scheduled</span>';
                    } else {
                        $output = '<span class="badge badge-success">Scheduled</span>';
                    }
                    return $output;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" data-id="' . $row['id'] . '" class="btn btn-tool viewAdminAppointmentBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['full_names', 'appointment_status', 'action'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $page_title = trans('pages.appointments');
        return view('admin.appointments.index', compact('clinic', 'page_title', 'patients'));
    }

    public function show($appointment_id)
    {
        # code...
        $appointment = Appointment::findOrFail($appointment_id);
        return new ResourcesAppointment($appointment);
    }

    public function view($id, $appointment_id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $appointment = Appointment::findOrFail($appointment_id);
        $patient = $appointment->patient;
        $payment_details = $appointment->payment_detail;
        $doctor_schedule = $appointment->doctor_schedule;
        $page_title = 'View Appointment';
        return view('admin.appointments.view', [
            'clinic' => $clinic,
            'appointment' => $appointment,
            'patient' => $patient,
            'payment_details' => $payment_details,
            'doctor_schedule' => $doctor_schedule,
            'page_title' => $page_title,
        ]);
    }
    public function export(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        return (new AppointmentsExport($clinic->id, $from_date, $to_date))->download('appointments' . time() . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
