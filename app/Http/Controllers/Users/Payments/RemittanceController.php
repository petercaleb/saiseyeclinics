<?php

namespace App\Http\Controllers\Users\Payments;

use App\Http\Controllers\Controller;
use App\Models\PaymentBill;
use App\Models\Remittance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RemittanceController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        # code...
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $clinic->remittance()
                ->join('payment_bills', 'payment_bills.id', '=', 'remittances.bill_id')
                ->join('patients', 'patients.id', '=', 'payment_bills.patient_id')
                ->select('remittances.*', 'patients.first_name', 'patients.last_name')
                ->where('patients.user_id', $user->id)
                ->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('remittance_amount', function($row){
                    return number_format($row['remittance_amount'], 2, '.', ',');
                })
                ->addColumn('remittance_date', function($row){
                    return date('d-M-Y', strtotime($row['remittance_date']));
                })
                ->addColumn('remittance_status', function($row){
                    if($row['status'] == 'OPENED'){
                        return '<span class="badge badge-primary">'. $row['status'] .'</span>';
                    }else{
                        return '<span class="badge badge-success">'. $row['status'] .'</span>';
                    }
                })
                ->addColumn('view', function ($row) {
                    $btn = '<a href="#" data-id="' . $row['id'] . '" class="btn btn-sm btn-tools viewRemittanceBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['view', 'full_names', 'remittance_status', 'remittance_date', 'remittance_amount'])
                ->make(true);
        }
        $page_title = "Remittance Bills";
        return view('users.remittance.index', [
            'user' => $user,
            'clinic' => $clinic,
            'page_title' => $page_title,
        ]);
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'bill_id' => 'required|integer|exists:payment_bills,id',
            'item' => 'required|string',
            'remittance_amount' => 'required|numeric',
            'remittance_date'=> 'required|date',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $payment_bill = PaymentBill::findOrFail($data['bill_id']);

        $amount = $data['remittance_amount'];
        $paid = 0;
        $balance = $amount - $paid; // $amount - $paid;

        $payment_bill->remittance()->create([
            'clinic_id' => $payment_bill->clinic->id,
            'bill_invoice' => $payment_bill->invoice_number,
            'item' => $data['item'],
            'amount' => $amount,
            'paid' => $paid,
            'balance' => $balance,
            'remittance_date' => $data['remittance_date'],
            'status' => 'OPENED',
        ]);
        $response['status'] = true;
        $response['message'] = 'Payments Remittance successfully added';

        return response()->json($response, 200);
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

        $response['status'] = true;
        $response['data'] = $remittance;
        return response()->json($response, 200);
    }

    public function view($id)
    {
        # code...
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $remittance = Remittance::findOrFail($id);
        $payment_bill = $remittance->payment_bill;
        $page_title = "Remittance Bill";
        return view('users.remittance.view', [
            'user' => $user,
            'clinic' => $clinic,
            'remittance' => $remittance,
            'payment_bill' => $payment_bill,
            'page_title' => $page_title,
        ]);
    }

    public function update_bill(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'bill_id' => 'required|integer|exists:payment_bills,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $payment_bill = PaymentBill::findOrFail($data['bill_id']);

        $remittance_amount = $payment_bill->remittance()->sum('amount');

        $payment_bill->id = $payment_bill->id;

        $payment_bill->remittance_amount = $remittance_amount;

        $payment_bill->remittance_balance = $payment_bill->total_amount - $payment_bill->remittance_amount;

        $payment_bill->save();

        $response['status'] = true;
        $response['message'] = "Remittance amount successfully updated";

        return response()->json($response, 200);

    }
}
