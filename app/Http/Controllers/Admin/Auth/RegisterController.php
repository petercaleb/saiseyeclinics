<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:admins,phone',
            'email' => 'required|string|email|max:255|unique:admins,email',
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:password',
            'terms' => 'required',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        if($data['terms'] != 'agree'){
            $response['status'] = false;
            $errors = [
                'terms' => 'You must agree to the terms and conditions.'
            ];
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $admin = new Admin;

        $admin->first_name = $data['first_name'];
        $admin->last_name = $data['last_name'];
        $admin->profile = 'noimage.png';
        $admin->phone = $data['phone'];
        $admin->email = $data['email'];
        $admin->username = $data['username'];
        $admin->password = Hash::make($data['password']);

        $admin->save();
        event(new Registered($admin));
        Auth::guard('admin')->login($admin);

        $response['status'] = true;
        $response['message'] = 'Account created successfully';
        return response()->json($response, 200);

    }
}
