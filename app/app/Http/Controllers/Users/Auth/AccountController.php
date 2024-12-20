<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index() 
    {
        $page_title = "Account Status";
        return view('users.auth.deactivated-account', [
            'page_title' => $page_title
        ]);    
    }
}
