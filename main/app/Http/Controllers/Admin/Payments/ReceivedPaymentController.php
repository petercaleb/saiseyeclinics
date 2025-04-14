<?php

namespace App\Http\Controllers\Admin\Payments;

use App\Exports\Banking\ReceivedPaymentsExport;
use App\Models\ReceivedPayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceivedPaymentRequest;
use App\Http\Requests\UpdateReceivedPaymentRequest;
use App\Repositories\ReceivedPaymentRepository;

class ReceivedPaymentController extends Controller
{

    private $receivedPaymentRepository;

    public function __construct(ReceivedPaymentRepository $receivedPaymentRepository)
    {
        $this->middleware('auth:admin');
        $this->receivedPaymentRepository = $receivedPaymentRepository;
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
     * Export a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()  
    {
        return (new ReceivedPaymentsExport())->download('received-payments-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReceivedPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceivedPaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceivedPayment  $receivedPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ReceivedPayment $receivedPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceivedPayment  $receivedPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceivedPayment $receivedPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceivedPaymentRequest  $request
     * @param  \App\Models\ReceivedPayment  $receivedPayment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceivedPaymentRequest $request, ReceivedPayment $receivedPayment)
    {
        //
        $data = $request->except("_token");
        $payments = $this->receivedPaymentRepository->updatePaidAmountReceivedPayments($data, $receivedPayment);
        if($payments)
        {
            return response()->json([
                'status' => true,
                'message' => 'You have successfully updated the paid amount'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceivedPayment  $receivedPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceivedPayment $receivedPayment)
    {
        //
    }
}
