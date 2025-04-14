<?php

namespace App\Http\Controllers\Admin\Settings\Workshops;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopSettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth:admin']);   
    }

    public function index()
    {
        # code...
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $page_title = 'Workshop Settings';
        return view('admin.settings.workshops.index', [
            'page_title' => $page_title,
            'organization' => $organization,
        ]);
    }
}
