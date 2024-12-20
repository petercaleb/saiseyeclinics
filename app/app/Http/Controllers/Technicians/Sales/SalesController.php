<?php

namespace App\Http\Controllers\Technicians\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technicians\Sales\StoreWorkshopSalesRequest;
use App\Mail\TechnicianOrdersMail;
use App\Models\Lens;
use App\Models\Order;
use App\Models\Technician;
use App\Models\WorkshopSale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:technician');   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkshopSalesRequest $request)
    {
        //
        $data = $request->except("_token");

        $lens = Lens::findOrFail($data['lens_id']);

        $quantity = 1;

        $opening = $lens->opening;

        $received = $lens->received;

        $transfered = $lens->transfered;

        $total = $lens->total;

        $sold = $lens->sold;

        $closing = $lens->closing;

        if($closing <= 0 || $closing < $quantity)
        {
            $errors = ['The lens selected are not enough to complete the current task. Please contact the Admin for more help'];
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $sold = $sold + $quantity;

        $closing = $total - $sold;

        $lens->update([
            'opening' => $opening,
            'received' => $received,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing,
        ]);

        $order = Order::findOrFail($data['order_id']);

        $sale = new WorkshopSale;

        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);

        $workshop = $technician->workshop;

        $sale->organization_id = $lens->organization->id;
        $sale->workshop_id = $workshop->id;
        $sale->order_id = $order->id;
        $sale->lens_id = $lens->id;
        $sale->payment_bill_id = $order->payment_bill->id;
        $sale->quantity = $quantity;
        $sale->eye = $lens->hq_lens->eye;

        $sale->save();

        $lens_quantity = $order->quantity + $quantity;

        $appointment = $order->appointment;

        $order->id = $order->id;

        $order->status = $data['status'];

        if($order->status == 'RIGHT LENS GLAZED'){
            $order->right_eye_lens_id = $lens->id;
        }

        if($order->status == 'GLAZED'){
            $order->left_eye_lens_id = $lens->id;
        }

        $order->quantity = $lens_quantity;

        if($order->save())
        {
            $order->order_track()->create([
                'user_id' => $order->doctor_schedule->user->id,
                'workshop_id' => $order->workshop->id,
                'track_date' => Carbon::now()->format('Y-m-d'),
                'track_status' => $order->status,
            ]);

            $clinic = $order->clinic;

            $report_id = $appointment->report_id;
    
            $report = $clinic->report()->findOrFail($report_id);
    
            $report->update([
                'order_status' => $order->status,
            ]);

            if ($order->status == 'GLAZED') {
                $clinic = $order->clinic;
    
                $email = $clinic->email;
    
                $details['title'] = 'Order Details';
                $details['body'] = 'Order has been successfully glazed. The Lens will be sent to you shortly.';
    
                Mail::to($email)->send(new TechnicianOrdersMail($details));
            }
    
            $response = [
                'status' => true,
                'message' => 'New Sale has been successfully registered'
            ];
    
            return response()->json($response, 200);

        }


       

       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkshopSale $workshopSale)
    {
        //
        $order = $workshopSale->order;

        $lens = $workshopSale->lens;

        $eye = $lens->hq_lens->eye;

        $workshopSale->update([
            'eye' => $eye
        ]);

        $response['status'] = true;
        $response['message'] = 'Eye updated';
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
