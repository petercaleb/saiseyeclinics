<?php

namespace App\Http\Controllers\Users\Lens;

use App\Models\Workshop;
use App\Models\CaseStock;
use App\Models\LensPower;
use App\Models\Treatment;
use App\Models\FrameStock;
use Illuminate\Http\Request;
use App\Models\FramePrescription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Users\Lens\StoreFramePrescriptionRequest;
use App\Http\Requests\Users\Lens\UpdateFramePrescriptionRequest;

class FramePrescriptionsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreFramePrescriptionRequest $request)
    {
        # code...
        $data = $request->all();

        $lens_power = LensPower::findOrFail($data['power_id']);
        $lens_prescription = $lens_power->lens_prescription;
        $workshop = Workshop::findOrFail($data['workshop_id']);
        $frame_stock = FrameStock::findOrFail($data['stock_id']);
        $case_stock = CaseStock::findOrFail($data['case_stock_id']);

        // get cinic through appointment
        $appointment = $lens_power->appointment;

        $clinic = $appointment->clinic;

        // check avalable frame stocks
        $closing = $frame_stock->closing;

        $quantity = 1;


        if($closing <= 0 || $quantity > $closing) {
            $errors = ['No Frame Stocks available for the clinic. Please contact the admin in order to continue'];
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame_prescription = $lens_power->frame_prescription()->create([
            'prescription_id' => $lens_prescription->id,
            'stock_id' => $frame_stock->id,
            'case_stock_id' => $case_stock->id,
            'frame_code' => $frame_stock->hq_stock->frame->code,
            'case_code' => $case_stock->hqStock->frame_case->code,
            'receipt_number' => $clinic->initials.'/'.$data['receipt_number'],
            'workshop_id' => $workshop->id,
            'quantity' => $quantity,
            'remarks' => $data['remarks'],
        ]);

        // update treatment
        $treatment = Treatment::findOrFail($lens_power->treatment->id);

        $treatment->update([
            'frame_prescription_id' => $frame_prescription->id,
            'workshop_id' => $workshop->id,
            'payments' => 'treatment',
            'status' => 'frame prescription'
        ]);

        // update report
        $clinic = $lens_power->diagnosis->clinic;

        $report_id = $appointment->report_id;

        $report = $clinic->report()->findOrFail($report_id);

        $report->update([
            'frame_prescription_id' => $frame_prescription->id,
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame Prescription created successfully';
        return response()->json($response, 200);
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'frame_prescription_id' => 'required|integer|exists:frame_prescriptions,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $frame_prescription = FramePrescription::findOrFail($data['frame_prescription_id']);
        $response['status'] = true;
        $response['data'] = $frame_prescription;

        return response()->json($response, 200);
    }

    public function update(UpdateFramePrescriptionRequest $request)
    {
        # code...
        $data = $request->except('_token');

        $frame_stock = FrameStock::findOrFail($data['stock_id']);

        $workshop = Workshop::findOrFail($data['workshop_id']);

        $frame_prescription = FramePrescription::findOrFail($data['frame_prescription_id']);

        // check avalable frame stocks
        // $closing = $frame_stock->closing;

        $quantity = $frame_prescription->quantity;

        // if($closing <= 0 && $quantity > $closing) {
        //     $errors = ['No Frame Stocks available for the clinic. Please contact the admin in order to continue'];
        //     $response['status'] = false;
        //     $response['errors'] = $errors;
        //     return response()->json($response, 401);
        // }

        $case_stock = CaseStock::findOrFail($data['case_stock_id']);

        $frame_prescription->update([
            'power_id' => $frame_prescription->power_id,
            'prescription_id' => $frame_prescription->prescription_id,
            'stock_id' => $frame_stock->id,
            'case_stock_id' => $case_stock->id,
            'frame_code' => $frame_stock->frame->code,
            'case_code' => $case_stock->hqStock->frame_case->code,
            'receipt_number' => $frame_prescription->receipt_number,
            'workshop_id' => $workshop->id,
            'quantity' => $quantity,
            'remarks' => $data['remarks']
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame Prescription updated successfully';
        return response()->json($response, 200);

    }
}
