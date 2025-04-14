<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateStatusRequest;
use App\Mail\UsersMail;
use App\Models\Admin;
use App\Models\Clinic;
use App\Models\User;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->middleware('auth:admin');
        $this->usersRepository = $usersRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * Display all organizational optoms
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $this->usersRepository->all($organization);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row['first_name'] . ' ' . $row['last_name'];
                })
                ->addColumn('status', function ($row) {
                    return $row['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    //$btn = $btn . '<a class="dropdown-item viewUserBtn" href="javascript:void(0)" data-id="' . $row->id . '">View</a>';
                    if ($row->status) {
                        $btn = $btn . '<a class="dropdown-item deactivateBtn" data-status="0" href="javascript:void(0)" data-id="' . $row->id . '">Deactivate</a>';
                    } else {
                        $btn = $btn . '<a class="dropdown-item activateBtn" data-status="1" href="javascript:void(0)" data-id="' . $row->id . '">Activate</a>';
                    }
                    // $btn = $btn . '<a class="dropdown-item delete deleteUsersBtn" data-id="' . $row->id . '" href="javascript:void(0)">Delete</a>';
                    $btn = $btn . '</div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'status'])
                ->make(true);
        }
        $page_title = trans('pages.users');
        return view('admin.users.all.index', [
            'page_title' => $page_title,
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * Display all clinic optoms
     *
     * @return \Illuminate\Http\Response
     */
    public function clinic(Request $request, Clinic $clinic)
    {
        if ($request->ajax()) {
            $data = $this->usersRepository->find_users_for_clinic($clinic);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row['first_name'] . ' ' . $row['last_name'];
                })
                ->addColumn('status', function ($row) {
                    return $row['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    //$btn = $btn . '<a class="dropdown-item viewUserBtn" href="javascript:void(0)" data-id="' . $row->id . '">View</a>';
                    if ($row->status) {
                        $btn = $btn . '<a class="dropdown-item deactivateBtn" data-status="0" href="javascript:void(0)" data-id="' . $row->id . '">Deactivate</a>';
                    } else {
                        $btn = $btn . '<a class="dropdown-item activateBtn" data-status="1" href="javascript:void(0)" data-id="' . $row->id . '">Activate</a>';
                    }
                    // $btn = $btn . '<a class="dropdown-item delete deleteUsersBtn" data-id="' . $row->id . '" href="javascript:void(0)">Delete</a>';
                    $btn = $btn . '</div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'status'])
                ->make(true);
        }

        $patients = $clinic->patient->count();
        $page_title = trans('pages.users');
        return view('admin.users.index', [
            'clinic' => $clinic,
            'patients' => $patients,
            'page_title' => $page_title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:10|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|boolean',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $password = Str::random(8);

        $user = $clinic->user()->create([
            'organization_id' => $clinic->organization_id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'status' => $data['status'],
            'username' => Str::random(6),
            'password' => Hash::make($password),
        ]);

        $user->attachRole($data['role_id']);

        $details['name'] = $user->first_name . ' ' . $user->last_name;
        $details['email'] = $user->email;
        $details['password'] = $password;
        $details['url'] = route('users.login');

        Mail::to($user->email)->send(new UsersMail($details));

        $response['status'] = true;
        $response['message'] = 'User successfully created';
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        //
        $user = User::findOrFail($user_id);
        $response = [
            'status' => true,
            'data' => $user
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_status(UpdateStatusRequest $request, $user_id)
    {
        //
        $user = User::findOrFail($user_id);

        $data = $request->except("_token");

        $user->update([
            'status' => $data['status']
        ]);

        if ($data['status'] == 1) {
            $message = 'You have successfully activated current account';
        } else {
            $message = 'You have successfully deactivated current account';
        }

        $response = [
            'status' => true,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $user = User::findOrFail($data['user_id']);
        $user->delete();

        $response['status'] = true;
        $response['message'] = 'You have successfully removed the current doctor';
        return response()->json($response, 200);
    }
}
