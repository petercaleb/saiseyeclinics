<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class InventoryController extends Controller
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
    public function index($id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        $organization = $clinic->organization;
        $patients = $clinic->patient->count();
        $page_title = "inventory";
        $sub_page = "frames";
        $num_frame_stocks = $clinic->frame_stock->count(); // number of frame stocks
        $num_frame_purchases = $clinic->frame_purchase->count(); // num of frame purchases
        $num_transfers = $clinic->frame_transfer_from->count(); // num of frame transfers
        $frame_colors = $organization->frame_color->sortBy('created_at', SORT_DESC);
        $frame_shapes = $organization->frame_shape->sortBy('created_at', SORT_DESC);
        $frames = $organization->frame->sortBy('created_at', SORT_DESC);
        $stocks = $clinic->frame_stock->sortBy('created_at', SORT_DESC); //Load all stocks to get entered stock frame code for purchase
        $transfer_stocks = $clinic->frame_stock->where('closing_stock', '>', 0)->sortBy('created_at', SORT_DESC); // Get the available stocks before transfer
        $transfer_doctors = $clinic->user->sortBy('created_at', SORT_DESC);
        $clinics = $organization->clinic->where('id', '!=', $clinic->id)->sortBy('created_at', SORT_DESC);
        $transfers_to_current_clinc = $clinic->frame_transfer_to()->latest()->get();
        return view('admin.inventory.index', [
            'page_title' => $page_title,
            'sub_page' => $sub_page,
            'clinic' => $clinic,
            'organization' => $organization,
            'patients' => $patients,
            'num_stocks' => $num_frame_stocks,
            'num_purchases' => $num_frame_purchases,
            'num_transfers' => $num_transfers,
            'frame_colors' => $frame_colors,
            'frame_shapes' => $frame_shapes,
            'clinic_frames' => $frames,
            'stocks' => $stocks,
            'transfer_clinics' => $clinics,
            'transfer_stocks' => $transfer_stocks,
            'transfer_doctors' => $transfer_doctors,
            'transfers_to_current_clinic' => $transfers_to_current_clinc
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
