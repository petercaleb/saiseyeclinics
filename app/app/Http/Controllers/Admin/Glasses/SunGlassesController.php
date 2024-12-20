<?php

namespace App\Http\Controllers\Admin\Glasses;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\SunGlass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SunGlassesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            $data = $clinic->sun_glass()->join('frame_brands', 'frame_brands.id', '=', 'sun_glasses.brand_id')
                ->select('sun_glasses.*', 'frame_brands.title as brand')
                ->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    $photo = '<img src="'.asset('storage/glasses/'.$row->photo).'" alt="'.$row->brand.'" class="img-circle img-size-32 mr-2" width="100px">';
                    return $photo;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="#" data-id="'.$row['id'].'" class="edit btn btn-sm btn-tools updateSunGlassesBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.' <a href="#" data-id="'.$row['id'].'" data-clinic="'.$row['clinic_id'].'" class="btn btn-sm btn-tools deleteSunGlassesBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'photo', 'status'])
                ->make(true);
        }
        $patients = $clinic->patient->count();
        $organization = $clinic->organization;
        $frame_brands = $organization->frame_brand()->orderBy('created_at', 'desc')->get();
        $glasses = $clinic->sun_glass()->latest()->get();
        $colors = $organization->color->sortBy('created_at', SORT_DESC);
        $shapes = $organization->shape->sortBy('created_at', SORT_DESC);
        $sizes = $organization->size->sortBy('created_at', SORT_DESC);
        $page_title = 'Sun Glasses';
        return view('admin.glasses.index', [
            'page_title' => $page_title,
            'patients' => $patients,
            'clinic' => $clinic,
            'frame_brands' => $frame_brands,
            'glasses' => $glasses,
            'colors' => $colors,
            'shapes' => $shapes,
            'sizes' => $sizes,
        ]);
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
            'clinic_id' => 'required|integer|exists:clinics,id',
            'brand_id' => 'required|integer|exists:frame_brands,id',
            'item_code' => 'required|string|max:255|unique:sun_glasses,item_code',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if($request->hasFile('photo')){

            // file name with extension
            $photoNameWithExt = $request->file('photo')->getClientOriginalName();

            // Get Filename
            $photoName = pathinfo($photoNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $request->file('photo')->getClientOriginalExtension();

            // Filename To store
            $photoNameToStore = $photoName . '_' . time() . '.' . $extension;

            // Upload Image
            $path = $request->file('photo')->storeAs('public/glasses', $photoNameToStore);

        }else{
            $photoNameToStore = 'noimage.png';
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $clinic->sun_glass()->create([
            'brand_id' => $data['brand_id'],
            'item_code' => $data['item_code'],
            'photo' => $photoNameToStore,
            'status' => $data['status'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Sun Glasses Created Successfully';

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
            'glass_id' => 'required|integer|exists:sun_glasses,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $sun_glass = SunGlass::findOrFail($data['glass_id']);

        $response['status'] = true;
        $response['data'] = $sun_glass;

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'glass_id' => 'required|integer|exists:sun_glasses,id',
            'clinic_id' => 'required|integer|exists:clinics,id',
            'brand_id' => 'required|integer|exists:frame_brands,id',
            'item_code' => 'required|string|max:255|unique:sun_glasses,item_code,'.$data['glass_id'],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        if($request->hasFile('photo')){
            // file name with extension
            $photoNameWithExt = $request->file('photo')->getClientOriginalName();
            // Get Filename
            $photoName = pathinfo($photoNameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('photo')->getClientOriginalExtension();
            // Filename To store
            $photoNameToStore = $photoName . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('photo')->storeAs('public/glasses', $photoNameToStore);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $sun_glass = $clinic->sun_glass()->findOrFail($data['glass_id']);

        if($request->hasFile('photo')){
            if($sun_glass->photo != 'noimage.png'){
                Storage::delete('public/glasses/'.$sun_glass->photo);
            }
            $sun_glass->photo = $photoNameToStore;
        }

        $sun_glass->update([
            'brand_id' => $data['brand_id'],
            'item_code' => $data['item_code'],
            'status' => $data['status'],
        ]);

        $response['status'] = true;

        $response['message'] = 'Sun Glasses Updated Successfully';

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
            'glass_id' => 'required|integer|exists:sun_glasses,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $sun_glass = $clinic->sun_glass()->findOrFail($data['glass_id']);

        if($sun_glass->photo != 'noimage.png'){
            Storage::delete('public/glasses/'.$sun_glass->photo);
        }

        $sun_glass->delete();

        $response['status'] = true;
        $response['message'] = 'Sun Glasses Deleted Successfully';

        return response()->json($response, 200);
    }
}
