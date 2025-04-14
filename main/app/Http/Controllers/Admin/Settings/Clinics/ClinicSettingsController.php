<?php

namespace App\Http\Controllers\Admin\Settings\Clinics;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClinicSettingsController extends Controller
{
    //
    public function __construct()
    {
         $this->middleware('auth:admin');
    }

    public function index()
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $page_title = 'Clinic Settings';
        return view('admin.settings.index', [
            'page_title' => $page_title,
            'organization' => $organization,
        ]);
    }

}
