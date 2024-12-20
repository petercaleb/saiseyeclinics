<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
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
        $page_title = trans('pages.settings.page_title');
        return view('admin.settings.index', [
            'page_title' => $page_title,
            'organization' => $organization,
        ]);
    }
}
