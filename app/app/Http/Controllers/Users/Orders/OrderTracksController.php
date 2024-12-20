<?php

namespace App\Http\Controllers\Users\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTrack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderTracksController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $order = Order::findOrFail($data['order_id']);

        $updated_date = $order->updated_at;

        $now = Carbon::now();

        $diffDays = $updated_date->diffInDays($now);

        $order->order_track()->create([
            'user_id' => $order->doctor_schedule->user->id,
            'workshop_id' => $order->workshop->id,
            'track_date' => $order->order_date,
            'track_status' => $order->status,
            'tat' => $diffDays,
        ]);

        $response['status'] = true;
        $response['message'] = 'Order created successfully';
        return response()->json($response, 200);

    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'track_id' => 'required|integer|exists:order_tracks,id'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $track = OrderTrack::findOrFail($data['track_id']);

        $response['status'] = true;
        $response['data'] = $track;

        return response()->json($response, 200);
    }
}
