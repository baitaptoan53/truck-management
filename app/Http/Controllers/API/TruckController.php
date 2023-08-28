<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::all();
        return response()->json($trucks);
    }
    public function store(Request $request)
    {
        $truck = Truck::create([
            'manufacturer' => $request->manufacturer,
            'model' => $request->model,
            'year' => $request->year,
            'license_plate' => $request->license_plate,
            'vin_number' => $request->vin_number,
            'purchase_date' => $request->purchase_date,
            'registration_date' => $request->registration_date,
            'curent_mileage' => $request->curent_mileage,
        ]);
        return response()->json([
            'message' => 'Truck created successfully',
        ]);
    }
    public function update(Request $request, $id)
    {
        $truck = Truck::find($id);
        $truck->update($request->all());
        return response()->json($truck);
    }
    public function delete($id)
    {
        $truck = Truck::find($id);
        $truck->delete();
        return response()->json('Truck deleted successfully');
    }
}
