<?php

namespace App\Http\Controllers\Admin\Reports\Claims;

use App\Exports\Admin\Reports\ClinicPendingClaimsReport;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendingClaimsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Clinic $clinic)
    {
        //
        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->payment_bill()
                    ->whereBetween('open_date', [$request->from_date, $request->to_date])
                    ->where('approval_status', 'PENDING')
                    ->latest()->get();
            } else {
                $data = $clinic->payment_bill()
                    ->where('approval_status', 'PENDING')
                    ->latest()->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('open_date', function ($row) {
                    return date('d F Y', strtotime($row->open_date));
                })
                ->addColumn('clinic', function ($row) {
                    return $row->clinic->clinic;
                })
                ->addColumn('patient_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('insurance', function ($row) {
                    if ($row->payment_detail->client_type->type == "Insurance") {
                        if ($row->payment_detail->insurance) {
                            return $row->payment_detail->insurance->title;
                        }
                    }
                })
                ->addColumn('scheme', function ($row) {
                    if ($row->payment_detail->client_type->type == "Insurance") {
                        return $row->payment_detail->scheme;
                    }
                })
                ->addColumn('claimed_date', function ($row) {
                    return date('d F Y', strtotime($row->open_date));
                })
                ->addColumn('aging', function ($row) {
                    $now = Carbon::now();
                    $claimed_date = Carbon::parse($row->open_date);
                    return $claimed_date->diffInDays($now);
                })
                ->rawColumns(['open_date'])
                ->make(true);
        }
        $page_title = trans('menus.admins.sidebar.reports.pending');
        return view('admin.reports.claims.pending.index', [
            'clinic' => $clinic,
            'page_title' => $page_title
        ]);
    }

    /**
     * Export the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, Clinic $clinic)
    {
        //
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        return (new ClinicPendingClaimsReport($clinic->id, $from_date, $to_date))->download('pending-clains-reports-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
