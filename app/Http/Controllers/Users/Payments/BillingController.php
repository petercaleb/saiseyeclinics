<?php

namespace App\Http\Controllers\Users\Payments;

use App\Http\Controllers\Controller;
use App\Models\PaymentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(PaymentBill $paymentBill,  Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'item' => 'required|string',
            'amount' => 'required|string',
            'receipt' => 'required|string|unique:billings,receipt_number',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        // check if the bill is already paid
        if ($paymentBill->balance <= 0) {
            $response['status'] = false;
            $response['errors'] = 'The bill is already paid';
            return response()->json($response, 401);
        }

        $clinic = $paymentBill->clinic;

        $paymentBill->billing()->create([
            'item' => $data['item'],
            'amount' => $data['amount'],
            'receipt_number' => $clinic->initials.'/'.$data['receipt'],
            'date' => $data['date'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Billing successfully created.';

        return response()->json($response, 200);
    }

    // Update Payment Bill total paid amount
    public function update_payment_bill(PaymentBill $paymentBill, Request $request)
    {
        # code...
        $appointment = $paymentBill->appontment;

        $paid = $paymentBill->billing()->sum('amount');

        $total_paid = $paymentBill->consultation_fee + $paid;

        $paymentBill->id = $paymentBill->id;
        $paymentBill->bill_status = 'PENDING';
        $paymentBill->total_amount = $paymentBill->total_amount;
        $paymentBill->paid_amount = $total_paid;
        $paymentBill->balance = $paymentBill->total_amount - $paymentBill->paid_amount;

        if ($paymentBill->save()) {

            $clinic = $paymentBill->clinic;

            $report_id = $appointment->report_id;

            $report = $clinic->report()->findOrFail($report_id);

            $report->update([
                'total_amount' => $paymentBill->total_amount,
                'paid_amount' => $paymentBill->paid_amount,
                'balance' => $paymentBill->balance
            ]);

            $response['status'] = true;
            $response['message'] = 'Billing successfully updated.';

            return response()->json($response, 200);
        }
    }
}
