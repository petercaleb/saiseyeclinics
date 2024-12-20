<?php

namespace App\Http\Controllers\Admin\HQ\Frames;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\HQ\Frames\StoreFramePurchaseRequest;
use App\Models\HqFramePurchase;
use Illuminate\Support\Facades\Auth;

class HQFramePurchasesController extends Controller
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
            $data = $organization->hq_frame_purchase()->latest()->get();
            return datatables()->of($data)
                ->addColumn('color', function ($row) {
                    $color = $row->frame_color->color;
                    return $color;
                })
                ->addColumn('shape', function ($row) {
                    $shape = $row->frame_shape->shape;
                    return $shape;
                })
                ->addColumn('receipt', function ($row) {
                    return '<a href="'. route('admin.hq.frame.purchases.attachment', $row->id) .'" target="_blank" class="btn btn-tools btn-sm">'. $row->attachment .'</a>';
                })
                ->addColumn('supplier', function ($row) {
                    return $row->vendor->first_name . ' ' . $row->vendor->last_name;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-tools btn-sm deleteFramePurchaseBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['color', 'shape', 'receipt', 'supplier', 'actions'])
                ->make(true);
        }
        $org_purchases = $organization->hq_frame_purchase()->latest()->get();
        $page_title = trans('admin.page.frames.sub_page.purchases');
        return view('admin.HQ.Frames.purchased', [
            'organization' => $organization,
            'purchases' => $org_purchases,
            'page_title' => $page_title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFramePurchaseRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        //1. Get Stock 
        $frame_stock = $organization->hq_frame_stock()->findOrFail($data['stock_id']);

        // Craeate a purchase
        $frame_purchase = new HqFramePurchase();

        $frame_purchase->organization_id = $organization->id;
        $frame_purchase->admin_id = $admin->id;
        $frame_purchase->stock_id = $frame_stock->id;
        $frame_purchase->frame_id = $frame_stock->frame_id;
        $frame_purchase->code = $frame_stock->frame->code;
        $frame_purchase->color_id = $frame_stock->frame_color->id;
        $frame_purchase->shape_id = $frame_stock->frame_shape->id;
        $frame_purchase->receipt_number = $data['receipt_number'];
        $frame_purchase->purchase_date = $data['purchase_date'];
        $frame_purchase->gender = $frame_stock->gender;
        $frame_purchase->quantity = $data['quantity'];
        $frame_purchase->price = $data['price'];
        $frame_purchase->total = $frame_purchase->quantity * $frame_purchase->price;
        $frame_purchase->vendor_id = $data['vendor_id'];
        if ($request->hasFile('attachment')) {
            $storagePath = 'public/frame_purchases';
            $fileName = 'attachment';
            $frame_purchase->attachment = $this->uploadFile($request, $fileName, $storagePath);
        }

        if ($frame_purchase->save()) {
            // update stocks on hq

            $opening =  $frame_stock->opening;

            $purchased = $frame_stock->purchased + $data['quantity'];

            $transfered = $frame_stock->transfered; 

            $total = ($opening + $purchased) - $transfered; 

            $frame_stock->update([
                'opening' => $opening,
                'purchased' => $purchased,
                'transfered' => $transfered,
                'total' => $total
            ]);

            $response['status'] = true;
            $response['message'] = 'Successfully stored frame purchase record';

            return response()->json($response);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqFramePurchase $hqFramePurchase)
    {
        //
        $response = [
            'status' => true,
            'data' => $hqFramePurchase
        ];

        return response()->json($response, 200);
    }

     /**
     * Display the specified attachment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachment(HqFramePurchase $hqFramePurchase)  
    {
        $file = $hqFramePurchase->attachment;
        $storage_path = 'frame_purchases';
        return $this->openFile($file, $storage_path);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqFramePurchase $hqFramePurchase)
    {
        //
        $frame_stock = $hqFramePurchase->hq_frame_stock;

        // purchased stocks 
        $purchased = $frame_stock->purchased;

        // quantity to delete
        $quantity = $hqFramePurchase->quantity;

        // remove the quantity from total purchased
        $remaining = $purchased - $quantity;

        // update stock 
        $opening = $frame_stock->opening;

        $new_purchased = $remaining;

        $transfered = $frame_stock->transfered;

        $total = ($opening + $new_purchased) - $transfered;

        $frame_stock->update([
            'opening' => $opening,
            'purchased' => $new_purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        $hqFramePurchase->delete();

        $response['status'] = true;
        $response['message'] = 'Frame Purchase Deleted Successfully';
        return response()->json($response, 200);
    }
}
