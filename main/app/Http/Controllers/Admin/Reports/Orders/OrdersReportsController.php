<?php

namespace App\Http\Controllers\Admin\Reports\Orders;

use App\Exports\ClinicOrdersReport;
use App\Models\Clinic;
use App\Models\Workshop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;

class OrdersReportsController extends Controller
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
    public function index(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                    ->whereBetween('order_tracks.track_date', [$request->from_date, $request->to_date])
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            } elseif (!empty($request->order_id)) {
                $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                    ->where('orders.id', $request->order_id)
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            } elseif (!empty($request->status)) {
                $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                    ->where('order_tracks.track_status', $request->status)
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            } else {
                $data = $clinic->order()
                    ->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                    ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('order_date', function ($row) {
                    return date('d, F, Y', strtotime($row->track_date));
                })
                ->addColumn('order_number', function ($row) {
                    return '#' . $row->id;
                })
                ->addColumn('clinic', function ($row) {
                    $clinic = Clinic::findOrFail($row->clinic_id);
                    return $clinic->clinic;
                })
                ->addColumn('full_names', function ($row) {
                    $patient = Patient::findOrFail($row->patient_id);
                    return ucwords("{$patient->first_name} {$patient->last_name}");
                })
                ->addColumn('status', function ($row) {
                    return $row->track_status;
                })
                ->addColumn('workshop', function ($row) {
                    $workshop = Workshop::findOrFail($row->workshop_id);
                    return $workshop->name;
                })
                ->rawColumns(['order_number', 'clinic', 'order_date', 'workshop'])
                ->make(true);
        }
        $orders = $clinic->order()->latest()->get();
        $page_title = trans('pages.reports.orders');
        return view('admin.reports.orders.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $order_id = $request->input('order_id') ? $request->input('order_id') : '';
        $order_status = $request->input('order_status') ? $request->input('order_status') : '';
        return (new ClinicOrdersReport($clinic->id, $from_date, $to_date, $order_id, $order_status))->download('orders_reports' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
