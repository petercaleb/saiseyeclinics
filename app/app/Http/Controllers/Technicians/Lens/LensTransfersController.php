<?php

namespace App\Http\Controllers\Technicians\Lens;

use App\Http\Controllers\Controller;
use App\Models\Lens;
use App\Models\LensTransfer;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LensTransfersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    public function index(Request $request)
    {
        # code...
        $technicians = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technicians->workshop;
        if ($request->ajax()) {
            $data = $workshop->lens_transfer->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('from_workshop', function($row){
                    $from_workshop = $row->workshop->name;
                    return $from_workshop;
                })
                ->addColumn('to_workshop', function($row){
                    $to_workshop = $row->to_workshop->name;
                    return $to_workshop;
                })
                ->addColumn('lens_code', function($row){
                    $lens_code = $row->lens->code;
                    return $lens_code;
                })
                ->addColumn('lens_power', function($row){
                    $lens_power = $row->lens->power;
                    return $lens_power;
                })
                ->addColumn('action', function () {
                })
                ->rawColumns(['action', 'from_workshop', 'to_workshop', 'lens_code'])
                ->make(true);
        }
    }

    public function transfer_to(Request $request)
    {
        # code...
        $technicians = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technicians->workshop;
        if($request->ajax()){
            $data = $workshop->lens_transfer_to->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('from_workshop', function($row){
                    $from_workshop = $row->workshop->name;
                    return $from_workshop;
                })
                ->addColumn('to_workshop', function($row){
                    $to_workshop = $row->to_workshop->name;
                    return $to_workshop;
                })
                ->addColumn('lens_code', function($row){
                    $lens_code = $row->lens->code;
                    return $lens_code;
                })
                ->addColumn('lens_power', function($row){
                    $lens_power = $row->lens->power;
                    return $lens_power;
                })
                ->addColumn('action', function () {
                })
                ->rawColumns(['action', 'from_workshop', 'to_workshop', 'lens_code'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'to_workshop_id' => 'required|integer|exists:workshops,id',
            'lens_id' => 'required|integer|exists:lenses,id',
            'transfer_date' => 'required|date',
            'quantity' => 'required|integer',
            'condition' => 'required|string',
            'status' => 'required|string',
            'remarks' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens = Lens::findOrFail($data['lens_id']);

        $quantity_transfer = $data['quantity'];

        if($quantity_transfer > $lens->closing) {

            $response = [
                'status' => false,
                'errors' => ["The quantity of lens you want to transfer does not exist"]
            ];

            return response()->json($response, 401);

        } 

        $opening = $lens->opening;

        $purchased = $lens->purchased;

        $transfered = $lens->transfered + $quantity_transfer;

        $total = ($opening + $purchased) - $transfered;

        $sold = $lens->sold;

        $closing = $total - $sold;

        $lens->update([
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing
        ]);


        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);

        $workshop = $technician->workshop;

        $lens_transfer = new LensTransfer;

        $lens_transfer->create([
            'organization_id' => $workshop->organization_id,
            'workshop_id' => $workshop->id,
            'technician_id' => $technician->id,
            'to_workshop_id' => $data['to_workshop_id'],
            'lens_id' => $data['lens_id'],
            'transfered_date' => $data['transfer_date'],
            'quantity' => $quantity_transfer,
            'condition' => $data['condition'],
            'status' => $data['status'],
            'remarks' => $data['remarks'],
        ]);

        $response = [
            'status' => true,
            'message' => 'You successfully made a transfer'
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        # code...
    }

    public function destroy($id)
    {
        # code...
    }
}
