<?php

namespace App\Http\Controllers\Admin\HQ\Frames;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\HqFrameTransfer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\HQ\Frames\StoreFrameTransferRequest;
use App\Mail\HQ\Frames\TransferMail;

class HQFrameTransfersController extends Controller
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
            $data = $organization->hq_frame_transfer()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('admin', function ($row) {
                    $admin = $row->admin->first_name . ' ' . $row->admin->last_name;
                    return $admin;
                })
                ->addColumn('to_clinic', function ($row) {
                    $to_clinic = $row->to_clinic->clinic;
                    return $to_clinic;
                })
                ->addColumn('status', function ($row) {
                    if ($row->transfer_status) {
                        return '<span class="badge badge-success">Transfered</span>';
                    } else {
                        return '<span class="badge badge-danger">Not Transfered</span>';
                    }
                })
                ->addColumn('received', function ($row) {
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-danger">Not Received</span>';
                    }
                })
                ->addColumn('actions', function ($row) {
                    if (!$row->received_status) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteFrameTransferBtn">';
                        $btn = $btn . '<i class="fa fa-trash"></i></a>';
                        return $btn;
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['admin', 'status', 'received', 'to_clinic', 'actions'])
                ->make(true);
        }
        $transfers = $organization->hq_frame_transfer()->latest()->get();
        $page_title = trans('admin.page.frames.sub_page.transfers');
        return view('admin.HQ.Frames.transfered', [
            'organization' => $organization,
            'transfers' => $transfers,
            'page_title' => $page_title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrameTransferRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $to_clinic = $organization->clinic()->findOrFail($data['to_clinic_id']);

        $frame_stock = $organization->hq_frame_stock()->findOrFail($data['stock_id']);

        // update hq frame stock 
        $quantity = $data['quantity'];

        // check if the quantity of frames asked for is available 
        if ($quantity > $frame_stock->total) {
            $response['status'] = false;
            $response['errors'] = ["The quantity requested is not available at the moment"];
            return response()->json($response, 422);
        }

        $opening = $frame_stock->opening;

        $purchased = $frame_stock->purchased;

        $transfered = $frame_stock->transfered + $quantity;

        $total = ($opening + $purchased) - $transfered;

        // Transfer Stock
        $organization->hq_frame_transfer()->create([

            'admin_id' => $admin->id,
            'to_clinic_id' => $to_clinic->id,
            'stock_id' => $frame_stock->id,
            'frame_code' => $frame_stock->frame->code,
            'transfer_date' => $data['transfer_date'],
            'quantity' => $data['quantity'],
            'transfer_status' => $data['transfer_status'],
            'condition' => $data['condition'],
            'remarks' => $data['remarks'],

        ]);

        $frame_stock->update([

            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        // Send and email to the clinic
        $email = $to_clinic->email;
        $details = [
            'title' => 'Transfer Frames',
            'body' => 'We have transfered ' . $quantity . ' frames from ' . $organization->organization
        ];

        Mail::to($email)->send(new TransferMail($details));

        $response['status'] = true;
        $response['message'] = "You have successfully transfered " . $quantity . " frames to " . $to_clinic->clinic;

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqFrameTransfer $hqFrameTransfer)
    {
        //
        $response = [
            'status' => true,
            'data' => $hqFrameTransfer
        ];

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqFrameTransfer $hqFrameTransfer)
    {
        //

        $frame_stock = $hqFrameTransfer->hq_frame_stock;

        $quantity = $hqFrameTransfer->quantity;

        $opening = $frame_stock->opening;

        $purchased = $frame_stock->purchased;

        $transfered = $frame_stock->transfered - $quantity;

        $total = ($opening + $purchased) - $transfered;

        $frame_stock->update([

            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total

        ]);

        $hqFrameTransfer->delete();

        $response['status'] = true;
        $response['message'] = 'Frame Transfer successfully deleted';
        return response()->json($response, 200);
    }
}
