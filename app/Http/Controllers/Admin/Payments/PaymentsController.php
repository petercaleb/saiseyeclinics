<?php

namespace App\Http\Controllers\Admin\Payments;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\PaymentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
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
            $data = $clinic->payment_bill()
                ->join('patients', 'payment_bills.patient_id', '=', 'patients.id')
                ->select('payment_bills.*', 'patients.first_name as patient_first', 'patients.last_name as patient_last')
                ->where('payment_bills.bill_status', '!=', 'CLOSED')
                ->where('patients.status', 1)
                ->orderBy('payment_bills.id', 'desc')
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->patient_first . ' ' . $row->patient_last;
                })
                ->addColumn('consultation_fee', function ($row) {
                    return number_format($row->consultation_fee, 2, '.', ',');
                })
                ->addColumn('open_date', function ($row) {
                    $open_date = date('d-m-Y', strtotime($row->open_date));
                    return $open_date;
                })
                ->addColumn('bill_status', function ($row) {
                    if ($row['bill_status'] == 'OPEN') {
                        return '<span class="badge badge-primary">OPEN</span>';
                    } elseif ($row['bill_status'] == 'PENDING') {
                        return '<span class="badge badge-warning">PENDING</span>';
                    } else {
                        return '<span class="badge badge-success">CLOSED</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="view btn btn-tools btn-sm viewPaymentBill"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'open_date', 'consultation_fee', 'claimed_amount', 'agreed_amount', 'bill_status'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $page_title = trans('pages.payments');
        $payments_page = trans('pages.payment_subpage.payments');
        return view('admin.bills.index', [
            'page_title' => $page_title,
            'payments_page' => $payments_page,
            'clinic' => $clinic,
            'patients' => $patients,
        ]);
    }

    public function show($payment_id)
    {
        # code...
        $payment_bill = PaymentBill::findOrFail($payment_id);

        $response['status'] = true;
        $response['data'] = $payment_bill;

        return response()->json($response, 200);
    }

    public function view($id, $payment_id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $payment_bill = PaymentBill::findOrFail($payment_id);
        $page_title = trans('pages.payments');
        $payments_page = trans('pages.payment_subpage.payments');
        return view('admin.bills.view', [
            'clinic' => $clinic,
            'payment_bill' => $payment_bill,
            'page_title' => $page_title,
            'payments_page' => $payments_page,
        ]);
    }

    public function print($id, $payment_id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $patients = $clinic->patient->count();
        $payment_bill = PaymentBill::findOrFail($payment_id);
        $page_title = trans('pages.payments');
        return view('admin.bills.print', [
            'payment_bill' => $payment_bill,
            'page_title' => $page_title,
            'clinic' => $clinic,
            'patients' => $patients,
        ]);

        return redirect()->route('admin.payments.bills.index', $clinic->id);
    }
}
