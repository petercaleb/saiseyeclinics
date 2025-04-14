<?php

namespace App\Http\Controllers\Admin\LensMaterial;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LensMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class LensMaterialsController extends Controller
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
        $admin = Admin::find(auth('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->lens_material->sortBy('created_at', SORT_DESC);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    $btn = $btn . '<a class="dropdown-item editMaterialBtn" data-id="' . $row['id'] . '" href="javascript:void(0)"><i class="fa fa-edit"></i> Edit</a>';
                    $btn = $btn . '<div class="dropdown-divider"></div>';
                    $btn = $btn . '<a class="dropdown-item deleteMaterialBtn" data-id="' . $row['id'] . '" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a>';
                    $btn = $btn . '</div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Lens Materials';
        return view('admin.lens_materials.index', [
            'page_title' => $page_title,
            'organization' => $organization,
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $organization->lens_material()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Lens Material created successfully';
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
            'material_id' => 'required|integer|exists:lens_materials,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens_material = LensMaterial::findOrFail($data['material_id']);
        $response['status'] = true;
        $response['data'] = $lens_material;
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
            'material_id' => 'required|integer|exists:lens_materials,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens_material = LensMaterial::findOrFail($data['material_id']);

        $lens_material->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Lens Material updated successfully';
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
            'material_id' => 'required|integer|exists:lens_materials,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens_material = LensMaterial::findOrFail($data['material_id']);
        $lens_material->delete();

        $response['status'] = true;
        $response['message'] = 'Lens Material deleted successfully';
        return response()->json($response, 200);
    }
}
