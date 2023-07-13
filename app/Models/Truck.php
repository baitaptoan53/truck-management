<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    protected $table = 'truck';
    protected $fillable = [
        'manufacturer',
        'model',
        'year',
        'license_plate',
        'vin_number',
        'purchase_date',
        'registration_date',
        'curent_mileage',
    ];
}

