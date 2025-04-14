<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Models\Admin;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BankingRepository;
use App\Repositories\BillingRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Repositories\RemmittanceRepository;
use App\Http\Resources\Organization as ResourcesOrganization;

class OrganizationController extends Controller
{
    //
    private $billingRepository, $remmittanceRepository, $bankingRepository;
    public function __construct(
        BillingRepository $billingRepository,
        RemmittanceRepository $remmittanceRepository,
        BankingRepository $bankingRepository
    )
    {
        $this->middleware('auth:admin');
        $this->billingRepository = $billingRepository;
        $this->remmittanceRepository = $remmittanceRepository;
        $this->bankingRepository = $bankingRepository;
    }

    public function index(Request $request)
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;

        if ($request->ajax()) {
            $data = $organization->clinic()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    return '<img src="' . asset('storage/clinics/' . $row['logo']) . '" class="img-circle img-size-32 mr-2">';
                })
                ->addColumn('select', function ($row) {
                    $selectBtn = '<a href="#" id="' . $row['id'] . '" class="btn btn-sm btn-primary selectBtn">';
                    $selectBtn = $selectBtn . '<i class="fas fa-tachometer-alt"></i> Dashboard</a>';
                    return $selectBtn;
                })
                ->rawColumns(['logo', 'select'])
                ->make(true);
        }
        $page_title = 'Dashboard';
        $workshops = $organization->workshop()->latest()->get();
        $clinics = $organization->clinic()->latest()->get();

        // Billing
        $billings = $this->billingRepository->closed_bills();
        $closedBills = $this->billingRepository->closed_bills();
        $sentToHQ = $this->billingRepository->sentToHq();
        $receivedDOC =  $this->billingRepository->receivedFromClinic();

        // Banking
        $totalSubmittedAmount = $this->remmittanceRepository->getSumSubmittedRemmittance();
        $totalPaid = $this->bankingRepository->getSumAllPaidBanking();
        $totalBalance = $this->bankingRepository->getSumAllBanlancesBanking();
        $bankings = $this->bankingRepository->getAllBanking();

        return view('admin.organization.index', [
            'page_title' => $page_title,
            'organization' => $organization,
            'clinics' => $clinics,
            'workshops' => $workshops,
            'billings' => $billings,
            'closedBills' => $closedBills,
            'sentToHQ' => $sentToHQ,
            'receivedDOC' => $receivedDOC,
            'totalSubmittedAmount' => $totalSubmittedAmount,
            'totalPaid' => $totalPaid,
            'totalBalance' => $totalBalance,
            'bankings' => $bankings,
        ]);
    }


    public function clinics(Request $request)
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if($request->ajax())
        {
            $data = $organization->clinic()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function($row){
                    return '<img src="'.asset('storage/clinics/'.$row['logo']).'" class="img-circle img-size-32 mr-2">';
                })
                ->addColumn('actions', function($row){
                    $selectBtn = '<a href="#" id="'.$row['id'].'" class="btn btn-primary btn-sm selectBtn">';
                    $selectBtn = $selectBtn . '<i class="fas fa-tachometer-alt"></i> Dashboard</a>';
                    return $selectBtn;
                })
                ->rawColumns(['logo', 'actions'])
                ->make(true);
        }
    }

    public function create()
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        if (!$admin->has_organization) {
            return view('admin.organization.create');
        }
        return redirect()->route('admin.organization.index');
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'organization' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = new Organization;

        $organization->admin_id = $admin->id;
        $organization->organization = $data['organization'];
        $organization->tagline = $data['tagline'];
        $organization->logo = 'noimage.png';
        $organization->phone = $data['phone'];
        $organization->email = $data['email'];
        $organization->location = $data['location'];

        if ($organization->save()) {
            $admin->id = $admin->id;
            $admin->has_organization = true;
            $admin->save();

            $response['status'] = true;
            $response['message'] = 'Organization created successfully.';
            return response()->json($response, 200);
        } else {
            $response['status'] = false;
            $response['errors'] = 'Something went wrong.';
            return response()->json($response, 500);
        }
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'organization_id' => 'required|integer|exists:organizations,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $organization = Organization::findOrFail($data['organization_id']);
        return new ResourcesOrganization($organization);
    }

    public function view()
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        return view('admin.organization.view', [
            'organization' => $organization,
        ]);
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'organization_id' => 'required|integer|exists:organizations,id',
            'organization' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        if ($request->hasFile('logo')) {
            // file name with extension
            $logoNameWithExt = $request->file('logo')->getClientOriginalName();

            // Get Filename
            $logoName = pathinfo($logoNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('logo')->getClientOriginalExtension();

            // Filename To store
            $logoNameToStore = $logoName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('logo')->storeAs('public/organization', $logoNameToStore);
        }

        $organization = Organization::findOrFail($data['organization_id']);

        $organization->id = $organization->id;
        $organization->organization = $data['organization'];
        $organization->tagline = $data['tagline'];
        if ($request->hasFile('logo')) {
            $organization->logo = $logoNameToStore;
        }
        $organization->phone = $data['phone'];
        $organization->email = $data['email'];
        $organization->address = $data['address'];
        $organization->location = $data['location'];
        $organization->website = $data['website'];
        $organization->profile = $data['profile'];

        $organization->save();

        $response['status'] = true;
        $response['message'] = 'Organization updated successfully.';
        return response()->json($response, 200);
    }
}
