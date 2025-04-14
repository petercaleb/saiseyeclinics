<?php

namespace App\Http\Controllers\Admin\Patients;

use App\Exports\PatientsReport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Patient as ResourcesPatient;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Builder\Param;
use Yajra\DataTables\Facades\DataTables;

class PatientsController extends Controller
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
                $data = $clinic->patient()
                    ->whereBetween('appointments.date', [$request->from_date, $request->to_date])
                    ->get();
            } else {
                $data = $clinic->patient()->latest()->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('doctor_full_names', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('status', function($row){
                    if($row->status)
                    {
                        return 'ACTIVE';
                    }else{
                        return "IN-ACTIVE";
                    }
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-tool viewBtn" id="' . $row['id'] . '" href="javascript:void(0)">';
                    $btn = $btn . '<i class="fa fa-eye"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['full_names', 'action', 'added_by'])
                ->make(true);
        }
        $page_title = trans('pages.patients');
        $patients = $clinic->patient->count();
        return view('admin.patients.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'patients' => $patients,
        ]);
    }

    public function show($patient_id)
    {
        # code...

        $patient = Patient::findOrFail($patient_id);
        return new ResourcesPatient($patient);
    }

    public function view($id, $patient_id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $patient = $clinic->patient()->findOrFail($patient_id);
        $page_title = trans('pages.patients');
        $sidebar = 'profile';
        return view('admin.patients.view', [
            'clinic' => $clinic,
            'patient' => $patient,
            'page_title' => $page_title,
            'patient_sidebar' => $sidebar
        ]);
    }

    public function appointments($id, $patient_id)
    {
        $clinic = Clinic::findOrFail($id);
        $patient = $clinic->patient()->findOrFail($patient_id);
        $appointments = $patient->appointment->sortBy('created_at', SORT_DESC);
        $page_title = trans('pages.patients');
        $sidebar = 'appointments';
        return view('admin.patients.appointments', [
            'clinic' => $clinic,
            'patient' => $patient,
            'appointments' => $appointments,
            'page_title' => $page_title,
            'patient_sidebar' => $sidebar
        ]);
    }

    public function schedules($id, $patient_id)
    {
        $clinic = Clinic::findOrFail($id);
        $patient = $clinic->patient()->findOrFail($patient_id);
        $schedules = $patient->docor_schedule->sortBy('created_at', SORT_DESC);
        $page_title = trans('pages.patients');
        $sidebar = 'schedules';
        return view('admin.patients.schedules', [
            'clinic' => $clinic,
            'patient' => $patient,
            'schedules' => $schedules,
            'page_title' => $page_title,
            'patient_sidebar' => $sidebar
        ]);
    }

    public function payments(Request $request, $id, $patient_id)
    {
        $clinic = Clinic::findOrFail($id);
        $patient = $clinic->patient()->findOrFail($patient_id);
        if ($request->ajax()) {
            $data = $patient->payment_bill()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('open_date', function ($row) {
                    return date("d, F, Y", strtotime($row['created_at']));
                })
                ->addColumn('view', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row['id'] . '" class="btn btn-tool viewPaymentBtn">';
                    $btn = $btn . '<i class="fa fa-eye"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['view', 'open_date'])
                ->make(true);
        }
        $page_title = trans('pages.patients');
        $sidebar = 'payments';
        return view('admin.patients.payments', [
            'clinic' => $clinic,
            'patient' => $patient,
            'page_title' => $page_title,
            'patient_sidebar' => $sidebar
        ]);
    }

    public function orders(Request $request, $id, $patient_id)
    {
        $clinic = Clinic::findOrFail($id);
        $patient = $clinic->patient()->findOrFail($patient_id);
        if ($request->ajax()) {

            if (!empty($request->status) && !empty($request->order_id)) {
                $data = $patient->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.id', 'orders.clinic_id', 'orders.receipt_number', 'orders.workshop_id', 'order_tracks.track_status', 'order_tracks.track_date')
                    ->where('orders.id', $request->order_id)
                    ->where('order_tracks.track_status', $request->status)
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            } elseif (!empty($request->status) && empty($request->order_id)) {
                $data = $patient->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.id', 'orders.clinic_id', 'orders.receipt_number', 'orders.workshop_id', 'order_tracks.track_status', 'order_tracks.track_date')
                    ->where('order_tracks.track_status', $request->status)
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            } elseif (empty($request->status) && !empty($request->order_id)) {
                $data = $patient->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.id', 'orders.clinic_id', 'orders.receipt_number', 'orders.workshop_id', 'order_tracks.track_status', 'order_tracks.track_date')
                    ->where('orders.id', $request->order_id)
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            } else {
                $data = $patient->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.id', 'orders.clinic_id', 'orders.receipt_number', 'orders.workshop_id', 'order_tracks.track_status', 'order_tracks.track_date')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d, F, Y', strtotime($row->track_date));
                })
                ->addColumn('order_number', function ($row) {
                    return '#' . $row->id;
                })
                ->addColumn('clinic', function ($row) {
                    $clinic = Clinic::findOrFail($row->clinic_id);
                    return $clinic->clinic;
                })
                ->addColumn('status', function ($row) {
                    return $row->track_status;
                })
                ->addColumn('workshop', function ($row) {
                    $workshop = Workshop::findOrFail($row->workshop_id);
                    return $workshop->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tool viewOrderBtn">';
                    $btn = $btn . '<i class="fa fa-eye"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'order_number', 'date', 'workshop'])
                ->make(true);
        }
        $orders = $patient->order()->latest()->get();
        $page_title = trans('pages.patients');
        $sidebar = 'orders';
        return view('admin.patients.orders', [
            'clinic' => $clinic,
            'patient' => $patient,
            'orders' => $orders,
            'page_title' => $page_title,
            'patient_sidebar' => $sidebar
        ]);
    }

    public function export(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        return (new PatientsReport($clinic->id, $from_date, $to_date))->download('patients' . time() . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function activate($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);

        $patient->update([
            'status' => 1
        ]);

        $response['status'] = true;
        $response['message'] = 'Patient activated successfully';
        return response()->json($response, 200);
    }


    public function deactivate($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);

        $patient->update([
            'status' => 0
        ]);

        $response['status'] = true;
        $response['message'] = 'Patient deactivated successfully';
        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        # code...
        $patient = Patient::findOrFail($id);

        // check if patient has any order

        if ($patient->delete()) {
            $response['status'] = true;
            $response['message'] = 'Patient deleted successfully';
            return response()->json($response, 200);
        } else {
            $response['status'] = false;
            $response['errors'] = 'Error deleting patient';
            return response()->json($response, 401);
        }
    }
}
