<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $table = 'trips';
    protected $fillable = [
        'id',
        'user_id',
        'truck_id',
        'start_date',
        'end_date',
        'start_location',
        'end_location',
        'status',
        'created_at',
        'updated_at',
    ];
    public function trip_invoice()
    {
        return $this->ha(Invoice::class);
    }
}
