<?php

namespace App\Http\Controllers\Admin\HQ\Lens;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\HQ\Lenses\StoreLensPurchaseRequest;
use App\Models\HqLensPurchase;
use Illuminate\Support\Facades\Auth;

class HQLensPurchasesController extends Controller
{

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
            $data = $organization->hq_lens_purchase()->latest()->get();
            return datatables()->of($data)
                ->addColumn('lens_code', function ($row) {
                    $lens_code = $row->hq_lens->code;
                    return $lens_code;
                })
                ->addColumn('power', function ($row) {
                    $power = $row->hq_lens->power;
                    return $power;
                })
                ->addColumn('vendor', function ($row) {
                    # code...
                    $vendor = $row->vendor->first_name . ' ' . $row->vendor->last_name;
                    return $vendor;
                })
                ->addColumn('receipt', function ($row) {
                    $receipt = '<a href="" target="_blank" class="btn btn-tools btn-sm">' . $row->attachment . '</a>';
                    return $receipt;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-tools btn-sm deleteLensPurchaseBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })

                ->rawColumns(['actions', 'lens_code', 'power', 'vendor', 'receipt'])
                ->make(true);
        }
        $purchases = $organization->hq_lens_purchase()->latest()->get();
        $page_title = trans('admin.page.lenses.sub_page.purchases');
        return view('admin.HQ.lenses.purchase', [
            'organization' => $organization,
            'purchases' => $purchases,
            'page_title' => $page_title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensPurchaseRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $lens = $organization->hq_lens()->findOrFail($data['lens_id']);

        $opening = $lens->opening;

        $purchased = $lens->purchased + $data['quantity'];

        $transfered = $lens->transfered;

        $total = ($opening + $purchased) - $transfered;

        $lens->update([
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        $quantity = $data['quantity'];

        $price = $data['price'];

        $total_price = $quantity * $price;

        $lens_purchase = new HqLensPurchase();

        $lens_purchase->organization_id = $organization->id;
        $lens_purchase->admin_id = $admin->id;
        $lens_purchase->lens_id = $lens->id;
        $lens_purchase->vendor_id = $data['vendor_id'];
        $lens_purchase->receipt_number =  $data['receipt_number'];
        $lens_purchase->purchased_date = $data['purchase_date'];
        $lens_purchase->quantity = $quantity;
        $lens_purchase->price = $price;
        $lens_purchase->total_price = $total_price;
        if ($request->hasFile('attachment')) {
            $storagePath = 'public/lens_purchases';
            $fileName = 'attachment';
            $lens_purchase->attachment = $this->uploadFile($request, $fileName, $storagePath);
        }

        $lens_purchase->save();

        $response = [
            'status' => true,
            'message' => 'You have successfully added a new lens purchase'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqLensPurchase $hqLensPurchase)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $hqLensPurchase
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqLensPurchase $hqLensPurchase)
    {
        //
        //
        $lens = $hqLensPurchase->hq_lens;

        // purchased stocks 
        $purchased = $lens->purchased;

        // quantity to delete
        $quantity = $hqLensPurchase->quantity;

        // remove the quantity from total purchased
        $remaining = $purchased - $quantity;

        // update stock 
        $opening = $lens->opening;

        $new_purchased = $remaining;

        $transfered = $lens->transfered;

        $total = ($opening + $new_purchased) - $transfered;

        $lens->update([
            'opening' => $opening,
            'purchased' => $new_purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        $hqLensPurchase->delete();

        $response['status'] = true;
        $response['message'] = 'Lens Purchase Deleted Successfully';
        return response()->json($response, 200);
    }
}
