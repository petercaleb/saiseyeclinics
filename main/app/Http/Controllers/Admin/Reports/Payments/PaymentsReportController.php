<?php

namespace App\Http\Controllers\Admin\Reports\Payments;

use App\Exports\ClinicPaymentsReport;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\PaymentBill;
use Illuminate\Http\Request;

class PaymentsReportController extends Controller
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
                $data = $clinic->payment_bill()
                    ->whereBetween('open_date', [$request->from_date, $request->to_date])
                    ->latest()->get();
            } elseif (!empty($request->bill_status)) {
                $data = $clinic->payment_bill()
                    ->where('bill_status', $request->bill_status)
                    ->latest()->get();
            } else {
                $data = $clinic->payment_bill()
                    ->with('billing')
                    ->latest()
                    ->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('open_date', function ($row) {
                    return date('d F Y', strtotime($row->open_date));
                })
                ->addColumn('patient_names', function ($row) {
                    return $row->patient->first_name . " " . $row->patient->last_name;
                })
                ->rawColumns(['patient_names', 'open_date'])
                ->make(true);
        }
        $page_title = trans('pages.reports.clinic-payments');
        return view('admin.reports.payments.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $bill_status = $request->input('bill_status') ? $request->input('bill_status') : '';
        return (new ClinicPaymentsReport($clinic->id, $from_date, $to_date, $bill_status))->download('payment-reports' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
