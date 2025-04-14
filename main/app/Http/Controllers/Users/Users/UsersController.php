<?php

namespace App\Http\Controllers\Users\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        # code...
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $page_title = 'User Profile';
        return view('users.user.index', compact('user', 'clinic', 'page_title'));
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:10|unique:users,phone,' . Auth::user()->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'username' => 'required|string|max:255|unique:users,username,' . Auth::user()->id,
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $user = User::findOrFail(Auth::user()->id);

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->username = $data['username'];

        $user->save();

        $response['status'] = true;
        $response['message'] = 'User profile updated successfully';
        return response()->json($response, 200);
    }

    public function update_password(Request $request)
    {
        # code...
        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $user = User::findOrFail(Auth::user()->id);

        $user->id = $user->id;
        $user->password = Hash::make($data['new_password']);

        $user->save();

        $response['status'] = true;
        $response['message'] = 'Password updated successfully';
        return response()->json($response, 200);
    }

    public function logout()
    {
        # code...
        Auth::logout();
        return redirect()->route('users.login');
    }
}
