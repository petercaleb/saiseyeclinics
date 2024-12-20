<?php

namespace App\Http\Controllers\Users\ClientType;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function show(Request $request)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'type_id' => 'required|integer|exists:client_types,id'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $client_type = ClientType::findOrFail($data['type_id']);

        $response['status'] = true;
        $response['data'] = $client_type;

        return response()->json($response);
    }
}
