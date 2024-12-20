<?php

namespace App\Http\Controllers\Admin\Status;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StatusController extends Controller
{
    //
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
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if($request->ajax()){
            $data = $organization->status->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="editBtn btn btn-tool btn-sm"><i class="fa fa-edit"></i></button>';
                    $button = $button.' <button type="button" name="delete" id="'.$data->id.'" class="deleteBtn btn btn-tool btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Status';
        return view('admin.status.index', compact('page_title'));
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $organization->status()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Status created successfully.';
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
            'status_id' => 'required|exists:statuses,id|integer',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $status = Status::findOrFail($data['status_id']);
        $response['status'] = true;
        $response['data'] = $status;
        return response()->json($response, 200);
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
            'status_id' => 'required|exists:statuses,id|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $status = $organization->status->find($data['status_id']);

        $status->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Status updated successfully.';
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
            'status_id' => 'required|exists:statuses,id|integer',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $status = Status::findOrFail($data['status_id']);
        $status->delete();

        $response['status'] = true;
        $response['message'] = 'Status deleted successfully.';
        return response()->json($response, 200);
    }
}
