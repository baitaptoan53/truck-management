<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::all();
        return response()->json($maintenances);
    }
    public function store(Request $request)
    {
        $request->validate([
            'truck_id' => 'required',
            'maintenance_date' => 'required|date',
            'description' => 'required',
            'cost' => 'required',
        ]);
        $maintenance = Maintenance::create($request->all());
        return response()->json($maintenance);
    }
    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);
        $maintenance->update($request->all());
        return response()->json($maintenance);
    }
}
