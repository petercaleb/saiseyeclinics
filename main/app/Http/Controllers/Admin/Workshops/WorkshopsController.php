<?php

namespace App\Http\Controllers\Admin\Workshops;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WorkshopsController extends Controller
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
        if($request->ajax()){
            $data = $organization->workshop->sortBy('created_at', SORT_DESC);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return '<a href="javascript:void(0)" data-id="'.$row->id.'" class="selectWorkshopBtn">'. $row->name . '</a>';
                })
                ->addColumn('logo', function($row){
                    $logo = '<img src="'.asset('storage/workshops/'.$row->logo).'" alt="'.$row->name.'" class="img-circle img-size-32 mr-2"/>';
                    return $logo;
                })
                ->addColumn('action', function($data){
                    $button = '<button type="button" data-id="'.$data->id.'" class="btn btn-primary btn-sm selectWorkshopBtn">';
                    $button = $button . '<i class="fas fa-tachometer-alt"></i> Dashboard</button>';
                    return $button;
                })
                ->rawColumns(['action', 'logo', 'name'])
                ->make(true);
        }

        $page_title = 'Workshops';
        return view('admin.workshops.index', compact('page_title', 'organization'));
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
            'organization_id' => 'required|integer|exists:organizations,id',
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'required|numeric|min:10',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if($request->hasFile('logo')){
            // file name with extension
            $logoNameWithExt = $request->file('logo')->getClientOriginalName();

            // Get Filename
            $logoName = pathinfo($logoNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('logo')->getClientOriginalExtension();

            // Filename To store
            $logoNameToStore = $logoName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('logo')->storeAs('public/workshops', $logoNameToStore);
        }
        else{
            $logoNameToStore = 'noimage.png';
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $organization->workshop()->create([
            'name' => $data['name'],
            'initials' => $data['initials'],
            'logo' => $logoNameToStore,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Workshop created successfully';

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
            'workshop_id' => 'required|integer|exists:workshops,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $workshop = Workshop::findOrFail($data['workshop_id']);
        $response['status'] = true;
        $response['data'] = $workshop;
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        //
        $workshop = Workshop::findOrFail($id);
        $page_title = "View Workshop";
        return view('admin.workshops.view', [
            'page_title' => $page_title,
            'workshop' => $workshop,
        ]);
    }
    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'workshop_id' => 'required|integer|exists:workshops,id',
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if($request->hasFile('logo')){

            // file name with extension
            $logoNameWithExt = $request->file('logo')->getClientOriginalName();

            // Get Filename
            $logoName = pathinfo($logoNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('logo')->getClientOriginalExtension();

            // Filename To store
            $logoNameToStore = $logoName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('logo')->storeAs('public/workshops', $logoNameToStore);
        }

        $workshop = Workshop::findOrFail($data['workshop_id']);

        if($request->hasFile('logo')){
            $workshop->logo = $logoNameToStore;
        }

        $workshop->name = $data['name'];
        $workshop->initials = $data['initials'];
        $workshop->phone = $data['phone'];
        $workshop->email = $data['email'];
        $workshop->address = $data['address'];
        $workshop->save();

        $response['status'] = true;
        $response['message'] = 'Workshop updated successfully';
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
            'workshop_id' => 'required|integer|exists:workshops,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $workshop = Workshop::findOrFail($data['workshop_id']);
        $workshop->delete();

        $response['status'] = true;
        $response['message'] = 'Workshop deleted successfully';
        return response()->json($response, 200);
    }
}
