<?php

namespace App\Http\Controllers\Admin\Glasses;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Shape;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SunGlassesShapesController extends Controller
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
            $data = $organization->shape->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-tools btn-sm updateGlassShapeBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-tools btn-sm deleteGlassShapeBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Frame Shapes';
        return view('admin.settings.clinics.glasses.shapes.index', [
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
            'shape' => 'required|string|max:255',
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
        $organization->shape()->create([
            'shape' => $data['shape'],
            'slug' => Str::slug($data['shape'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Frame Shape created successfully';
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
            'shape_id' => 'required|integer|exists:shapes,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $shape = Shape::findOrFail($data['shape_id']);

        $response['status'] = true;
        $response['data'] = $shape;
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
            'shape' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $shape = Shape::findOrFail($id);

        $shape->update([
            'shape' => $data['shape'],
            'slug' => Str::slug($data['shape'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Sun glass shape updated successfully';
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
        $shape = Shape::findOrFail($id);
        $shape->delete();
        $response['status'] = true;
        $response['message'] = 'Sun Glass Shape deleted successfully';
        return response()->json($response, 200);
    }
}
