<?php

namespace App\Http\Controllers\Users\Payments;

use App\Models\User;
use App\Models\PaymentBill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CloseBillsRepository;
use App\Http\Requests\Users\Payments\SendMultipleDocToHQRequest;

class CloseBillsController extends Controller
{
    //
    private $closeBillRepository;

    public function __construct(CloseBillsRepository $closeBillRepository)
    {
        $this->middleware('auth');
        $this->closeBillRepository = $closeBillRepository;
    }

    public function index(Request $request)
    {
        # code...
        $user = User::find(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $clinic->payment_bill()->where('bill_status', '=', 'CLOSED')->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('total_amount', function ($row) {
                    return number_format($row->total_amount, 2, '.', ',');
                })
                ->addColumn('total_paid', function ($row) {
                    return number_format($row->paid_amount, 2, '.', ',');
                })
                ->addColumn('close_date', function ($row) {
                    if ($row->close_date !== null) {
                        return date('d-M-Y', strtotime($row->close_date));
                    } else {
                        return '';
                    }
                })
                ->addColumn('doctor', function ($row) {
                    if ($row->user_id !== null) {
                        return $row->user->first_name . ' ' . $row->user->last_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row['id'] . '" data-original-title="View" class="view btn btn-tools btn-sm viewBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'total_amount', 'total_paid', 'close_date', 'doctor'])
                ->make(true);
        }
        $scheduledClosedPaymentsData = $user->payment_bill()->where('bill_status', 'CLOSED')->latest()->get();
        $page_title = 'Close Bills';
        return view('users.closed.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'scheduledClosedPaymentsData' => $scheduledClosedPaymentsData
        ]);
    }

    public function scheduled_bills(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $user->payment_bill()->where('bill_status', 'CLOSED')->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('full_names', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('total_amount', function ($row) {
                    return number_format($row->total_amount, 2, '.', ',');
                })
                ->addColumn('total_paid', function ($row) {
                    return number_format($row->paid_amount, 2, '.', ',');
                })
                ->addColumn('close_date', function ($row) {
                    if ($row->close_date !== null) {
                        return date('d-M-Y', strtotime($row->close_date));
                    } else {
                        return '';
                    }
                })
                ->addColumn('doctor', function ($row) {
                    if ($row->user_id !== null) {
                        return $row->user->first_name . ' ' . $row->user->last_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row['id'] . '" data-original-title="View" class="view btn btn-tools btn-sm viewBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'full_names', 'total_amount', 'total_paid', 'close_date', 'doctor'])
                ->make(true);
        }
        $page_title = 'Close Bills';
        $scheduledClosedPaymentsData = $user->payment_bill()->where('bill_status', 'CLOSED')->latest()->get();
        $scheduledNotSentToHQClosedPaymentsData = $this->closeBillRepository->getScheduledClosedBillsWhereDocumentHasNotBeenSendToHQ($user);
        $scheduledSentToHQClosedPaymentsData = $this->closeBillRepository->getScheduledClosedBillsWhereDocumentHasBeenSendToHQ($user);
        
        return view('users.closed.my_scheduled', [
            'clinic' => $clinic,
            'page_title' => $page_title,
            'scheduledClosedPaymentsData' => $scheduledClosedPaymentsData,
            'scheduledNotSentToHQClosedPaymentsData' => $scheduledNotSentToHQClosedPaymentsData,
            'scheduledSentToHQClosedPaymentsData' => $scheduledSentToHQClosedPaymentsData,  
        ]);
    }

    public function store(PaymentBill $paymentBill, Request $request)
    {
        # code...
        $data = $request->except("_token");
        $validator = Validator::make($data, [
            'invoice_number' => 'required|numeric',
            'close_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }
        $clinic = $paymentBill->clinic;

        $appointment = $paymentBill->appontment;

        $paymentBill->id = $paymentBill->id;
        $paymentBill->open_date = $paymentBill->open_date;
        $paymentBill->invoice_number = $clinic->initials . '/' . $data['invoice_number'];
        $paymentBill->kra_number = $data['kra_number'];
        $paymentBill->bill_status = 'CLOSED';
        $paymentBill->close_date = $data['close_date'];

        if ($paymentBill->save()) {

            $report_id = $appointment->report_id;

            $report = $clinic->report()->findOrFail($report_id);

            $report->update([
                'bill_status' => $paymentBill->bill_status,
                'bill_closed_date' => $paymentBill->close_date,
            ]);

            $response['status'] = true;
            $response['message'] = 'You have closed this bill';

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
        $paymentAttachments = $paymentBill->payment_attachment()->latest()->get();
        $page_title = trans('users.page.payments.sub_page.view_closed');
        return view('users.closed.view', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
            'payment_bill' => $paymentBill,
            'payment_attachments' => $paymentAttachments
        ]);
    }

    public function update_lpo(PaymentBill $paymentBill, Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'kra_number' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $paymentBill->kra_number = $data['kra_number'];
        $paymentBill->save();

        $response['status'] = true;
        $response['message'] = 'You have updated the KRA ETIMS/ VAT number';

        return response()->json($response, 200);
    }

    public function print(PaymentBill $paymentBill)
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        $page_title = 'Print Closed Bill';
        return view('users.closed.print', [
            'page_title' => $page_title,
            'user' => $user,
            'clinic' => $clinic,
            'payment_bill' => $paymentBill,
        ]);
    }

    public function sendPhysicalDocToHQ(PaymentBill $paymentBill)  
    {
        if($this->closeBillRepository->sendPhysicalDoc($paymentBill))
        {
            return response()->json([
                'status' => true,
                'message' => 'You have successfully send document to HQ'
            ]);
        }
    }

    public function sendMultipleDocsToHQ(SendMultipleDocToHQRequest $request)  
    {
        $data = $request->except("_token");
        $sendDocuments = $this->closeBillRepository->sendMultiplePhysicalDoc($data);
        if($sendDocuments)
        {
            return response()->json([
                'status' => true,
                'message' => 'You have successfully send documents to HQ'
            ]);
        }
    }
}
