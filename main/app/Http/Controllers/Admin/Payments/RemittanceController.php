<?php

namespace App\Http\Controllers\Admin\Payments;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Remittance;
use App\Models\Remmittance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RemittanceController extends Controller
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
            $data = $clinic->remittance()
                ->join('payment_bills', 'payment_bills.id', '=', 'remittances.bill_id')
                ->join('patients', 'patients.id', '=', 'payment_bills.patient_id')
                ->select('remittances.*', 'patients.first_name', 'patients.last_name')
                ->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('remittance_amount', function ($row) {
                    return number_format($row['remittance_amount'], 2, '.', ',');
                })
                ->addColumn('remittance_date', function ($row) {
                    return date('d-M-Y', strtotime($row['remittance_date']));
                })
                ->addColumn('remittance_status', function ($row) {
                    if ($row['status'] == 'OPENED') {
                        return '<span class="badge badge-primary">' . $row['status'] . '</span>';
                    } else {
                        return '<span class="badge badge-success">' . $row['status'] . '</span>';
                    }
                })
                ->addColumn('view', function ($row) {
                    $btn = '<a href="#" data-id="' . $row['id'] . '" class="btn btn-sm btn-tools viewRemittanceBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('close', function($row){
                    $btn = '<a href="#" data-id="' . $row['id'] . '" class="btn btn-sm btn-tools closeRemittanceBtn"><i class="fa  fa-close"></i></a>';
                    return $btn;
                })
                ->rawColumns(['view', 'close', 'full_names', 'remittance_status', 'remittance_date', 'remittance_amount'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $page_title = trans('pages.payments');
        $payments_page = trans('pages.payment_subpage.remittance');
        return view('admin.remittance.index', [
            'clinic' => $clinic,
            'patients' => $patients,
            'page_title' => $page_title,
            'payments_page' => $payments_page,
        ]);
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'remittance_id' => 'required|integer|exists:remittances,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $remittance = Remittance::findOrFail($data['remittance_id']);
        $request->session()->put('remittance_id', $remittance->id);

        $response['status'] = true;
        $response['data'] = $remittance;
        return response()->json($response, 200);
    }

    public function view(Request $request, $id)
    {
        # code...
        $clinic = Clinic::findOrFail($id);
        $patients = $clinic->patient->count();
        if($request->session()->has('remittance_id')){
            $remittance_id = $request->session()->get('remittance_id');
            $remittance = Remmittance::findOrFail($remittance_id);
            $payment_bill = $remittance->payment_bill;
            $page_title = "Remittance Bill";
            return view('admin.remittance.view', [
                'clinic' => $clinic,
                'patients' => $patients,
                'remittance' => $remittance,
                'payment_bill' => $payment_bill,
                'page_title' => $page_title,
            ]);

        }
        return redirect()->route('admin.payments.remittance.index', $clinic->id);
    }

    public function close(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'remittance_id' => 'required|integer|exists:remittances,id',
            'paid_amount' => 'required|numeric',
            'closed_date' =>  'required|date|date_format:Y-m-d'
        ]);

        if($validator->failed()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $remittance = Remittance::findOrFail($data['remittance_id']);

        $remittance->id = $remittance->id;
        $remittance->amount = $remittance->amount;
        $remittance->paid = $data['paid_amount'];
        $remittance->closed_date = $data['closed_date'];
        $remittance->status = 'CLOSED';

        $remittance->save();

        $response['status'] = true;
        $response['message'] = "You have successfully closed current remittance";

        return response()->json($response);


    }
}
