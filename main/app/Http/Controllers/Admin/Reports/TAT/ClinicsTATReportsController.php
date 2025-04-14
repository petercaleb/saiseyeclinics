<?php

namespace App\Http\Controllers\Admin\Reports\TAT;

use App\Exports\Admin\Reports\ClinicTATOneReport;
use App\Exports\Admin\Reports\ClinicTATTwoReport;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicsTATReportsController extends Controller
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
    public function index(Request $request, Clinic $clinic)
    {
        //
        $organization = $clinic->organization;

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->order()->whereBetween('order_date', [$request->from_date, $request->to_date])
                    ->where('tat_one', '>', 0)->latest()->get();
            } elseif (!empty($request->status)) {
                $data = $clinic->order()->where('status', $request->status)
                    ->where('tat_one', '>', 0)->latest()->get();
            } else {
                $data = $clinic->order()->where('tat_one', '>', 0)->latest()->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('order_date', function ($row) {
                    return date('d, F, Y', strtotime($row->order_date));
                })
                ->addColumn('clinic', function ($row) {
                    return $row->clinic->clinic;
                })
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('workshop', function ($row) {
                    return $row->workshop->name;
                })
                ->rawColumns(['order_date', 'order_number', 'clinic', 'workshop'])
                ->make(true);
        }

        $page_title = trans('menus.admins.sidebar.reports.tat');
        return view('admin.reports.tat.index', [
            'clinic' => $clinic,
            'organization' => $organization,
            'page_title' => $page_title
        ]);
    }

    /**
     * Export a listing of the resource in excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function export_tat_one(Request $request, Clinic $clinic)
    {
        //
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $status = $request->input('order_status')  ? $request->input('order_status') : '';
        return (new ClinicTATOneReport($clinic->id, $from_date, $to_date, $status))->download('tat_one_reports_' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_tat_two(Request $request, Clinic $clinic)
    {
        //
        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->order()
                    ->whereBetween('order_date', [$request->from_date, $request->to_date])
                    ->where('tat_two', '>', 0)
                    ->latest()->get();
            } elseif (!empty($request->status)) {
                $data = $clinic->order()->where('status', $request->status)
                    ->where('tat_two', '>', 0)->latest()->get();
            } else {
                $data = $clinic->order()
                    ->where('tat_two', '>', 0)
                    ->latest()->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('order_date', function ($row) {
                    return date('d, F, Y', strtotime($row->order_date));
                })
                ->addColumn('clinic', function ($row) {
                    return $row->clinic->clinic;
                })
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('workshop', function ($row) {
                    return $row->workshop->name;
                })
                ->rawColumns(['order_date', 'order_number', 'clinic', 'workshop'])
                ->make(true);
        }
    }

    /**
     * Export a listing of the resource in excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function export_tat_two(Request $request, Clinic $clinic)
    {
        //
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $status = $request->input('order_status')  ? $request->input('order_status') : '';
        return (new ClinicTATTwoReport($clinic->id, $from_date, $to_date, $status))->download('tat_two_reports_' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
