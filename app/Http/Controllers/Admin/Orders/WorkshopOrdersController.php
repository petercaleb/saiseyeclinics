<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkshopOrdersController extends Controller
{


    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $workshop = Workshop::findOrFail($id);
        if ($request->ajax()) {
            $data = $workshop->order->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function($row){
                    $full_names = $row->patient->first_name. " " . $row->patient->last_name;
                    return $full_names;
                })
                ->addColumn('clinic', function($row){
                    $clinic = $row->clinic->clinic;
                    return $clinic;
                })
                ->addColumn('workshop', function($row){
                    $workshop = $row->workshop->name;
                    return $workshop;
                })
                ->addColumn('view', function ($row) {
                    $btn = '<a href="#" data-id="' . $row->id . '" class="btn btn-tools btn-sm viewOrderBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['view', 'full_names', 'clinic', 'workshop'])
                ->make(true);
        }
        $page_title = "Workshop Orders";
        return view('admin.orders.workshops.index', [
            'page_title' => $page_title,
            'workshop' => $workshop,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $order = Order::findOrFail($data['order_id']);
        $request->session()->put('order_id', $order->id);

        $response['status'] = true;
        $response['data'] = $order;

        return response()->json($response);
    }

    /**
     * View the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        //
        $workshop = Workshop::findOrFail($id);
        if ($request->session()->has('order_id')) {
            $order_id = $request->session()->get('order_id');
            $order = Order::findOrFail($order_id);
            $request->session()->forget('order_id');
            $sales = $order->workshop_sale->sortBy('created_at', SORT_DESC);
            $page_title = 'Order #' . $order->id;
            return view('admin.orders.workshops.view', [
                'page_title' => $page_title,
                'workshop' => $workshop,
                'order' => $order,
                'sales' => $sales,
            ]);
        }
        return redirect()->route('admin.workshop.orders.index', $workshop->id);
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
