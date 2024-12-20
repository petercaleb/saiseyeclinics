<?php

namespace App\Http\Controllers\Admin\LensType;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LensType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LensTypeController extends Controller
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
            $data = $organization->lens_type->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    $btn = $btn . '<a class="dropdown-item editLensType" data-id="' . $row['id'] . '" href="javascript:void(0)"><i class="fa fa-edit"></i> Edit</a>';
                    $btn = $btn . '<div class="dropdown-divider"></div>';
                    $btn = $btn . '<a class="dropdown-item deleteLensType" data-id="' . $row['id'] . '" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a>';
                    $btn = $btn . '</div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = "Lens Type";
        return view('admin.lens_type.index', [
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
            'type' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $organization->lens_type()->create([
            'type' => $data['type'],
            'slug' => Str::slug($data['type']),
            'description' => $data['description'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Lens Type created successfully.';
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
            'type_id' => 'required|integer|exists:lens_types,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens_type = LensType::findOrFail($data['type_id']);
        $response['status'] = true;
        $response['data'] = $lens_type;
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
            'type_id' => 'required|integer|exists:lens_types,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $lens_type = $organization->lens_type()->find($data['type_id']);
        $lens_type->update([
            'type' => $data['type'],
            'slug' => Str::slug($data['type']),
            'description' => $data['description'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Lens Type updated successfully.';
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
            'type_id' => 'required|integer|exists:lens_types,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $lens_type = $organization->lens_type()->find($data['type_id']);
        $lens_type->delete();
        $response['status'] = true;
        $response['message'] = 'Lens Type deleted successfully.';
        return response()->json($response, 200);
    }
}
