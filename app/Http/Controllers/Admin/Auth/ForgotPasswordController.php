<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function index()
    {
        # code...
        $page_title = 'Forgot Password';
        return view('admin.auth.forgot-password', compact('page_title'));
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email|exists:admins,email'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $data['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('admin.mails.forgot-password', ['token' => $token], function($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Forgot Password');
        });

        $response['status'] = true;
        $response['message'] = 'Please check your email for reset password link.';
        return response()->json($response, 200);

    }
}
