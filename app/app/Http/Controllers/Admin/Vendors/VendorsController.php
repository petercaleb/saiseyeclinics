<?php

namespace App\Http\Controllers\Admin\Vendors;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Organization;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VendorsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->vendor->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-tool btn-sm updateVendorBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-tool btn-sm deleteVendorBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('full_names', function ($row) {

                    $full_names = $row['first_name'] . " " . $row["last_name"];

                    return $full_names;

                })
                ->rawColumns(['action', 'full_names'])
                ->make(true);
        }
        $page_title = "Vendors";
        return view('admin.settings.workshops.vendors.index', [
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
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'company' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'type' => 'required|string',
            'location' => 'nullable',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $organization->vendor()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company' => $data['company'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'type' => $data['type'],
            'location' => $data['location'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Vendors created successfully.';
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'vendor_id' => 'required|integer|exists:vendors,id'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $vendor = Vendor::findOrFail($data['vendor_id']);

        $response['status'] = true;
        $response['data'] = $vendor;

        return response()->json($response, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'company' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'type' => 'required|string',
            'location' => 'nullable',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $vendor = Vendor::findOrFail($id);

        $vendor->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company' => $data['company'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'type' => $data['type'],
            'location' => $data['location'],
        ]);

        $response['status'] = true;
        $response['message'] = 'vendor updated successfully';
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        $response['status'] = true;
        $response['message'] = 'Vendor deleted successfully';
        return response()->json($response, 200);
    }
}
