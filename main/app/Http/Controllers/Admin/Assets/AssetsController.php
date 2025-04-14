<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\AssetType;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            $data = Asset::join('asset_types', 'assets.type_id', '=', 'asset_types.id')
                ->join('asset_conditions', 'assets.condition_id', '=', 'asset_conditions.id')
                ->select('assets.*', 'asset_types.title as type', 'asset_conditions.title as condition')
                ->where('assets.clinic_id','=',$clinic->id)
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-tools btn-sm editItem"><i class="fa fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Transfer" class="btn btn-tools btn-sm transferItemBtn"><i class="fa fa-exchange"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-tools btn-sm deleteItem"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $organization = $clinic->organization;
        $asset_types = $organization->asset_type->sortBy('created_at', SORT_DESC);
        $asset_conditions = $organization->asset_condition->sortBy('created_at', SORT_DESC);
        $org_clinics = Clinic::where('organization_id', $organization->id)->where('id', '!=', $clinic->id)->latest()->get();
        $page_title = 'Assets';
        return view('admin.assets.clinic.index', [
            'clinic' => $clinic,
            'patients' => $patients,
            'asset_types' => $asset_types,
            'asset_conditions' => $asset_conditions,
            'org_clinics' => $org_clinics,
            'page_title' => $page_title,
        ]);
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'clinic_id' => 'required|integer|exists:clinics,id',
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

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $asset_type = AssetType::findOrFail($data['type_id']);

        $asset_condition = AssetCondition::findOrFail($data['condition_id']);

        $clinic->asset()->create([
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

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:assets,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset = Asset::findOrFail($data['asset_id']);

        $response['status'] = true;
        $response['data'] = $asset;
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:assets,id',
            'clinic_id' => 'required|integer|exists:clinics,id',
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

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $asset_type = AssetType::findOrFail($data['type_id']);

        $asset_condition = AssetCondition::findOrFail($data['condition_id']);

        $asset = $clinic->asset->find($data['asset_id']);

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

    public function destroy(Request $request)
    {
        # code...
        $data = $request->all();
        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:assets,id',
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }
        $asset = Asset::findOrFail($data['asset_id']);
        $asset->delete();
        $response['status'] = true;
        $response['message'] = 'Asset successfully deleted';
        return response()->json($response, 200);
    }
}
