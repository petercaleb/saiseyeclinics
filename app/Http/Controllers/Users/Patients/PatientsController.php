<?php

namespace App\Http\Controllers\Users\Patients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Patients\StorePatientRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PatientsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        # code..
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->patient()
                ->where('status', 1)
                ->whereBetween('date_in', [$request->from_date, $request->to_date])
                ->latest()->get();
            } else {
                $data = $clinic->patient()->where('status', 1)->latest()->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    $btn = $btn . '<a class="dropdown-item editBtn" id="' . $row['id'] . '" href="#"><i class="fa fa-edit"></i> Edit</a>';
                    $btn = $btn . '<div class="dropdown-divider"></div>';
                    $btn = $btn . '<a class="dropdown-item viewBtn" id="' . $row['id'] . '" href="#"><i class="fa fa-user"></i> Profile</a>';
                    $btn = $btn . '</div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['full_names', 'action'])
                ->make(true);
        }
        $page_title = trans('pages.patients');
        return view('users.patients.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
        ]);
    }

    public function create()
    {
        # code...
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $organization = $clinic->organization;
        $client_types = $organization->client_type->sortBy('created_at', SORT_DESC);
        $insurances = $organization->insurance->sortBy('created_at', SORT_DESC);
        $page_title = 'Create Patient';
        return view('users.patients.create', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'client_types' => $client_types,
            'insurances' => $insurances,
        ]);
    }

    public function store(StorePatientRequest $request)
    {
        # code...
        $data = $request->all();

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $patient = new Patient;

        $patient->user_id = Auth::user()->id; //doctor id
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
        $patient->card_number = $data['card_number'];

        if ($patient->save()) {
            $request->session()->put('patient_id', $patient->id);
            $response['patient_id'] = $patient->id;
            $response['status'] = true;
            $response['message'] = 'Patient created successfully';
            return response()->json($response, 200);
        }
    }

    public function show(Patient $patient)
    {
        # code..
        $response['status'] = true;
        $response['data'] = $patient;
        return response()->json($response, 200);
    }

    public function view(Patient $patient)
    {
        # code...
        $clinic = $patient->clinic;
        $page_title = trans('users.page.patients.sub_page.view');
        $patient_sidebar = trans('users.page.patients.sub_page.view');
        return view('users.patients.view', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'patient' => $patient,
            'patient_sidebar' => $patient_sidebar
        ]);
    }

    public function appointments($id) 
    {
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $patient = Patient::findOrFail($id);
        $appointments = $patient->appointment->sortBy('created_at', SORT_DESC);
        $doctors = User::where('clinic_id', $clinic->id)->whereRoleIs('doctor')->get();
        $page_title = trans('users.page.patients.sub_page.view');
        $patient_sidebar = trans('users.page.patients.sub_page.appointment');
        return view('users.patients.appointment', [
            'page_title' => $page_title,
            'doctors' => $doctors,
            'clinic' => $clinic,
            'patient' => $patient,
            'appointments' => $appointments,
            'patient_sidebar' => $patient_sidebar
        ]);
    }

    public function schedules($id) 
    {
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $patient = Patient::findOrFail($id);
        $schedules = $patient->docor_schedule->sortBy('created_at', SORT_DESC);
        $page_title = trans('pages.patients');
        $patient_sidebar = trans('patient.schedule');
        return view('users.patients.schedules', [
            'page_title' => $page_title,
            'schedules' => $schedules,
            'clinic' => $clinic,
            'patient' => $patient,
            'patient_sidebar' => $patient_sidebar
        ]);
    }

    public function edit(Patient $patient)
    {
        $clinic = $patient->clinic;
        $organization = $clinic->organization;
        $client_types = $organization->client_type->sortBy('created_at', SORT_DESC);
        $insurances = $organization->insurance->sortBy('created_at', SORT_DESC);
        $page_title = trans('users.page.patients.sub_page.edit');
        return view('users.patients.edit', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'client_types' => $client_types,
            'insurances' => $insurances,
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, Patient $patient)
    {
        # code...

        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|unique:patients,id_number,' . $patient->id,
            'phone' => 'required|numeric|min:10',
            'email' => 'nullable|string|email|max:255',
            'dob' => 'required|string|max:255|date_format:Y-m-d',
            'gender' => 'required|string',
            'next_of_kin_contact' => 'nullable|numeric|min:10',
            'card_number' => 'required|unique:patients,card_number, ' . $patient->id,
        ], [
            'dob.date_format' => 'Date of Birth Must Match The Format: Y-m-d'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $patient->id = $patient->id;
        $patient->user_id = $patient->user_id; //doctor id
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
        $patient->updated_by = Auth::user()->id;
        $patient->card_number = $data['card_number'];

        $patient->save();

        $response['status'] = true;
        $response['message'] = "You have successfully updated current patient details";

        return response()->json($response, 200);
    }


    public function destroy(Patient $patient)
    {
        # code...
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
