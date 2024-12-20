<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use App\Models\AssetCondition;
use App\Models\AssetType;
use App\Models\Workshop;
use App\Models\WorkshopAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkshopAssetsController extends Controller
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
    public function index(Request $request, $id)
    {
        //
        $workshop = Workshop::findOrFail($id);
        if ($request->ajax()) {
            $data = $workshop->workshop_asset->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    $type = $row->asset_type->title;
                    return $type;
                })
                ->addColumn('condition', function ($row) {
                    $condition = $row->asset_condition->title;
                    return $condition;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-tools btn-sm updateItemBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Transfer" class="btn btn-tools btn-sm transferItemBtn"><i class="fa fa-exchange"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-tools btn-sm deleteItemBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $organization = $workshop->organization;
        $asset_types = $organization->asset_type->sortBy('created_at', SORT_DESC);
        $asset_conditions = $organization->asset_condition->sortBy('created_at', SORT_DESC);
        $org_workshops = $organization->workshop->where('id', '!=', $workshop->id)->sortBy('created_at', SORT_DESC);
        $page_title = "Workshop Assets";
        return view('admin.assets.workshop.index', [
            'page_title' => $page_title,
            'workshop' => $workshop,
            'asset_types' => $asset_types,
            'asset_conditions' => $asset_conditions,
            'org_workshops' => $org_workshops,
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
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'workshop_id' => 'required|integer|exists:workshops,id',
            'asset' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:asset_types,id',
            'condition_id' => 'required|integer|exists:asset_conditions,id',
            'serial_number' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $workshop = Workshop::findOrFail($data['workshop_id']);

        $organization = $workshop->organization;

        $asset_type = AssetType::findOrFail($data['type_id']);

        $asset_condition = AssetCondition::findOrFail($data['condition_id']);

        $workshop->workshop_asset()->create([
            'organization_id' => $organization->id,
            'asset' => $data['asset'],
            'type_id' => $asset_type->id,
            'condition_id' => $asset_condition->id,
            'serial_number' => $data['serial_number'],
            'quantity' => $data['quantity'],
            'description' => $data['description'],
            'purchase_date' => $data['purchase_date'],
            'purchase_cost' => $data['purchase_cost'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Asset successfully added';

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
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:workshop_assets,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset = WorkshopAsset::findOrFail($data['asset_id']);

        $response = [
            'status' => true,
            'data' => $asset
        ];

        return response()->json($response);
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
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:workshop_assets,id',
            'workshop_id' => 'required|integer|exists:workshops,id',
            'asset' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:asset_types,id',
            'condition_id' => 'required|integer|exists:asset_conditions,id',
            'serial_number' => 'nullable|string|max:255',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'purchase_date' => 'required|date',
            'purchase_cost' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $workshop = Workshop::findOrFail($data['workshop_id']);

        $asset_type = AssetType::findOrFail($data['type_id']);

        $asset_condition = AssetCondition::findOrFail($data['condition_id']);

        $asset = $workshop->workshop_asset->find($data['asset_id']);

        $asset->update([
            'asset' => $data['asset'],
            'type_id' => $asset_type->id,
            'condition_id' => $asset_condition->id,
            'serial_number' => $data['serial_number'],
            'quantity' => $data['quantity'],
            'description' => $data['description'],
            'purchase_date' => $data['purchase_date'],
            'purchase_cost' => $data['purchase_cost'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Asset successfully updated';

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
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:workshop_assets,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset = WorkshopAsset::findOrFail($data['asset_id']);

        $asset->delete();
        
        $response['status'] = true;
        $response['message'] = 'Asset successfully deleted';
        return response()->json($response, 200);
    }
}
