<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetTransferController extends Controller
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
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            $data = $clinic->from_asset_transfer->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('asset', function($row){
                    $asset = $row->asset->asset;
                    return $asset;
                })
                ->addColumn('transfer_to', function($row){
                    $transfer_to = $row->to_clinic->clinic;
                    return $transfer_to;
                })
                ->addColumn('type', function($row){
                    $type = $row->asset_type->title;
                    return $type;
                })
                ->addColumn('condition', function($row){
                    $condition = $row->asset_condition->title;
                    return $condition;
                })
                ->rawColumns(['asset', 'transfer_to', 'type', 'condition'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $page_title = 'Transfered Asset';
        return view('admin.transfered_assets.clinics.index', [
            'clinic' => $clinic,
            'patients' => $patients,
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
            'asset_id' => 'required|integer|exists:assets,id',
            'from_clinic_id' => 'required|integer|exists:clinics,id',
            'to_clinic_id' => 'required|integer|exists:clinics,id',
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

        $asset = Asset::findOrFail($data['asset_id']);

        $from_clinic = Clinic::findOrFail($data['from_clinic_id']);

        $to_clinic = Clinic::findOrFail($data['to_clinic_id']);

        $asset_quantity = $asset->quantity - $data['quantity'];

        // update current asset
        $asset->update([
            'quantity' => $asset_quantity
        ]);

        // create new asset
        $to_clinic->asset()->create([
            'asset' => $asset->asset,
            'type_id' => $asset->type_id,
            'condition_id' => $data['condition_id'],
            'serial_number' => $asset->serial_number,
            'quantity' => $data['quantity'],
            'description' => $asset->description,
            'purchase_date' => $asset->purchase_date,
            'purchase_cost' => $asset->purchase_cost,
        ]);

        // transfer asset
        $asset->asset_transfer()->create([
            'organization_id' => $asset->clinic->organization->id,
            'from_clinic_id' => $from_clinic->id,
            'to_clinic_id' => $to_clinic->id,
            'transfer_date' => $data['transfer_date'],
            'type_id' => $asset->type_id,
            'condition_id' => $data['condition_id'],
            'quantity' => $data['quantity'],
            'remarks' => $data['remarks'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Asset successfully transferred';

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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
