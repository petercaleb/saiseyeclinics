<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:web');
    }

    public function index()
    {
        # code...
        $page_title = 'Log In';
        return view('users.auth.login', compact('page_title'));
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ], [
            'email.exists' => 'Email Address was not found',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        $remember_me = $request->has('remember') ? true : false;

        if(Auth::attempt($credentials, $remember_me)){
            $response['status'] = true;
            $response['message'] = 'Login Successful';
            return response()->json($response, 200);
        }else{
            $response['status'] = false;
            $response['errors'] = ['Email address and password entered is invalid. Please check and try again..!'];
            return response()->json($response, 401);
        }
    }
}
