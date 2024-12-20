<?php

namespace App\Http\Controllers\Admin\Clinics;

use COM;
use App\Models\Admin;
use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\Clinics\StoreClinicRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Clinic as ResourcesClinic;

class ClinicsController extends Controller
{
    //

    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->clinic()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    return '<img src="' . asset('storage/clinics/' . $row['logo']) . '" class="img-circle img-size-32 mr-2">';
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="' . $row['id'] . '" class="btn btn-primary btn-sm selectBtn">';
                    $btn = $btn . '<i class="fas fa-tachometer-alt"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" id="' . $row['id'] . '" class="btn btn-danger btn-sm deleteBtn">';
                    $btn = $btn . '<i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['logo', 'actions'])
                ->make(true);
        }

        $page_title = 'Clinics';
        return view('admin.clinics.index', compact('organization', 'page_title'));
    }

    public function get_trashed(Request $request)
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->clinic()->onlyTrashed()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    return '<img src="' . asset('storage/clinics/' . $row['logo']) . '" class="img-circle img-size-32 mr-2">';
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="' . $row['id'] . '" class="btn btn-success btn-sm restoreBtn">';
                    $btn = $btn . '<i class="fas fa-redo-alt"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" id="' . $row['id'] . '" class="btn btn-danger btn-sm deleteCompletelyBtn">';
                    $btn = $btn . '<i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['logo', 'actions'])
                ->make(true);
        }
    }

    public function store(StoreClinicRequest $request)
    {
        # code...
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $clinics = new Clinic;

        $clinics->organization_id = $organization->id;
        $clinics->clinic = $data['clinic'];

        if ($request->hasFile('logo')) {
            $storagePath = 'public/clinics';
            $fileName = 'logo';
            $logoNameToStore = $this->uploadFile($request, $fileName, $storagePath);
        } else {
            $logoNameToStore = 'noimage.png';
        }

        $clinics->logo = $logoNameToStore;
        $clinics->phone = $data['phone'];
        $clinics->email = $data['email'];
        $clinics->address = $data['address'];
        $clinics->location = $data['location'];
        $clinics->initials = $data['initials'];

        $clinics->save();

        $response['status'] = true;
        $response['message'] = 'Clinic added successfully';
        return response()->json($response, 200);
    }

    public function show(Clinic $clinic)
    {
        # code...
        return response()->json([
            'status' => true,
            'data' => $clinic
        ]);
    }

    public function view($id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $patients = $clinic->patient->count();
        $page_title = 'Clinic';
        return view('admin.clinics.view', compact('clinic', 'page_title', 'patients'));
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'clinic' => 'required|string|max:255',
            'logo' => 'image|mimes:png,jpg,jpeg|nullable',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|max:255',
            'location' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if ($request->hasFile('logo')) {

            $logoNameWithExt = $request->file('logo')->getClientOriginalName();

            // Get Filename
            $logoName = pathinfo($logoNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('logo')->getClientOriginalExtension();

            // Filename To store
            $logoNameToStore = $logoName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('logo')->storeAs('public/clinics', $logoNameToStore);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $clinic->id = $clinic->id;
        $clinic->organization_id = $clinic->organization_id;
        $clinic->clinic = $data['clinic'];
        if ($request->hasFile('logo')) {
            $clinic->logo = $logoNameToStore;
        }
        $clinic->phone = $data['phone'];
        $clinic->email = $data['email'];
        $clinic->address = $data['address'];
        $clinic->location = $data['location'];
        $clinic->initials = $data['initials'];

        $clinic->save();

        $response['status'] = true;
        $response['message'] = 'Clinic updated successfully';
        return response()->json($response, 200);
    }

    public function destroy(Clinic $clinic)
    {

        $clinic->delete();
        $response['status'] = true;
        $response['message'] = 'Clinic deleted successfully';
        return response()->json($response, 200);
    }

    public function restore($clinic)  
    {
        $clinic = Clinic::onlyTrashed()->find($clinic);
        $clinic->restore();
        $response['status'] = true;
        $response['message'] = 'Clinic restored successfully';
        return response()->json($response, 200);
    }

    public function forceDelete($clinic)
    {
        $clinic = Clinic::onlyTrashed()->find($clinic);
        if ($clinic->logo != 'noimage.png') {
            // Delete Image
            Storage::delete('public/clinics/' . $clinic->logo);
        }

        $clinic->forceDelete();
        $response['status'] = true;
        $response['message'] = 'Clinic deleted successfully';
        return response()->json($response, 200);
    }
}
