<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use App\Models\WorkshopAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkshopAssetTransferController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request, $id)
    {
        # code...
        $workshop = Workshop::findOrFail($id);
        if ($request->ajax()) {
            $data = $workshop->from_workshop_transfer_asset->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('asset', function ($row) {
                    $asset = $row->asset->asset;
                    return $asset;
                })
                ->addColumn('transfer_to', function ($row) {
                    $transfer_to = $row->to_workshop->name;
                    return $transfer_to;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->asset_type->title;
                    return $type;
                })
                ->addColumn('condition', function ($row) {
                    $condition = $row->asset_condition->title;
                    return $condition;
                })
                ->rawColumns(['asset', 'transfer_to', 'type', 'condition'])
                ->make(true);
        }
        $page_title = "Workshop Asset Transfer";
        return view('admin.transfered_assets.workshops.index', [
            'page_title' => $page_title,
            'workshop' => $workshop,
        ]);
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'asset_id' => 'required|integer|exists:workshop_assets,id',
            'from_workshop_id' => 'required|integer|exists:workshops,id',
            'to_workshop_id' => 'required|integer|exists:workshops,id',
            'transfer_date' => 'required|date',
            'condition_id' => 'required|integer|exists:asset_conditions,id',
            'quantity' => 'required|numeric',
            'remarks' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset = WorkshopAsset::findOrFail($data['asset_id']);

        $from_workshop = Workshop::findOrFail($data['from_workshop_id']);

        $to_workshop = Workshop::findOrFail($data['to_workshop_id']);

        $qty = $data['quantity'];

        if ($asset->quantity <= 0 || $qty > $asset->quantity) {
            $errors = ['The quantity of assets you are looking to transfer are not available. Please check and try again..'];
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $asset_quantity = $asset->quantity - $qty;

        $asset->update([

            'quantity' => $asset_quantity

        ]);

        $to_workshop->workshop_asset()->create([
            'organization_id' => $to_workshop->organization->id,
            'asset' => $asset->asset,
            'type_id' => $asset->type_id,
            'condition_id' => $data['condition_id'],
            'serial_number' => $asset->serial_number,
            'quantity' => $data['quantity'],
            'description' => $asset->description,
            'purchase_date' => $asset->purchase_date,
            'purchase_cost' => $asset->purchase_cost,
        ]);

        $asset->workshop_transfer_asset()->create([
            'organization_id' => $to_workshop->organization->id,
            'from_workshop_id' => $from_workshop->id,
            'to_workshop_id' => $to_workshop->id,
            'transfer_date' => $data['transfer_date'],
            'type_id' => $asset->asset_type->id,
            'condition_id' => $asset->asset_condition->id,
            'quantity' => $data['quantity'],
            'remarks' => $data['remarks'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Asset successfully transferred';

        return response()->json($response, 200);
    }

    public function show(Request $request)
    {
        # code...
    }
}
