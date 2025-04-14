<?php

namespace App\Http\Controllers\Technicians\Lens;

use App\Http\Controllers\Controller;
use App\Models\Lens;
use App\Models\LensPurchase;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LensPurchaseController extends Controller
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
            $data = $workshop->lens_purchase->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('lens_code', function($row){
                    $lens_code = $row->lens->code;
                    return $lens_code;
                })
                ->addColumn('power', function($row){
                    $power = $row->lens->power;
                    return $power;
                })
                ->addColumn('vendor', function($row)
                {
                    # code...
                    $vendor = $row->vendor->first_name . ' ' . $row->vendor->last_name;
                    return $vendor;
                })
                ->rawColumns(['lens_code', 'power', 'vendor'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'lens_id' => 'required|integer|exists:lenses,id',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'purchased_date' => 'required|date',
            'quantity' => 'required|integer',
            'price' => 'required',
            'received_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens = Lens::findOrFail($data['lens_id']);

        $opening = $lens->opening;

        $purchased = $lens->purchased + $data['quantity'];

        $transfered = $lens->transfered;

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

        $quantity = $data['quantity'];

        $price = $data['price'];

        $total_price = $quantity * $price;

        $lens_purchase = new LensPurchase();

        $lens_purchase->create([
            'organization_id' => $lens->organization->id,
            'workshop_id' => $lens->workshop->id,
            'lens_id' => $lens->id,
            'vendor_id' => $data['vendor_id'],
            'purchased_date' => $data['purchased_date'],
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $total_price,
            'received_date' => $data['received_date']
        ]);

        $response = [
            'status' => true,
            'message' => 'You have successfully added new lens purchase'
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        # code...
    }

    public function update(Request $request, $id)
    {
        # code...
    }

    public function destroy($id)
    {
        # code...
        $lens_purchase = LensPurchase::findOrFail($id);
        $lens = Lens::findOrFail($lens_purchase->lens_id);
        $quantity = $lens_purchase->quantity;
        $opening = $lens->opening;
        $purchased = $lens->purchased - $quantity;
        $transfered = $lens->transfered;
        $total = ($opening + $purchased) - $transfered;
        $sold = $lens->sold;
        $closing  = $total - $sold;
        $lens->update([
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing
        ]);
        $lens_purchase->delete();

        $response['status'] = true;
        $response['message'] = "You have successfully removed lens purchase";

        return response()->json($response, 200);

    }
}
