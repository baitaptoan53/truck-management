<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    public function index()
    {
        // bảng invoices có cột trip_id, bảng trips có cột id tôi muốn lấy tất cả các cột của bảng trips và thêm cả cột total_amount của bảng invoices 
        $trips = Trip::join('invoices', 'trips.id', '=', 'invoices.trip_id')
            ->select('trips.*', 'invoices.total_amount')
            ->get();
    
        return response()->json($trips);
    }
    public function update(Request $request, $id)
    {
        $trip = Trip::find($id);
        $trip->update($request->all());
        dd($trip);
        return response()->json($trip);
    }
}
