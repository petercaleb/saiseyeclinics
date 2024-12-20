<?php

namespace App\Http\Controllers\Users\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $diagnosis = Diagnosis::findOrFail($id);
        if($request->ajax()){
            $data = $diagnosis->medicine->sortBy('created_at', SORT_DESC);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn ='<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="delete btn btn-tools btn-sm deleteMedicineBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'diagnosis_id' => 'required|integer|exists:diagnoses,id',
            'medicine' => 'required|string|max:255',
            'dose' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $diagnosis = Diagnosis::findOrFail($data['diagnosis_id']);

        $diagnosis->medicine()->create([
            'patient_id' => $diagnosis->patient_id,
            'schedule_id' => $diagnosis->schedule_id,
            'medicine' => $data['medicine'],
            'dose' => $data['dose']
        ]);

        $response['status'] = true;
        $response['message'] = 'Medicine added successfully';
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'medicine_id' => 'required|integer|exists:medicines,id'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $medicine = Medicine::findOrFail($data['medicine_id']);

        $response['status'] = true;
        $response['data'] = $medicine;
        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'medicine_id' => 'required|integer|exists:medicines,id'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $medicine = Medicine::findOrFail($data['medicine_id']);
        $medicine->delete();

        $response['status'] = true;
        $response['message'] = 'Medicine deleted successfully';
        return response()->json($response, 200);
    }
}
