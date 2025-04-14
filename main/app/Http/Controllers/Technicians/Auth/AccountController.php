<?php

namespace App\Http\Controllers\Technicians\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    public function index() 
    {
        $page_title = "Account";    
        return view('technicians.auth.account', [
            'page_title' => $page_title
        ]);
    }
}
