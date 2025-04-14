<?php

namespace App\Http\Controllers\Admin\HQ\Lens;

use App\Exports\Admin\HQ\Lenses\StocksTransfersExport;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HQ\Lenses\StoreLensTransferRequest;
use App\Models\HqLensTransfer;
use Illuminate\Support\Facades\Auth;

class HQLensTransfersController extends Controller
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
            $data = $organization->hq_lens_transfer()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('lens_code', function ($row) {
                    return $row->hq_lens->code;
                })
                ->addColumn('power', function ($row) {
                    return $row->hq_lens->power;
                })
                ->addColumn('eye', function ($row) {
                    return $row->hq_lens->eye;
                })
                ->addColumn('to_workshop', function ($row) {
                    return $row->to_workshop->name;
                })
                ->addColumn('status', function ($row) {
                    if($row->status)
                    {
                        $transfer_status = '<span class="badge badge-success">Transfered</span>';
                    }
                    else
                    {
                        $transfer_status = '<span class="badge badge-danger">Not Transfered</span>';
                    }

                    return $transfer_status;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteLensTransferBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['lens_code', 'power', 'eye', 'to_workshop', 'status', 'actions'])
                ->make(true);
        }
        $transfers = $organization->hq_lens_transfer()->latest()->get();
        $page_title = trans('admin.page.lenses.sub_page.transfers');
        return view('admin.HQ.lenses.transfers', [
            'page_title' => $page_title,
            'organization' => $organization,
            'transfers' => $transfers
        ]);
    }

    public function export()
    {
        return (new StocksTransfersExport())->download('lens-transfers-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensTransferRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $to_workshop = $organization->workshop()->findOrFail($data['to_workshop_id']);

        $lens = $organization->hq_lens()->findOrFail($data['lens_id']);

        // update hq frame stock
        $quantity = $data['quantity'];

        // check if the quantity of frames asked for is available
        if ($quantity > $lens->total) {
            $response['status'] = false;
            $response['errors'] = ["The quantity requested is not available at the moment"];
            return response()->json($response, 422);
        }

        $opening = $lens->opening;

        $purchased = $lens->purchased;

        $transfered = $lens->transfered + $quantity;

        $total = ($opening + $purchased) - $transfered;

        $lens->update([

            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        // Transfer Stock
        $organization->hq_lens_transfer()->create([

            'admin_id' => $admin->id,
            'to_workshop_id' => $to_workshop->id,
            'lens_id' => $lens->id,
            'transfered_date' => $data['transfered_date'],
            'quantity' => $data['quantity'],
            'condition' => $data['condition'],
            'status' => $data['transfer_status'],
            'remarks' => $data['remarks'],

        ]);

        // Send and email to the clinic

        $response['status'] = true;
        $response['message'] = "You have successfully transfered " . $quantity . " frames to " . $to_workshop->name;

        return response()->json($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqLensTransfer $hqLensTransfer)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $hqLensTransfer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqLensTransfer $hqLensTransfer)
    {
        //
        $lens = $hqLensTransfer->hq_lens;

        $quantity = $hqLensTransfer->quantity;

        $opening = $lens->opening;

        $purchased = $lens->purchased;

        $transfered = $lens->transfered - $quantity;

        $total = ($opening + $purchased) - $transfered;

        $lens->update([

            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total

        ]);

        $hqLensTransfer->delete();

        $response['status'] = true;
        $response['message'] = 'Lens Transfer successfully canceled';
        return response()->json($response, 200);

    }
}
