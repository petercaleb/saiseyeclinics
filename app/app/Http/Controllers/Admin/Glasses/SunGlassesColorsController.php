<?php

namespace App\Http\Controllers\Admin\Glasses;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SunGlassesColorsController extends Controller
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
            $data = $organization->color->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-tools btn-sm updateGlassColorBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-tools btn-sm deleteGlassColorBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Frame Colors';
        return view('admin.settings.clinics.glasses.colors.index', [
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

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $organization->color()->create([
            'color' => $data['color'],
            'slug' => Str::slug($data['color'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Sun Glass Color created successfully';
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
            'color_id' => 'required|integer|exists:colors,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame_color = Color::findOrFail($data['color_id']);

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

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $color = Color::findOrFail($id);

        $color->update([
            'color' => $data['color'],
            'slug' => Str::slug($data['color'].'-'.time()),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Sun Glass Color updated successfully';
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
        $color = Color::findOrFail($id);
        $color->delete();
        $response['status'] = true;
        $response['message'] = 'Sun Glass Color deleted successfully';
        return response()->json($response, 200);
    }
}
