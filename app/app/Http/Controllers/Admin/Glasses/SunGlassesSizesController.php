<?php

namespace App\Http\Controllers\Admin\Glasses;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SunGlassesSizesController extends Controller
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
            $data = $organization->size->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-tools btn-sm updateGlassSizeBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-tools btn-sm deleteGlassSizeBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Frame Sizes';
        return view('admin.settings.clinics.glasses.sizes.index', [
            'organization' => $organization,
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
            'size' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $organization->size()->create([
            'size' => $data['size'],
            'slug' => Str::slug($data['size'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Sun glasses size created successfully';
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
            'size_id' => 'required|integer|exists:sizes,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $size = Size::findOrFail($data['size_id']);

        $response['status'] = true;
        $response['data'] = $size;
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
            'size' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $size = Size::findOrFail($id);

        $size->update([
            'size' => $data['size'],
            'slug' => Str::slug($data['size'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Sun Glass size updated successfully';
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
        $size = Size::findOrFail($id);
        $size->delete();
        $response['status'] = true;
        $response['message'] = 'Sun glass size deleted successfully';
        return response()->json($response, 200);
    }
}
