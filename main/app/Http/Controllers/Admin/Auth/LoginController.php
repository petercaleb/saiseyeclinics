<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function store(LoginRequest $request)
    {
        # code...
        $data = $request->except("_token");

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        $remember_me = $request->has('remember') ? true : false;

        if(Auth::guard('admin')->attempt($credentials, $remember_me)){
            $response['status'] = true;
            $response['message'] = 'Login Successful';
            return response()->json($response, 200);
        }else{
            $response['status'] = false;
            $response['errors'] = ['mail address and password entered is invalid. Please check and try again..!'];
            return response()->json($response, 401);
        }
    }
}
