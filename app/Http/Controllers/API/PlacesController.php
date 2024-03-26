<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Truck;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    public function index()
    {
        $places = Place::all();
        return response()->json($places);
    }
    public function store(Request $request){
        $request-> validate([
            'name' => 'required|unique:places',
            'address' => 'required',
            'description' => 'required',
        ]);
        $place = Place::create($request->all());
        return response()->json([
            'message' => 'Place created successfully',
            'place' => $place
        ]);
    }
    public function update(Request $request, $id)
    {
        $place = Place::find($id);
        $place->update($request->all());
        return response()->json($place);
    }
    public function delete($id)
    {
        $place = Place::find($id);
        $place->delete();
        return response()->json('Place deleted successfully');
    }
}
