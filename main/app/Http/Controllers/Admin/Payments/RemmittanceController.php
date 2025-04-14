<?php

namespace App\Http\Controllers\Admin\Payments;

use PDF;
use Carbon\Carbon;
use App\Models\Remmittance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ClinicsRepository;
use App\Repositories\InsurancesRepository;
use App\Repositories\RemmittanceRepository;
use App\Exports\Remmittance\ExportRemmittance;
use App\Http\Requests\StoreRemmittanceRequest;
use App\Exports\Remmittance\PendingSubmissionExport;
use App\Exports\Remmittance\SubmittedRemmittanceExport;
use App\Http\Requests\Admin\Billing\UpdateRemmittanceRequest;

class RemmittanceController extends Controller
{

    private $remmittanceRepository, $clinicsRepository, $insurancesRepository;
    public function __construct(
        RemmittanceRepository $remmittanceRepository,
        ClinicsRepository $clinicsRepository,
        InsurancesRepository $insurancesRepository
    ) {
        $this->middleware('auth:admin');
        $this->remmittanceRepository = $remmittanceRepository;
        $this->clinicsRepository = $clinicsRepository;
        $this->insurancesRepository = $insurancesRepository;
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
                $data = $this->remmittanceRepository->getAllRemmittanceForClinicAndInsurance($filter_data);
                $pending = $this->remmittanceRepository->getPendingForClinicAndInsurance($filter_data);
                $submitted = $this->remmittanceRepository->getSubmittedForClinicAndInsurance($filter_data);
            } else if (!empty($filter_data['clinic_id']) && empty($filter_data['insurance_id'])) {
                $data = $this->remmittanceRepository->getAllRemmittanceForClinic($filter_data);
                $pending = $this->remmittanceRepository->getPendingRemmittanceForClinic($filter_data);
                $submitted = $this->remmittanceRepository->getSubmittedRemmittanceForClinic($filter_data);
            } else if (empty($filter_data['clinic_id']) && !empty($filter_data['insurance_id'])) {
                $data = $this->remmittanceRepository->getAllRemmittanceForInsurance($filter_data);
                $pending = $this->remmittanceRepository->getPendingRemmittanceForInsurance($filter_data);
                $submitted = $this->remmittanceRepository->getSubmittedRemmittanceForInsurance($filter_data);
            } else {
                $data = $this->remmittanceRepository->getAll();
                $pending = $this->remmittanceRepository->getPending();
                $submitted = $this->remmittanceRepository->getSubmiited();
            }
        } else{
            $data = $this->remmittanceRepository->getAll();
            $pending = $this->remmittanceRepository->getPending();
            $submitted = $this->remmittanceRepository->getSubmiited();
        }
        $clinics  = $this->clinicsRepository->getAllClinics();
        $insurances = $this->insurancesRepository->getAllInsurance();
        return view('admin.main.remmittance.index', [
            'data' => $data,
            'pending' => $pending,
            'submitted' => $submitted,
            'clinics' => $clinics,
            'insurances' => $insurances,
            'filtered_data' => $filter_data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        //
        return (new ExportRemmittance())->download('remmittance-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPendingSubmission()
    {
        return (new PendingSubmissionExport())->download('pending-submission-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportSubmittedSubmission()
    {
        return (new SubmittedRemmittanceExport())->download('submitted-submission-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRemmittanceRequest  $request
     * @param  \App\Models\Remmittance  $remmittance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRemmittanceRequest $request)
    {
        //
        $data = $request->except("_token");
        $remmittance = $this->remmittanceRepository->updateMultipleRemmittance($data);
        if ($remmittance) {
            // Generate a unique code
            $uniqueCode = uniqid();
            $date = Carbon::now()->format('d/m/Y');
            $remmittance_date = Carbon::now()->format('Y-m-d');
            $remmittance_id = $data['remmittance_id'];
            $remmittances = Remmittance::whereIn('id', $remmittance_id)->get();
            // $data = [
            //     'title' => 'Submitted Remmittance',
            //     'date' => $date,
            //     'unique_code' => $uniqueCode,
            //     'remmittances' => $remmittances
            // ];

            // // Generate PDF
            // $pdf = PDF::loadView('admin/main/remmittance/pdf', $data);

            // // Save or download the PDF
            // return $pdf->download('remmittance.pdf');
            return response()->json([
                'status' => true,
                'message' => 'You have successfully submitted remittance'
            ], 200);
        }
    }
}
