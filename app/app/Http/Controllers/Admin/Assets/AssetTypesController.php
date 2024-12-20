<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssetTypesController extends Controller
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
            $data = $organization->asset_type->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-tools btn-sm editAssetType"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-tools btn-sm deleteAssetType"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Asset Type';
        return view('admin.settings.clinics.assets.type.index', [
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
            'title' => 'required|string|max:255',
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
        $organization->asset_type()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Asset Type created successfully';
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
            'type_id' => 'required|integer|exists:client_types,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset_type = AssetType::findOrFail($data['type_id']);

        $response['status'] = true;
        $response['data'] = $asset_type;
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset_type = AssetType::findOrFail($id);
        $asset_type->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
        ]);
        $response['status'] = true;
        $response['message'] = 'Asset Type updated successfully';
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
        $asset_type = AssetType::findOrFail($id);
        $asset_type->delete();
        $response['status'] = true;
        $response['message'] = 'Asset Type deleted successfully';
        return response()->json($response, 200);
    }
}
