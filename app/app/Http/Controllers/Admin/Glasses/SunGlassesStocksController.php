<?php

namespace App\Http\Controllers\Admin\Glasses;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Color;
use App\Models\Shape;
use App\Models\Size;
use App\Models\SunGlass;
use App\Models\SunGlassStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SunGlassesStocksController extends Controller
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
        if($request->ajax()){
            $data = $clinic->sun_glass_stock()->join('sun_glasses', 'sun_glasses.id', '=', 'sun_glass_stocks.glass_id')
                ->join('colors', 'sun_glass_stocks.color_id', '=', 'colors.id')
                ->join('shapes', 'sun_glass_stocks.shape_id', '=', 'shapes.id')
                ->join('sizes', 'sun_glass_stocks.size_id', '=', 'sizes.id')
                ->select('sun_glass_stocks.*', 'sun_glasses.item_code', 'colors.color', 'shapes.shape', 'sizes.size')
                ->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="#" data-clinic="'.$row['clinic_id'].'" data-id="'.$row['id'].'" class="delete btn btn-tools btn-sm deleteStockBtn"><i class="fa fa-trash"></i></a>';
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
            'clinic_id' => 'required|integer|exists:clinics,id',
            'glass_id' => 'required|integer|exists:sun_glasses,id',
            'color_id' => 'required|integer|exists:colors,id',
            'gender'=> 'required|string',
            'shape_id' => 'required|integer|exists:shapes,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'opening_stock' => 'required|integer',
            'price' => 'required|numeric',
            'supplier_price' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $sun_glass = SunGlass::findOrFail($data['glass_id']);

        $color = Color::findOrFail($data['color_id']);

        $shape = Shape::findOrFail($data['shape_id']);

        $size = Size::findOrFail($data['size_id']);

        $opening_stock = $data['opening_stock'];

        $purchased_stock = 0;

        $total_stock = $opening_stock + $purchased_stock;

        $sold_stock = 0;

        $closing_stock = $total_stock - $sold_stock;

        $sun_glass->sun_glass_stock()->create([
            'clinic_id' => $clinic->id,
            'color_id' => $color->id,
            'gender' => $data['gender'],
            'shape_id' => $shape->id,
            'size_id' => $size->id,
            'opening_stock' => $opening_stock,
            'purchase_stock' => $purchased_stock,
            'total_stock' => $total_stock,
            'sold_stock' => $sold_stock,
            'closing_stock' => $closing_stock,
            'price' => $data['price'],
            'supplier_price' => $data['supplier_price'],
            'remarks' => $data['remarks'],
        ]);

        $response['status'] = true;
        $response['message'] = 'Stock added successfully';

        return response()->json($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'stock_id' => 'required|integer|exists:sun_glass_stocks,id',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $stock = SunGlassStock::findOrFail($data['stock_id']);
        $stock->delete();

        $response['status'] = true;
        $response['message'] = 'Stock deleted successfully';

        return response()->json($response, 200);
    }
}
