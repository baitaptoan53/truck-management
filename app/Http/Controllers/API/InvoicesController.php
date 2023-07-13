<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Trip;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index()
    {

        $invoices = Invoice::join('trips', 'invoices.trip_id', '=', 'trips.id')
            ->select('invoices.*','trips.start_date', 'trips.end_date', 'trips.start_location', 'trips.end_location',
                'trips.total_distance')
            ->get();
        return response()->json($invoices);

    }
}
