<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order as ResourcesOrder;
use App\Models\Clinic;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {

            if (!empty($request->status)) {
                $data = $clinic->order()
                    ->where('status', $request->status)
                    ->latest()
                    ->get();
            } else {
                $data = $clinic->order()
                    ->latest()
                    ->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('order_date', function ($row) {
                    return date('d, F, Y', strtotime($row->order_date));
                })
                ->addColumn('clinic', function ($row) {
                    return $row->clinic->clinic;
                })
                ->addColumn('workshop', function ($row) {
                    return $row->workshop->name;
                })
                ->addColumn('tat_one', function($row){
                    return $row->tat_one;
                })
                ->addColumn('tat_two', function($row){
                    return $row->tat_two;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" data-id="' . $row->id . '" class="btn btn-tools btn-sm viewOrderBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'order_date', 'clinic', 'workshop'])
                ->make(true);
        }
        $orders = $clinic->order()->latest()->get();
        $page_title = trans('pages.orders');
        return view('admin.orders.clinics.index', [
            'clinic' => $clinic,
            'orders' => $orders,
            'page_title' => $page_title,
        ]);
    }

    public function show($order_id)
    {
        # code...
        $order = Order::find($order_id);

        return new ResourcesOrder($order);
    }

    public function view($id, $order_id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $order = $clinic->order()->findOrFail($order_id);
        $page_title = trans('pages.orders');
        return view('admin.orders.clinics.view', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'order' => $order,
        ]);
    }
}
