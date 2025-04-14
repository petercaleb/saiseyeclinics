<?php

namespace App\Http\Controllers\Admin\HQ\Cases;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\HqCaseTransfer;
use App\Http\Controllers\Controller;
use App\Mail\HQ\Frames\TransferMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\HQ\Cases\StoreCaseStockRequest;
use App\Http\Requests\Admin\HQ\Cases\StoreCaseTransferRequest;

class HQCaseTransfersController extends Controller
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
            $data = $organization->hq_case_transfer()->where('to_clinic_id', '!=', null)->where('to_workshop_id', '=', null)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('case_code', function ($row) {
                    $case_code = $row->hq_stock->frame_case->code;
                    return $case_code;
                })
                ->addColumn('admin', function ($row) {
                    $admin = $row->admin->first_name . ' ' . $row->admin->last_name;
                    return $admin;
                })
                ->addColumn('to_clinic', function ($row) {
                    if ($row->to_clinic_id != null) {
                        $to_clinic = $row->to_clinic->clinic;
                    } else {
                        $to_clinic = '';
                    }
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
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteCaseTransferBtn">';
                        $btn = $btn . '<i class="fa fa-trash"></i></a>';
                        return $btn;
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['case_code', 'admin', 'status', 'received', 'to_clinic', 'actions'])
                ->make(true);
        }
        $clinic_transfers = $organization->hq_case_transfer()->where('to_clinic_id', '!=', null)->where('to_workshop_id', '=', null)->latest()->get();
        $workshop_transfers = $organization->hq_case_transfer()->where('to_clinic_id', '=', null)->where('to_workshop_id', '!=', null)->latest()->get();
        $page_title = trans('admin.page.cases.sub_page.transfers');
        return view('admin.HQ.cases.transfer', [
            'page_title' => $page_title,
            'clinic_transfers' => $clinic_transfers,
            'workshop_transfers' => $workshop_transfers,
            'organization' => $organization
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_for_workshops(Request $request)
    {
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->hq_case_transfer()->where('to_clinic_id', '=', null)->where('to_workshop_id', '!=', null)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('case_code', function ($row) {
                    $case_code = $row->hq_stock->frame_case->code;
                    return $case_code;
                })
                ->addColumn('admin', function ($row) {
                    $admin = $row->admin->first_name . ' ' . $row->admin->last_name;
                    return $admin;
                })
                ->addColumn('to_workshop', function ($row) {
                    if ($row->to_workshop_id != null) {
                        $to_workshop = $row->to_workshop->name;
                    } else {
                        $to_workshop = '';
                    }
                    return $to_workshop;
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
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteCaseTransferBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['case_code', 'admin', 'status', 'received', 'to_clinic', 'actions'])
                ->make(true);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaseTransferRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $to_clinic = null;

        $to_workshop = null;
        $clinic_id = null;
        if (isset($data['to_clinic_id'])) {
            $to_clinic = $organization->clinic()->findOrFail($data['to_clinic_id']);
            $clinic_id = $to_clinic->id;
        }

        $workshop_id = null;
        if (isset($data['to_workshop_id'])) {
            $to_workshop = $organization->workshop()->findOrFail($data['to_workshop_id']);
            $workshop_id = $to_workshop->id;
        }

        $case_stock = $organization->hq_case_stock()->findOrFail($data['stock_id']);

        // update hq frame stock 
        $quantity = $data['quantity'];

        // check if the quantity of frames asked for is available 
        if ($quantity > $case_stock->total) {
            $response['status'] = false;
            $response['errors'] = ["The quantity requested is not available at the moment"];
            return response()->json($response, 422);
        }

        $opening = $case_stock->opening;

        $purchased = $case_stock->purchased;

        $transfered = $case_stock->transfered + $quantity;

        $total = ($opening + $purchased) - $transfered;

        $organization->hq_case_transfer()->create([

            'admin_id' => $admin->id,
            'to_clinic_id' => $clinic_id,
            'to_workshop_id' => $workshop_id,
            'stock_id' => $case_stock->id,
            'case_id' => $case_stock->frame_case->id,
            'transfer_date' => $data['transfer_date'],
            'quantity' => $quantity,
            'transfer_status' => $data['transfer_status'],
            'condition' => $data['condition'],
            'remarks' => $data['remarks'],

        ]);

        $case_stock->update([
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        // Send and email to the clinic
        if ($clinic_id != null) {
            $email = $to_clinic->email;
            $details = [
                'title' => 'Transfer Cases',
                'body' => 'We have transfered ' . $quantity . ' cases from ' . $organization->organization
            ];

            Mail::to($email)->send(new TransferMail($details));
        }




        $response['status'] = true;
        $response['message'] = "Case Stock Transfered Successfully";
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqCaseTransfer $hqCaseTransfer)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $hqCaseTransfer
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqCaseTransfer $hqCaseTransfer)
    {
        //
        $case_stock = $hqCaseTransfer->hq_stock;

        $quantity = $hqCaseTransfer->quantity;

        $opening = $case_stock->opening;

        $purchased = $case_stock->purchased;

        $transfered = $case_stock->transfered - $quantity;

        $total = ($opening + $purchased) - $transfered;

        $case_stock->update([
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        $hqCaseTransfer->delete();

        $response['status'] = true;
        $response['message'] = 'Case transfer successfully deleted';
        return response()->json($response, 200);
    }
}
