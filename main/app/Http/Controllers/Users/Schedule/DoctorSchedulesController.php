<?php

namespace App\Http\Controllers\Users\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\DoctorSchedule;
use App\Models\LensMaterial;
use App\Models\LensPower;
use App\Models\LensPower1;
use App\Models\LensPrescription;
use App\Models\LensPrescription1;
use App\Models\LensType;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class DoctorSchedulesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->doctor_schedule()
                    ->whereBetween('date', [$request->from_date, $request->to_date])
                    ->get();
            } else {
                $data = $clinic->doctor_schedule()->latest()->get();
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('patient_name', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('dr_name', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="btn btn-tool btn-sm viewDoctorSchedule">';
                    $btn = $btn . '<i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'patient_name', 'dr_name'])
                ->make(true);
        }
        $page_title = 'Doctor Schedules';
        return view('users.schedules.index', compact('clinic', 'page_title'));
    }

    public function my_schedules(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $user->doctor_schedule()
                    ->whereBetween('date', [$request->from_date, $request->to_date])
                    ->get();
            } else {
                $data = $user->doctor_schedule()->latest()->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('patient_name', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('dr_name', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="btn btn-tool btn-sm viewDoctorSchedule">';
                    $btn = $btn . '<i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'patient_name', 'dr_name'])
                ->make(true);
        }
        $page_title = trans('users.page.schedules.sub_page.my_schedules');
        return view('users.schedules.personal', [
            'page_title' => $page_title,
            'clinic' => $clinic
        ]);
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'user_id' => 'required|integer|exists:users,id',
            'patient_id' => 'required|integer|exists:patients,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);
        $user = User::findOrFail($data['user_id']);
        $patient = Patient::findOrFail($data['patient_id']);
        $appointment = Appointment::findOrFail($data['appointment_id']);
        $schedule = new DoctorSchedule;
        $schedule->clinic_id = $clinic->id;
        $schedule->user_id = $user->id;
        $schedule->patient_id = $patient->id;
        $schedule->appointment_id = $appointment->id;
        $today = Carbon::now();
        $day = Carbon::parse($today)->format('l');
        $time = Carbon::parse($today)->format('H:i:s');
        $schedule->day = $day;
        $schedule->date = $today;
        $schedule->time = $time;
        $schedule->status = 1;

        if ($schedule->save()) {

            $report = $clinic->report()->findOrFail($appointment->report_id);

            $report->update([
                'schedule_id' => $schedule->id,
            ]);

            $appointment->id = $appointment->id;
            $appointment->status = 1;
            $appointment->save();
            $response['status'] = true;
            $response['message'] = 'Schedule created successfully';
            $response['schedule_id'] = $schedule->id;
            return response()->json($response, 200);
        }
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'schedule_id' => 'required|integer|exists:doctor_schedules,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $schedule = DoctorSchedule::findOrFail($data['schedule_id']);
        $response['status'] = true;
        $response['data'] = $schedule;
        return response()->json($response, 200);
    }

    public function view($id)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        $organization = $clinic->organization;
        $types = $organization->lens_type->sortBy('created_at', SORT_DESC);
        $materials = $organization->lens_material->sortBy('created_at', SORT_DESC);
        $workshops = $organization->workshop->sortBy('created_at', SORT_DESC);
        $schedule = DoctorSchedule::findOrFail($id);
        $patient = $schedule->patient;
        $doctor = $schedule->user;
        $appointment = $schedule->appointment;
        $payment_details = $appointment->payment_detail;
        $diagnosis = $schedule->diagnosis;
        $lens_power_1 = null;
        $lens_prescription_1 = null;

        //Get Lens power 1

        if ($diagnosis) {
            $treatment = $diagnosis->treatment;
            $lens_power = $diagnosis->lens_power;
            $lens_power_1_id = LensPower1::where("schedule_id", $id)->value('id');
            if (!is_null($lens_power_1_id)) {
                $lens_power_1 = LensPower1::findOrFail($lens_power_1_id);
                $lens_prescription_1_id = LensPrescription1::where("power_id", $lens_power_1_id)->value("id");
                if ($lens_prescription_1_id) {
                    $lens_prescription_1 = LensPrescription1::findOrFail($lens_prescription_1_id);
                }
            }
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
            $treatment = null;
            $lens_power = null;
            $lens_power_1 = null;
            $lens_prescription = null;
            $frame_prescription = null;
            $procedure = null;
            $appointment = null;
            $payment_bill = null;
        }

        // Load frame stocks for the clinic
        $frame_stocks = $clinic->frame_stock()->where('closing', '>', 0)->latest()->get();
        if ($schedule->user_id == Auth::user()->id) {
            $view = trans('users.page.schedules.sub_page.view_personal');
        } else {
            $view = trans('users.page.schedules.sub_page.view');
        }
        $page_title = $view;

        return view('users.schedules.view', [
            'clinic' => $clinic,
            'schedule' => $schedule,
            'patient' => $patient,
            'doctor' => $doctor,
            'appointment' => $appointment,
            'payment_details' => $payment_details,
            'diagnosis' => $diagnosis,
            'treatment' => $treatment,
            'lens_power' => $lens_power,
            'lens_power_1' => $lens_power_1,
            'lens_prescription' => $lens_prescription,
            'lens_prescription_1' => $lens_prescription_1,
            'frame_prescription' => $frame_prescription,
            'types' => $types,
            'materials' => $materials,
            'workshops' => $workshops,
            'procedure' => $procedure,
            'payment_bill' => $payment_bill,
            'frame_stocks' => $frame_stocks,
            'page_title' => $page_title,
        ]);
    }



    public function export(Request $request)
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $clinic = $user?->clinic;
            $power_id = $request->input('power-id');
            $prescription_id = $request->input('prescription-id');
            $lens_power = LensPower::findOrFail($power_id);
            $patient_id = $lens_power?->patient_id;
            $patient = Patient::findOrFail($patient_id);
            $lens_prescription = LensPrescription::findOrFail($prescription_id);
            $type = LensType::findOrFail($lens_prescription?->type_id);
            $material = LensMaterial::findOrFail($lens_prescription?->material_id);

            $data = [
                'clinic_name' => $clinic?->clinic,
                'clinic_phone_number' => $clinic?->phone,
                'clinic_email' => $clinic?->email,
                'clinic_address' => $clinic?->address,
                'clinic_location' => $clinic?->location,
                'patient_name' => $patient?->first_name . " " . $patient?->last_name,
                'patient_tel_no' => $patient?->phone,
                'right_sphere' => $lens_power?->right_sphere,
                'right_cylinder' => $lens_power?->right_cylinder,
                'right_axis' => $lens_power?->right_axis,
                'right_add' => $lens_power?->right_add,
                'left_cylinder' => $lens_power->left_cylinder,
                'left_sphere' => $lens_power?->left_sphere,
                'left_cylinder' => $lens_power?->left_cylinder,
                'left_axis' => $lens_power?->left_axis,
                'left_add' => $lens_power?->left_add,
                'type' => $type?->type,
                'material' => $material?->material,
                'index' => $lens_prescription?->index,
                'tint' => $lens_prescription?->tint,
                'diameter' =>  $lens_prescription?->diameter,
                'focal_height' => $lens_prescription?->focal_height,
                'notes' => $lens_power?->notes
            ];

            // Set up DOMPDF options
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            // Create a new DOMPDF instance with options
            $pdf = new Dompdf($options);

            $pdf->setPaper('A4', 'potrait');

            // Load the HTML content for PDF generation
            $html = view('users.schedules.exports.lens_power', $data)->render();
            $pdf->loadHtml($html);

            // Render the PDF (first pass)
            $pdf->render();

            // Stream the PDF to the browser (inline view, no download)
            return $pdf->stream('receipt.pdf', ['Attachment' => 0]);
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            return response()->json(['error' => 'PDF generation failed'], 500);
        }
    }
}
