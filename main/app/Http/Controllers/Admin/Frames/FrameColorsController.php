<?php

namespace App\Http\Controllers\Admin\Frames;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\FrameColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FrameColorsController extends Controller
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
            $data = $organization->frame_color->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-tools btn-sm editFrameColor"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-tools btn-sm deleteFrameColor"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Frame Colors';
        return view('admin.settings.clinics.frames.colors.index', [
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
            'color' => 'required|string|max:255',
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
        $organization->frame_color()->create([
            'color' => $data['color'],
            'slug' => Str::slug($data['color'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Frame Color created successfully';
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
            'color_id' => 'required|integer|exists:frame_colors,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame_color = FrameColor::findOrFail($data['color_id']);

        $response['status'] = true;
        $response['data'] = $frame_color;
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
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame_color = FrameColor::findOrFail($id);

        $frame_color->update([
            'color' => $data['color'],
            'slug' => Str::slug($data['color'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Frame Color updated successfully';
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
        $frame_color = FrameColor::findOrFail($id);
        $frame_color->delete();
        $response['status'] = true;
        $response['message'] = 'Frame Color deleted successfully';
        return response()->json($response, 200);
    }
}
