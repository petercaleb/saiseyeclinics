<?php

namespace App\Http\Controllers\Admin\Technicians;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateStatusRequest;
use App\Mail\TechnicianNotification;
use App\Mail\TechniciansMail;
use App\Models\Admin;
use App\Models\Technician;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TechniciansController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request, $id)
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $workshop = Workshop::findOrFail($id);
        $organization = $workshop->organization;
        if ($request->ajax()) {
            $data = $workshop->technician()->orderBy('created_at', 'desc')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row['first_name'] . ' ' . $row['last_name'];
                })
                ->addColumn('status', function ($row) {
                    return $row['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    if ($row->status) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-status="0"  data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deactivateTechnicianBtn">';
                        $btn = $btn . 'DEACTIVATE';
                        $btn = $btn . '</a>';
                    } else {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-status="1" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-success btn-sm activateTechnicianBtn">';
                        $btn = $btn . 'ACTIVATE';
                        $btn = $btn . '</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'status'])
                ->make(true);
        }
        $page_title = "Technicians";
        return view('admin.technicians.index', [
            'page_title' => $page_title,
            'workshop' => $workshop,
        ]);
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'workshop_id' => 'required|integer|exists:workshops,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:10|unique:technicians',
            'email' => 'required|string|email|max:255|unique:technicians',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $workshop = Workshop::findOrFail($data['workshop_id']);

        $password = Str::random(8);

        $technician = $workshop->technician()->create([
            'organization_id' => $workshop->organization_id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'profile' => 'noimage.png',
            'phone' => $data['phone'],
            'email' => $data['email'],
            'status' => $data['status'],
            'username' => Str::random(6),
            'password' => Hash::make($password),
        ]);

        $details['name'] = $technician->first_name . ' ' . $technician->last_name;
        $details['email'] = $technician->email;
        $details['password'] = $password;
        $details['url'] = route('technicians.login');

        Mail::to($technician->email)->send(new TechniciansMail($details));

        $response['status'] = true;
        $response['message'] = 'Technician successfully created';
        return response()->json($response, 200);
    }

    public function show($id)
    {
        # code...
        $technician = Technician::findOrFail($id);
        $response['status'] = true;
        $response['data'] = $technician;
        return response()->json($response);
    }

    public function update_status(UpdateStatusRequest $request, $id) 
    {
        $technician = Technician::findOrFail($id);

        $data = $request->except("_token");

        $technician->update([
            'status' => $data['status'],
        ]);

        if($data['status'])
        {
            $message = "You have succeccfully activated technician account";
        } else {
            $message = "You have succeccfully deactivated technician account";
        }

        $response = [
            'status' => true,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        # code...
        $technician = Technician::findOrFail($id);
        if ($technician->profile != 'noimage.png') {
            Storage::delete('public/technicians/' . $technician->profile);
        }
        $technician->delete();

        $details['name'] = $technician->first_name . " " . $technician->last_name;

        Mail::to($technician->email)->cc('info@saiseyeclinics.com')->send(new TechnicianNotification($details));

        $response['status'] = true;
        $response['message'] = "You have successfully removed technician";
    }

    
}
