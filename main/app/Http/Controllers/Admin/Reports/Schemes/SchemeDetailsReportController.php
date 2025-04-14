<?php

namespace App\Http\Controllers\Admin\Reports\Schemes;

use App\Exports\Admin\Reports\ClinicSchemeDetailsReport;
use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchemeDetailsReportController extends Controller
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
                    ->latest()->get();
            } elseif (!empty($request->bill_status)) {
                $data = $clinic->payment_bill()
                    ->where('bill_status', $request->bill_status)
                    ->latest()->get();
            } else {
                $data = $clinic->payment_bill()->latest()->get();
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
                ->addColumn('patient_phone', function ($row) {
                    return $row->patient->phone;
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
                ->addColumn('phone', function ($row) {
                })
                ->rawColumns(['patients', 'clinic', 'phone'])
                ->make(true);
        }
        $page_title = trans('menus.admins.sidebar.reports.scheme_details');
        return view('admin.reports.schemes.index', [
            'page_title' => $page_title,
            'clinic' => $clinic
        ]);
    }


    /**
     * Display a reports of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, Clinic $clinic)  
    {
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $bill_status = $request->input('bill_status') ? $request->input('bill_status') : '';
        return (new ClinicSchemeDetailsReport($clinic->id, $from_date, $to_date, $bill_status))->download('scheme-details-reports-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

}
