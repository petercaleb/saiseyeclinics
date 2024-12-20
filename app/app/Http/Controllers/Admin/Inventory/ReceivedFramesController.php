<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\FrameStock;
use App\Models\FrameTransfer;
use App\Models\ReceivedFrame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceivedFramesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        if($request->ajax())
        {
            $data = $clinic->frame_received_to()->latest()->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('received_date', function($row){
                return date('d, F, Y', strtotime($row->received_date));
            })
            ->addColumn('from_clinic', function($row){
                $from_clinic = $row->from_clinic->clinic;
                return $from_clinic;
            })
            ->addColumn('to_clinic', function($row){
                $to_clinic = $row->to_clinic->clinic;
                return $to_clinic;
            })
            ->addColumn('send_by', function($row){
                return $row->transfer_user->first_name . ' ' . $row->transfer_user->last_name;
            })
            ->addColumn('received_by', function($row){
                return $row->received_user->first_name . ' ' . $row->received_user->last_name;
            })
            ->rawColumns(['received_date', 'from_clinic', 'to_clinic', 'send_by', 'received_by'])
            ->make(true);
        }
    }

    /**
     * check if there are stocks send to this clinic
     *
     * @return \Illuminate\Http\Response
     */
    public function check_stock_transfered($id)
    {
        //
        $clinic = Clinic::findOrFail($id);

        //check if stock has been transfered to current clinic
        $transfered_stocks = $clinic->frame_transfer_to()->count();

        if($transfered_stocks <= 0)
        {
            $response['status'] = false;
            $response['errors'] = ['There are no frames transfered to this clinic yet'];
            return response()->json($response, 401);
        }

        $response = [
            'status' => true
        ];

        return response()->json($response, 200);
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
            'transfer_id' => 'required|integer|exists:frame_transfers,id',
            'received_date' => 'required|date',
            'received_status' => 'required|string',
            'condition' => 'required|string|max:255',
            'remarks' => 'nullable',
            'received_user_id' => 'required|integer|exists:users,id'
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame_transfer = FrameTransfer::findOrFail($data['transfer_id']);

        $check_frame_received = ReceivedFrame::where('transfer_id', $frame_transfer->id)->latest()->first();

        if($check_frame_received)
        {
            $errors = ['The Curent frame has already been received and updated'];
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        // deal with frame stocks on current clinic
        


        $frame_stock = FrameStock::findOrFail($frame_transfer->stock_id);
        // update stocks 
        $quantity = $frame_transfer->quantity;

        // received stocks 
        $received = $frame_stock->received_stock + $quantity;

        //Total Stock 
        $total = $frame_stock->total_stock + $received;

        //Sold
        $sold = $frame_stock->sold_stock;

        // closing 
        $closing = $total - $sold;

        $frame_stock->update([
            'received_stock' => $received,
            'total_stock' => $total,
            'sold_stock' => $sold,
            'closing_stock' => $closing
        ]);

        // create received
        $received_frame = new ReceivedFrame();

        $received_frame->organization_id = $frame_transfer->organization_id;
        $received_frame->from_clinic_id = $frame_transfer->from_clinic_id;
        $received_frame->to_clinic_id = $frame_transfer->to_clinic_id;
        $received_frame->stock_id = $frame_transfer->stock_id;
        $received_frame->transfer_id = $frame_transfer->id;
        $received_frame->transfer_user_id = $frame_transfer->transfer_user_id ;
        $received_frame->received_user_id = $data['received_user_id'];
        $received_frame->received_date = $data['received_date'];
        $received_frame->frame_code = $frame_transfer->frame_code;
        $received_frame->quantity = $quantity;
        $received_frame->received_status = $data['received_status'];
        $received_frame->condition = $data['condition'];
        $received_frame->remarks = $data['remarks'];

        $received_frame->save();

        $from_clinic = Clinic::findOrFail($frame_transfer->from_clinic_id);

        $response['status'] = true;
        $response['message'] = "You have successfully received " . $quantity . " frames from " . $from_clinic->clinic;

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
