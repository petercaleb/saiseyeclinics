<?php

namespace App\Http\Controllers\Technicians\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
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
            $data = $workshop->order->where('status', '!=', 'APPROVED')->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('order_date', function ($row) {
                    $order_date = Carbon::createFromFormat('Y-m-d', $row->order_date)->format('d, F, Y');
                    return $order_date;
                })
                ->addColumn('patient', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('clinic', function ($row) {
                    $clinic = $row->clinic->clinic;
                    return $clinic;
                })
                ->addColumn('view', function ($row) {
                    $viewBtn = '<a href="javascript:void(0)" ';
                    $viewBtn = $viewBtn . 'data-id="' . $row->id . '"';
                    $viewBtn = $viewBtn . 'class="btn btn-tool btn-sm viewOrderBtn">';
                    $viewBtn = $viewBtn . '<i class="fa fa-eye"></i>';
                    $viewBtn = $viewBtn . '</a>';
                    return $viewBtn;
                })
                ->rawColumns(['order_date', 'patient', 'clinic', 'view'])
                ->make(true);
        }
        $orders = $workshop->order->where('status', '!=', 'APPROVED')->sortBy('created_at', SORT_DESC);
        $sum_lenses = $workshop->lens->sum('closing');
        $num_sales = $workshop->workshop_sale->count();
        $page_title = trans('pages.technicians.dashboard');
        return view('technicians.dashboard.index', [
            'page_title' => $page_title,
            'workshop' => $workshop,
            'orders' => $orders,
            'sum_lenses' => $sum_lenses,
            'num_sales' => $num_sales
        ]);
    }
}
