<?php

namespace App\Http\Controllers\Technicians\Assets;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferedAssetsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    public function index(Request $request)
    {
        # code...
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            $data = $workshop->to_workshop_transfer_asset->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('asset', function ($row) {
                    $asset = $row->asset->asset;
                    return $asset;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->asset_type->title;
                    return $type;
                })
                ->addColumn('condition', function ($row) {
                    $condition = $row->asset_condition->title;
                    return $condition;
                })
                ->addColumn('serial_number', function ($row) {
                    $serial_number = $row->asset->serial_number;
                    return $serial_number;
                })
                ->addColumn('from_workshop', function($row){
                    $from_workshop = $row->from_workshop->name;
                    return $from_workshop;
                })
                ->rawColumns(['asset', 'type', 'condtion', 'serial_number', 'from_workshop'])
                ->make(true);
        }
        $num_transfered_to = $workshop->to_workshop_transfer_asset->count();
        $num_transfered_from = $workshop->from_workshop_transfer_asset->count();
        $page_title = "Transfered Assets";
        return view('technicians.transfered_assets.index', [
            'page_title' => $page_title,
            'num_transfered_to' => $num_transfered_to,
            'num_transfered_from' => $num_transfered_from,
        ]);
    }


    public function transfer_from(Request $request)
    {
        # code...
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            $data = $workshop->from_workshop_transfer_asset->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('asset', function ($row) {
                    $asset = $row->asset->asset;
                    return $asset;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->asset_type->title;
                    return $type;
                })
                ->addColumn('condition', function ($row) {
                    $condition = $row->asset_condition->title;
                    return $condition;
                })
                ->addColumn('serial_number', function ($row) {
                    $serial_number = $row->asset->serial_number;
                    return $serial_number;
                })
                ->addColumn('to_workshop', function($row){
                    $to_workshop = $row->to_workshop->name;
                    return $to_workshop;
                })
                ->rawColumns(['asset', 'type', 'condtion', 'serial_number', 'to_workshop'])
                ->make(true);
        }
    }
}
