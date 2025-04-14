<?php

namespace App\Http\Controllers\Technicians\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technicians\Orders\UpdateOrderRequest;
use App\Mail\TechnicianOrdersMail;
use App\Models\LensType;
use App\Models\Order;
use App\Models\Technician;
use App\Models\WorkshopSale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:technician');
    }


    public function index(Request $request)
    {
        # code...
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            if (!empty($request->status)) {
                $data = $workshop->order->where('status', '!=', 'APPROVED')->where('status', '=', $request->status)->sortBy('created_at', SORT_DESC);
            } else {
                $data = $workshop->order->where('status', '!=', 'APPROVED')->sortBy('created_at', SORT_DESC);
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('patient', function ($row) {
                    $patient = $row->patient->first_name . " " . $row->patient->last_name;
                    return $patient;
                })
                ->addColumn('clinic', function ($row) {
                    $clinic = $row->clinic->clinic;
                    return $clinic;
                })
                ->addColumn('view', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="View" class="view btn btn-tools btn-sm viewOrderBtn"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['view', 'patient', 'clinic'])
                ->make(true);
        }
        $page_title = trans('pages.technicians.orders.title');
        return view('technicians.orders.index', [
            'page_title' => $page_title,
            'workshop' => $workshop
        ]);
    }

    public function show($id)
    {
        # code...
        $order = Order::findOrFail($id);

        $response = [
            'status' => true,
            'data' => $order
        ];

        return response()->json($response);
    }

    public function view($id)
    {
        # code...
        $order = Order::findOrFail($id);

        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);

        if ($order->technician_id == null) {
            $order->update([
                'technician_id' => $technician->id
            ]);
        }


        $workshop = $technician->workshop;
        $right_eye_lenses = $workshop->lens->where('eye', 'RIGHT')->sortBy('created_at', SORT_DESC);
        $left_eye_lenses = $workshop->lens->where('eye', 'LEFT')->sortBy('created_at', SORT_DESC);
        $sales = $order->workshop_sale->sortBy('created_at', SORT_DESC);
        // request for lens
        $organization = $workshop->organization;
        $types = $organization->lens_type()->latest()->get();
        $lens_materials = $organization->lens_material->sortBy('created_at', SORT_DESC);
        $page_title = trans('pages.technicians.orders.title');
        return view('technicians.orders.view', [
            'page_title' => $page_title,
            'order' => $order,
            'right_eye_lenses' => $right_eye_lenses,
            'left_eye_lenses' => $left_eye_lenses,
            'sales' => $sales,
            'types' => $types,
            'materials' => $lens_materials,
            'workshop' => $workshop,
            'oeganization' => $organization
        ]);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        # code...
        $data = $request->all();

        $order = Order::findOrFail($id);

        $last_order_truck = $order->order_track()->latest()->first();

        $now = Carbon::now();

        $diffInDays = $last_order_truck->created_at->diffInDays($now);

        $appointment = $order->appointment;

        $order->id = $order->id;

        $order->technician_id = auth()->guard('technician')->user()->id;

        $order->status = $data['status'];

        if ($order->status == 'ORDER RECEIVED') {

            $clinic = $order->clinic;

            $email = $clinic->email;

            $details['title'] = 'Order Details';
            $details['body'] = 'An order has been received from your clinic successfully.';

            Mail::to($email)->send(new TechnicianOrdersMail($details));
        }

        if ($order->status == 'FRAME RECEIVED') {

            $clinic = $order->clinic;

            $email = $clinic->email;

            $details['title'] = 'Order Details';
            $details['body'] = 'Frame has been received from your clinic successfully.';

            Mail::to($email)->send(new TechnicianOrdersMail($details));
        }

        if ($order->status == 'SEND TO CLINIC') {


            if ($order->right_eye_lens_id == null) {
                $sales = $order->workshop_sale()->where('eye', 'RIGHT')->first();
                $qty = $sales->quantity + $order->quantity;
                $order->update([
                    'right_eye_lens_id' => $sales->lens_id,
                    'quantity' => $qty,
                ]);
            }

            if ($order->left_eye_lens_id == null) {
                $sales = $order->workshop_sale()->where('eye', 'LEFT')->first();
                $qty = $sales->quantity + $order->quantity;
                $order->update([
                    'left_eye_lens_id' => $sales->lens_id,
                    'quantity' => $qty,
                ]);
            }

            $clinic = $order->clinic;

            $email = $clinic->email;

            $details['title'] = 'Order Details';
            $details['body'] = 'Job Has Been successfully sent back to the clinic. Please Check to continue';

            Mail::to($email)->send(new TechnicianOrdersMail($details));
        }


        if ($order->save()) {

            $order = Order::findOrFail($order->id);

            $order->order_track()->create([
                'user_id' => $order->doctor_schedule->user->id,
                'workshop_id' => $order->workshop->id,
                'track_date' => Carbon::now()->format('Y-m-d'),
                'track_status' => $order->status,
                'tat' => $diffInDays,
            ]);

            $clinic = $order->clinic;

            $report_id = $appointment->report_id;

            $report = $clinic->report()->findOrFail($report_id);

            $report->update([
                'order_status' => $order->status,
            ]);

            $response['status'] = true;
            $response['message'] = 'Order updated successfully';
            return response()->json($response, 200);
        } else {
            $response['status'] = false;
            $response['errors'] = 'Something went wrong';
            return response()->json($response, 401);
        }
    }
}
