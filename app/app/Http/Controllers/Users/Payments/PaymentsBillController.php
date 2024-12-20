<?php

namespace App\Http\Controllers\Users\Payments;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Models\PaymentBill;
use App\Models\PaymentDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class PaymentsBillController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        # code...
        $user = User::find(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {

            $data = $clinic->payment_bill()->where('bill_status', '!=', 'CLOSED')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
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

                ->addColumn('doctor', function ($row) {
                    if($row->user_id !== null)
                    {
                        return $row->user->first_name . ' ' . $row->user->last_name;
                    } else{
                        return '';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->user_id !== null && $row->user->id == Auth::user()->id) {
                        $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-tools btn-sm editPaymentBill"><i class="fa fa-edit"></i></a>';
                    }

                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="view btn btn-tools btn-sm viewPaymentBill"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(
                    [
                        'action',
                        'full_names', 
                        'open_date', 
                        'consultation_fee', 
                        'claimed_amount', 
                        'agreed_amount', 
                        'total_amount', 
                        'paid_amount', 
                        'balance', 
                        'bill_status',
                        'doctor'
                    ]
                )
                ->make(true);
        }
        $page_title = 'Payment Bills';
        return view('users.billing.index', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
        ]);
    }


    public function get_scheduled(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->ajax()) {
            $data = $user->payment_bill()->where('bill_status', '!=', 'CLOSED')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
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

                ->addColumn('doctor', function ($row) {
                    if($row->user_id !== null)
                    {
                        return $row->user->first_name . ' ' . $row->user->last_name;
                    } else{
                        return '';
                    }
                })

                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->user_id !== null && $row->user->id == Auth::user()->id) {
                        $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-tools btn-sm editPaymentBill"><i class="fa fa-edit"></i></a>';
                    }

                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="view btn btn-tools btn-sm viewPaymentBill"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(
                    [
                        'action',
                        'full_names', 
                        'open_date', 
                        'consultation_fee', 
                        'claimed_amount', 
                        'agreed_amount', 
                        'total_amount', 
                        'paid_amount', 
                        'balance', 
                        'bill_status',
                        'doctor'
                    ]
                )
                ->make(true);
        }
    }

    public function create($id)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        $payment_bill = PaymentBill::findOrFail($id);
        $page_title = 'Create Bill';
        return view('users.billing.create', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
            'payment_bill' => $payment_bill,
        ]);
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'schedule_id' => 'required|integer|exists:doctor_schedules,id',
            'claimed_amount' => 'required|numeric|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'consultation_receipt' => 'required|numeric',
            'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $doctor_schedule = DoctorSchedule::findOrFail($data['schedule_id']);

        $appointment = $doctor_schedule->appointment;

        $payments_details =  $appointment->payment_detail;

        $payment_bill = new PaymentBill;

        $payment_bill->user_id = $doctor_schedule->user->id;
        $payment_bill->clinic_id = $doctor_schedule->clinic->id;
        $payment_bill->patient_id = $doctor_schedule->patient->id;
        $payment_bill->appointment_id = $doctor_schedule->appointment->id;
        $payment_bill->schedule_id = $doctor_schedule->id;
        $payment_bill->payment_details_id = $payments_details->id;
        $open_date = date('Y-m-d');
        $payment_bill->open_date = Carbon::createFromFormat('Y-m-d', $open_date)->format('Y-m-d');
        $payment_bill->consultation_fee = $data['consultation_fee'];
        $payment_bill->consultation_receipt_number = $doctor_schedule->clinic->initials . '/' . $data['consultation_receipt'];

        if ($data['claimed_amount'] == 0) {
            $approval_status = "CLOSED";
        } else {
            $approval_status = "PENDING";
        }


        if ($payments_details->client_type->type == 'Cash') {
            $payment_bill->bill_status = 'PENDING';
            $payment_bill->approval_status = 'APPROVED';
            $payment_bill->claimed_amount = $data['claimed_amount'];
            $payment_bill->agreed_amount = $payment_bill->claimed_amount;
        } else {
            if ($data['claimed_amount'] == 0) {
                $payment_bill->bill_status = 'PENDING';
            } else {
                $payment_bill->bill_status = 'OPEN';
            }
            $payment_bill->approval_status = $approval_status;
            $payment_bill->claimed_amount = $data['claimed_amount'];
            $payment_bill->agreed_amount = 0;
        }

        $payment_bill->total_amount = $payment_bill->agreed_amount + $payment_bill->consultation_fee;
        $payment_bill->paid_amount = 0 + $payment_bill->consultation_fee;
        $payment_bill->balance = $payment_bill->total_amount - $payment_bill->paid_amount;
        $payment_bill->remarks = $data['remarks'];

        if ($payment_bill->save()) {

            $clinic = $payment_bill->clinic;

            $report_id = $appointment->report_id;

            $report = $clinic->report()->findOrFail($report_id);

            $report->update([
                'bill_id' => $payment_bill->id,
                'bill_status' => $payment_bill->bill_status,
                'consultation_fee' => $payment_bill->consultation_fee,
                'claimed_amount' => $payment_bill->claimed_amount,
            ]);

            $response['status'] = true;
            $response['bill_id'] = $payment_bill->id;
            $response['message'] = 'Bill created successfully';

            return response()->json($response, 200);
        }
    }

    public function show(PaymentBill $paymentBill)
    {
        # code...
        $response['status'] = true;
        $response['data'] = $paymentBill;
        return response()->json($response, 200);
    }

    public function view(PaymentBill $paymentBill)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        $doctor_schedule = $paymentBill->doctor_schedule;
        $diagnosis = $doctor_schedule->diagnosis;
        $treatment = $diagnosis->treatment;
        $page_title = trans('users.page.payments.sub_page.view');
        if ($paymentBill->user_id == null) {
            $paymentBill->update([
                'user_id' => $doctor_schedule->user_id
            ]);
        }
        return view('users.billing.view', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
            'payment_bill' => $paymentBill,
            'treatment' => $treatment
        ]);
    }

    public function edit(PaymentBill $paymentBill)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        $doctor_schedule = $paymentBill->doctor_schedule;
        if ($paymentBill->user_id == null) {
            $paymentBill->update([
                'user_id' => $doctor_schedule->user_id
            ]);
        }
        $page_title = 'Edit Bill';
        return view('users.billing.edit', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
            'payment_bill' => $paymentBill,
        ]);
    }

    public function update_agreed(PaymentBill $paymentBill, Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $appointment = $paymentBill->appontment;

        $paymentBill->id = $paymentBill->id;
        $paymentBill->bill_status = 'PENDING';
        if ($paymentBill->payment_detail->insurance) {
            $paymentBill->approval_status = $data['approval_status'];
            $paymentBill->approval_number = $data['approval_number'];
        }
        if ($paymentBill->approval_status == 'REJECTED') {
            $paymentBill->agreed_amount = $data['amount'];
            $paymentBill->total_amount = 0 + $paymentBill->consultation_fee;
        } else {
            $paymentBill->agreed_amount = $data['amount'];
            $paymentBill->total_amount = $paymentBill->agreed_amount + $paymentBill->consultation_fee;
        }
        $paymentBill->paid_amount = $paymentBill->paid_amount;
        $paymentBill->balance = $paymentBill->total_amount - $paymentBill->paid_amount;


        if ($paymentBill->save()) {

            $clinic = $paymentBill->clinic;

            $report_id = $appointment->report_id;

            $report = $clinic->report()->findOrFail($report_id);

            $report->update([
                'bill_status' => $paymentBill->bill_status,
                'agreed_amount' => $paymentBill->agreed_amount,
                'total_amount' => $paymentBill->total_amount,
                'paid_amount' => $paymentBill->paid_amount,
                'balance' => $paymentBill->balance,
            ]);

            $response['status'] = true;
            $response['message'] = 'You have upated the agreed amount for this bill';

            return response()->json($response, 200);
        }
    }

    public function update_consultation(PaymentBill $paymentBill, Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'consultation_fee' => 'required|numeric',
            'consultation_receipt' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $appointment = $paymentBill->appontment;

        $paymentBill->id = $paymentBill->id;
        $paymentBill->consultation_fee = $data['consultation_fee'];
        $paymentBill->consultation_receipt_number = $paymentBill->clinic->initials . '/' . $data['consultation_receipt'];
        $paymentBill->bill_status = 'PENDING';
        $paymentBill->agreed_amount = $paymentBill->consultation_fee;
        $paymentBill->total_amount = $paymentBill->agreed_amount;
        $paymentBill->paid_amount = $paymentBill->consultation_fee;
        $paymentBill->balance = $paymentBill->total_amount - $paymentBill->paid_amount;

        return $appointment;

        // if ($payment_bill->save()) {

        //     $clinic = $payment_bill->clinic;

        //     $report_id = $appointment->report_id;

        //     $report = $clinic->report()->findOrFail($report_id);

        //     $report->update([
        //         'bill_status' => $payment_bill->bill_status,
        //         'consultation_fee' => $payment_bill->consultation_fee,
        //         'agreed_amount' => $payment_bill->agreed_amount,
        //         'total_amount' => $payment_bill->total_amount,
        //         'paid_amount' => $payment_bill->paid_amount,
        //         'balance' => $payment_bill->balance,
        //     ]);

        //     $response['status'] = true;
        //     $response['message'] = 'You have upated the consultation fee for this bill';

        //     return response()->json($response, 200);
        // }
    }

    public function print(PaymentBill $paymentBill)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        $page_title = 'Print Bill';
        return view('users.billing.print', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
            'payment_bill' => $paymentBill,
        ]);
    }
}
