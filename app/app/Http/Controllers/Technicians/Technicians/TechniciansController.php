<?php

namespace App\Http\Controllers\Technicians\Technicians;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Rules\MatchTechniciansPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TechniciansController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:technician');   
    }

    public function index()
    {
        # code...
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $page_title = "Profile";
        return view('technicians.profile.index', [
            'page_title' => $page_title,
            'technician' => $technician,
        ]);
    }

    public function update(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'phone' => ['required', 'unique:technicians,phone,'.Auth::guard('technician')->user()->id, 'numeric'],
            'email' => 'required|email|unique:technicians,email,'.Auth::guard('technician')->user()->id
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if ($request->hasFile('profile')) {

            // file name with extension
            $profileNameWithExt = $request->file('profile')->getClientOriginalName();

            // Get Filename
            $profileName = pathinfo($profileNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('profile')->getClientOriginalExtension();

            // Filename To store
            $profileNameToStore = $profileName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('profile')->storeAs('public/technicians', $profileNameToStore);
        }

        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);

        $technician->first_name = $data['first_name'];
        $technician->last_name = $data['last_name'];
        if($request->hasFile('profile')){
            $technician->profile = $profileNameToStore;
        }
        $technician->phone = $data['phone'];
        $technician->email = $data['email'];
        $technician->username = $data['username'];

        $technician->save();

        $response['status'] = true;
        $response['message'] = "Your Profile has been successfully updated";
        return response()->json($response, 200);
    }

    public function update_password(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'current_password' => ['required', new MatchTechniciansPassword],
            'new_password' => 'required|min:6|string',
            'confirm_password' => 'required|string|min:6|same:new_password'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);

        $technician->update([
            'password' => Hash::make($data['new_password'])
        ]);

        $response['status'] = true;
        $response['message'] = 'Password updated successfully';
        return response()->json($response, 200);
    }

    public function logout()
    {
        # code...
        Auth::guard('technician')->logout();
        return redirect()->route('technicians.login');
    }
}
