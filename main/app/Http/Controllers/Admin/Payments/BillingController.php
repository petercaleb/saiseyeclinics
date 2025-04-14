<?php

namespace App\Http\Controllers\Admin\Payments;

use App\Models\Clinic;
use App\Models\PaymentBill;
use App\Models\Remmittance;
use Illuminate\Http\Request;
use App\Enums\DocumentStatus;
use App\Enums\RemmittanceStatus;
use App\Http\Controllers\Controller;
use App\Exports\Billing\ExportBilling;
use App\Repositories\BillingRepository;
use App\Repositories\ClinicsRepository;
use App\Repositories\InsurancesRepository;
use App\Http\Requests\Admin\Billing\StoreRemmittanceRequest;
use App\Http\Requests\Admin\Billing\ReceiveMultipleDocumentsRequest;

class BillingController extends Controller
{

    private $billingRepository, $clinicsRepository, $insurancesRepository;

    public function __construct(
        InsurancesRepository $insurancesRepository,
        ClinicsRepository $clinicsRepository,
        BillingRepository $billingRepository
    )
    {
        $this->middleware('auth:admin');
        $this->insurancesRepository = $insurancesRepository;
        $this->clinicsRepository = $clinicsRepository;
        $this->billingRepository = $billingRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $filter_data = [];
        if ($request->_token) {
            $filter_data = $request->except('_token');
            if (!empty($filter_data['clinic_id']) && !empty($filter_data['insurance_id'])) {
                $data = $this->billingRepository->closed_bills_for_clinic_and_insurance($filter_data);
                $closedBills = $this->billingRepository->closed_bills_for_clinic_and_insurance($filter_data);
                $sentToHQ = $this->billingRepository->sentToHqForClinicAndInsurance($filter_data);
                $receivedDOC =  $this->billingRepository->receivedFromClinicForClinicAndInsurance($filter_data);
            }
            else if(!empty($filter_data['clinic_id']) && empty($filter_data['insurance_id']))
            {
                $data = $this->billingRepository->closed_bills_for_clinic($filter_data);
                $closedBills = $this->billingRepository->closed_bills_for_clinic($filter_data);
                $sentToHQ = $this->billingRepository->sentToHqForClinic($filter_data);
                $receivedDOC =  $this->billingRepository->receivedFromClinicForClinic($filter_data);
            }
            else if(empty($filter_data['clinic_id']) && !empty($filter_data['insurance_id']))
            {
                $data = $this->billingRepository->closed_bills_for_insurance($filter_data);
                $closedBills = $this->billingRepository->closed_bills_for_insurance($filter_data);
                $sentToHQ = $this->billingRepository->sentToHqForInsurance($filter_data);
                $receivedDOC =  $this->billingRepository->receivedFromClinicForInsurance($filter_data);
            }
            else
            {
                $data = $this->billingRepository->closed_bills();
                $closedBills = $this->billingRepository->closed_bills();
                $sentToHQ = $this->billingRepository->sentToHq();
                $receivedDOC =  $this->billingRepository->receivedFromClinic();
            }
        } else {
            $data = $this->billingRepository->closed_bills();
            $closedBills = $this->billingRepository->closed_bills();
            $sentToHQ = $this->billingRepository->sentToHq();
            $receivedDOC =  $this->billingRepository->receivedFromClinic();
        }
        $clinics = $this->clinicsRepository->getAllClinics();
        $insuranceData = $this->insurancesRepository->getAllInsurance();
        return view('admin.main.billing.index', [
            'closedBills' => $closedBills,
            'sentToHQ' => $sentToHQ,
            'receivedDOC' => $receivedDOC,
            'data' => $data,
            'clinics' => $clinics,
            'insuranceData' => $insuranceData,
            'filtered_data' => $filter_data
        ]);
    }


    /**
     * Export the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        return (new ExportBilling())
            ->download('billing-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receiveDocument(PaymentBill $paymentBill)
    {
        //
        if ($this->billingRepository->receiveDocument($paymentBill)) {
            return response()->json([
                'status' => true,
                'message' => 'You have successfully received document sent to HQ'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemmittanceRequest $request)
    {
        //
        $data = $request->except("_token");
        $remmittance = $this->billingRepository->storeRemmittance($data);
        if ($remmittance) {
            return response()->json([
                'status' => true,
                'message' => 'Remmittance for payments under client type insurance hve been created waiting for submision'
            ]);
        }
    }

    /**
     * Receive multiple documents a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function receiveMultipleDocuments(ReceiveMultipleDocumentsRequest $request)
    {
        $data = $request->except("_token");
        $receiveDocuments = $this->billingRepository->receiveMultipleDocuments($data);
        if ($receiveDocuments) {
            return response()->json([
                'status' => true,
                'message' => 'You have successfully received multiple documents sent to HQ'
            ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
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
