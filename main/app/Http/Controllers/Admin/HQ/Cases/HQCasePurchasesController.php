<?php

namespace App\Http\Controllers\Admin\HQ\Cases;

use App\Exports\Admin\HQ\Cases\StocksPurchaseExport;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\HQ\Cases\StoreCasePurchaseRequest;
use App\Models\HqCasePurchase;

class HQCasePurchasesController extends Controller
{

    //
    use FileUploadTrait;

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
            $data = $organization->hq_case_purchase()->latest()->get();
            return datatables()->of($data)
                ->addColumn('case_code', function ($row) {
                    return $row->frame_case->code;
                })
                ->addColumn('color', function ($row) {
                    return $row->frame_case->case_color->title;
                })
                ->addColumn('shape', function ($row) {
                    return $row->frame_case->case_shape->title;
                })

                ->addColumn('size', function ($row) {
                    return $row->frame_case->case_size->title;
                })

                ->addColumn('receipt', function ($row) {
                    return '<a href="'. route('admin.hq.cases.purchases.attachment', $row->id) .'" target="_blank" class="btn btn-tools btn-sm">' . $row->attachment . '</a>';
                })
                ->addColumn('supplier', function ($row) {
                    return $row->vendor->first_name . ' ' . $row->vendor->last_name;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteCasePurchaseBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['case_code', 'color', 'shape', 'size', 'receipt', 'supplier', 'actions'])
                ->make(true);
        }
        $org_purchases = $organization->hq_case_purchase()->latest()->get();
        $page_title = trans('admin.page.cases.sub_page.purchases');
        return view('admin.HQ.cases.purchased', [
            'organization' => $organization,
            'purchases' => $org_purchases,
            'page_title' => $page_title
        ]);
    }


    public function export()
    {
        return (new StocksPurchaseExport())->download('case-purchases-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCasePurchaseRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        //1. Get Stock
        $case_stock = $organization->hq_case_stock()->findOrFail($data['stock_id']);

        $opening =  $case_stock->opening;

        $purchased = $case_stock->purchased + $data['quantity'];

        $transfered = $case_stock->transfered;

        $total = ($opening + $purchased) - $transfered;

        // Craeate a purchase
        // upload receipt
        if ($request->hasFile('attachment')) {
            $storagePath = 'public/case_purchases';
            $fileName = 'attachment';
            $caseAttachment = $this->uploadFile($request, $fileName, $storagePath);
        } else {
            $caseAttachment = null;
        }

        $organization->hq_case_purchase()->create([

            'admin_id' => $admin->id,
            'stock_id' => $case_stock->id,
            'case_id' => $case_stock->case_id,
            'receipt_number' => $data['receipt_number'],
            'purchase_date' => $data['purchase_date'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'total' => $data['quantity'] * $data['price'],
            'vendor_id' => $data['vendor_id'],
            'attachment' => $caseAttachment,
        ]);

        // update stock
        $case_stock->update([
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total,
        ]);

        $response['status'] = true;
        $response['message'] = 'Successfully stored case purchase record';

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqCasePurchase $hqCasePurchase)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $hqCasePurchase
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachment(HqCasePurchase $hqCasePurchase)
    {
        //
        $file = $hqCasePurchase->attachment;
        $storage_path = 'case_purchases';
        return $this->openFile($file, $storage_path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqCasePurchase $hqCasePurchase)
    {
        //
        //
        $case_stock = $hqCasePurchase->hq_case_stock;

        // purchased stocks
        $purchased = $case_stock->purchased;

        // quantity to delete
        $quantity = $hqCasePurchase->quantity;

        // remove the quantity from total purchased
        $remaining = $purchased - $quantity;

        // update stock
        $opening = $case_stock->opening;

        $new_purchased = $remaining;

        $transfered = $case_stock->transfered;

        $total = ($opening + $new_purchased) - $transfered;

        $case_stock->update([
            'opening' => $opening,
            'purchased' => $new_purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        $hqCasePurchase->delete();

        $response['status'] = true;
        $response['message'] = 'Case Purchase Deleted Successfully';
        return response()->json($response, 200);
    }
}
