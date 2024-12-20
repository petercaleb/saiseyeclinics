<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:web');
    }

    public function index($token)
    {
        # code...
        $page_title = 'Reset Password';
        return view('users.auth.reset-password', compact('page_title', 'token'));
    }

    public function store(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 422);
        }

        $update_password = DB::table('password_resets')
            ->where([
                'email' => $data['email'],
                'token' => $data['token']
            ])
            ->first();
        if (!$update_password) {
            $response['status'] = false;
            $response['errors'] = 'Invalid token.';
            return response()->json($response, 422);
        }

        $user = User::where('email', $data['email'])->first();
        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        DB::table('password_resets')->where(['email' => $data['email']])->delete();

        $response['status'] = true;
        $response['message'] = 'Password has been updated.';
        return response()->json($response, 200);
    }
}
