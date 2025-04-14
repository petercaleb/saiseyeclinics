<?php

namespace App\Http\Controllers\Admin\Payments;

use App\Exports\Banking\BankingPaymentsExport;
use App\Exports\Banking\PaymentExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankingRequest;
use App\Repositories\BankingRepository;
use App\Repositories\ClinicsRepository;
use App\Repositories\InsurancesRepository;
use App\Repositories\RemmittanceRepository;

class BankingController extends Controller
{

    private $bankingRepository, $remmittanceRepository, $insurancesRepository, $clinicsRepository;
    public function __construct(
        BankingRepository $bankingRepository,
        RemmittanceRepository $remmittanceRepository,
        InsurancesRepository $insurancesRepository,
        ClinicsRepository $clinicsRepository
    )
    {
        $this->middleware('auth:admin');
        $this->bankingRepository = $bankingRepository;
        $this->remmittanceRepository = $remmittanceRepository;
        $this->insurancesRepository = $insurancesRepository;
        $this->clinicsRepository = $clinicsRepository;
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
            if (!empty($filter_data['clinic_id']) && !empty($filter_data['insurance_id']))
            {
                $submitted = $this->remmittanceRepository->getSubmittedForClinicAndInsurance($filter_data);
            }
            else if(!empty($filter_data['clinic_id']) && empty($filter_data['insurance_id']))
            {
                $submitted = $this->remmittanceRepository->getSubmittedRemmittanceForClinic($filter_data);
            }
            else if(empty($filter_data['clinic_id']) && !empty($filter_data['insurance_id']))
            {
                $submitted = $this->remmittanceRepository->getSubmittedRemmittanceForInsurance($filter_data);
            }
            else
            {
                $submitted = $this->remmittanceRepository->getSubmiited();
            }

        }else{
            $submitted = $this->remmittanceRepository->getSubmiited();
        }
        $data = $this->bankingRepository->getAllBanking();
        $insuranceData = $this->insurancesRepository->getAllInsurance();
        $receivedRemmittanceData = $this->remmittanceRepository->getReceived();
        $clinics = $this->clinicsRepository->getAllClinics();
        $totalSubmittedAmount = $this->remmittanceRepository->getSumSubmittedRemmittance();
        $totalPaid = $this->bankingRepository->getSumAllPaidBanking();
        $totalBalance = $this->bankingRepository->getSumAllBanlancesBanking();
        return view('admin.main.banking.index', [
            'data' => $data,
            'submitted' => $submitted,
            'insuranceData' => $insuranceData,
            'rceivedRemmittanceData' => $receivedRemmittanceData,
            'clinics' => $clinics,
            'totalSubmittedAmount' => $totalSubmittedAmount,
            'totalPaid' => $totalPaid,
            'totalBalance' => $totalBalance,
            'filtered_data' => $filter_data
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        return (new BankingPaymentsExport())->download('payments-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Pill remmittances for insurance.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRemmittanceForInsurance($id)
    {
        //
        $remmittanceData = $this->insurancesRepository->getRemmittanceForInsurance($id);
        return response()->json([
            'status' => true,
            'data' => $remmittanceData
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankingRequest $request)
    {
        //
        $data = $request->except("_token");
        $banking = $this->bankingRepository->storeBanking($data);
        if($banking)
        {
            return response()->json([
                'status' => true,
                'message' => 'Banking created successfully',
                'bank_id' => $banking->id
            ]);
        }

        return response()->json([
            'status' => false,
            'error' => 'Something went wrong'
        ]);
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
        $banking = $this->bankingRepository->show($id);
        return response()->json([
            'status' => true,
            'data' => $banking
        ]);
    }

    public function exportIndividual($id)
    {
        $banking = $this->bankingRepository->show($id);
        return  (new PaymentExport($banking->id))->download('individual-payments-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data =  $this->bankingRepository->show($id);
        return view('admin.main.banking.view', [
            'data' => $data
        ]);
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
