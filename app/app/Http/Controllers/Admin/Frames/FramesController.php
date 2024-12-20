<?php

namespace App\Http\Controllers\Admin\Frames;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Admin;
use App\Models\Clinic;
use App\Models\Frame;
use App\Models\FrameBrand;
use App\Models\FrameMaterial;
use App\Models\FrameSize;
use App\Models\FrameType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FramesController extends Controller
{

    use FileUploadTrait;

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
            $data = $organization->frame->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('brand', function ($row) {
                    $brand = $row->frame_brand->title;
                    return $brand;
                })
                ->addColumn('size', function ($row) {
                    $size = $row->frame_size->size;
                    return $size;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->frame_type->title;
                    return $type;
                })
                ->addColumn('material', function ($row) {
                    $material = $row->frame_material->title;
                    return $material;
                })
                ->addColumn('photo', function ($row) {
                    $img = '<img src="' . asset('storage/frames/' . $row->photo) . '" alt="' . $row->title . '" class="img-circle img-size-32 mr-2" width="100px">';
                    return $img;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    $btn = $btn . '<a class="dropdown-item editFrame" data-id="' . $row->id . '" href="javascript:void(0)">Edit</a>';
                    $btn = $btn . '<a class="dropdown-item deleteFrame" data-id="' . $row->id . '" href="javascript:void(0)">Delete</a>';
                    $btn = $btn . '</div></div>';
                    return $btn;
                })
                ->rawColumns(['brand', 'size', 'material', 'photo', 'status', 'action'])
                ->make(true);
        }
        $frame_types = $organization->frame_type->sortBy('created_at', SORT_DESC); // Frame Types
        $frame_sizes = $organization->frame_size->sortBy('created_at', SORT_DESC); // Frame Sizes
        $frame_materials = $organization->frame_material->sortBy('created_at', SORT_DESC); // Frame Materials
        $frame_brands = $organization->frame_brand->sortBy('created_at', SORT_DESC); // Frame Brands
        $page_title = 'frames';
        $sub_page = "frames";
        return view('admin.settings.clinics.frames.all.index', [
            'page_title' => $page_title,
            'sub_page' => $sub_page,
            'organization' => $organization,
            'frame_types' => $frame_types,
            'frame_sizes' => $frame_sizes,
            'frame_materials' => $frame_materials,
            'frame_brands' => $frame_brands,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function frames(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $organization = $clinic->organization;
        if ($request->ajax()) {
            $data = $clinic->frame()->join('frame_brands', 'frame_brands.id', '=', 'frames.brand_id')
                ->join('frame_types', 'frame_types.id', '=', 'frames.type_id')
                ->join('frame_sizes', 'frame_sizes.id', '=', 'frames.size_id')
                ->join('frame_materials', 'frame_materials.id', '=', 'frames.material_id')
                ->select('frames.*', 'frame_sizes.size as size', 'frame_brands.title as brand', 'frame_types.title as type', 'frame_materials.title as material')
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    $img = '<img src="' . asset('storage/frames/' . $row->photo) . '" alt="' . $row->title . '" class="img-circle img-size-32 mr-2" width="100px">';
                    return $img;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-tools btn-sm deleteFrame"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'photo', 'status'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $num_frames = $clinic->frame->count();
        $frame_types = $organization->frame_type->sortBy('created_at', SORT_DESC);
        $frame_sizes = $organization->frame_size->sortBy('created_at', SORT_DESC);
        $frame_materials = $organization->frame_material->sortBy('created_at', SORT_DESC);
        $frame_brands = $organization->frame_brand->sortBy('created_at', SORT_DESC);
        $page_title = 'All Frames';
        return view('admin.frames.frames', [
            'clinic' => $clinic,
            'patients' => $patients,
            'num_frames' => $num_frames,
            'frame_types' => $frame_types,
            'frame_sizes' => $frame_sizes,
            'frame_materials' => $frame_materials,
            'frame_brands' => $frame_brands,
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
            'code' => 'required|string|unique:frames,code',
            'type_id' => 'required|integer|exists:frame_types,id',
            'brand_id' => 'required|integer|exists:frame_brands,id',
            'size_id' => 'required|integer|exists:frame_sizes,id',
            'material_id' => 'required|integer|exists:frame_materials,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if ($request->hasFile('photo')) {
            $storagePath = 'public/frames';
            $fileName = 'photo';
            $photoNameToStore = $this->uploadFile($request, $fileName, $storagePath);
        } else {
            $photoNameToStore = 'noimage.png';
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $frame_type = FrameType::findOrFail($data['type_id']);

        $frame_brand = FrameBrand::findOrFail($data['brand_id']);

        $frame_size = FrameSize::findOrFail($data['size_id']);

        $frame_material = FrameMaterial::findOrFail($data['material_id']);

        $organization->frame()->create([
            'brand_id' => $frame_brand->id,
            'type_id' => $frame_type->id,
            'size_id' => $frame_size->id,
            'material_id' => $frame_material->id,
            'code' => $data['code'],
            'photo' => $photoNameToStore,
            'status' => $data['status'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame created successfully';
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $frame = Frame::findOrFail($id);

        $response['status'] = true;
        $response['data'] = $frame;
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

        $frame = Frame::findOrFail($id);

        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'code' => 'required|string|unique:frames,code,' . $frame->id,
            'type_id' => 'required|integer|exists:frame_types,id',
            'brand_id' => 'required|integer|exists:frame_brands,id',
            'size_id' => 'required|integer|exists:frame_sizes,id',
            'material_id' => 'required|integer|exists:frame_materials,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if ($request->hasFile('photo')) {
            // file name with extension
            $photoNameWithExt = $request->file('photo')->getClientOriginalName();

            // Get Filename
            $photoName = pathinfo($photoNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('photo')->getClientOriginalExtension();

            // Filename To store
            $photoNameToStore = $photoName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('photo')->storeAs('public/frames', $photoNameToStore);
        }

        $frame_type = FrameType::findOrFail($data['type_id']);

        $frame_brand = FrameBrand::findOrFail($data['brand_id']);

        $frame_size = FrameSize::findOrFail($data['size_id']);

        $frame_material = FrameMaterial::findOrFail($data['material_id']);

        if ($request->hasFile('photo')) {
            if ($frame->photo != 'noimage.png') {
                Storage::delete('public/frames/' . $frame->photo);
            }
            $frame->photo = $photoNameToStore;
        }

        $frame->update([
            'brand_id' => $frame_brand->id,
            'type_id' => $frame_type->id,
            'size_id' => $frame_size->id,
            'material_id' => $frame_material->id,
            'code' => $data['code'],
            'status' => $data['status'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame updated successfully';
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
            'frame_id' => 'required|integer|exists:frames,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame = Frame::findOrFail($data['frame_id']);
        if ($frame->photo != 'noimage.png') {
            Storage::delete('public/frames/' . $frame->photo);
        }

        $frame->delete();

        $response['status'] = true;
        $response['message'] = 'Frame deleted successfully';
        return response()->json($response, 200);
    }
}
