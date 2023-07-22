<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $table  = 'maintenance_records';
    protected $fillable = [
        'id',
        'truck_id',
        'maintenance_date',
        'description',
        'cost',
        'created_at',
        'updated_at'
    ];
}
