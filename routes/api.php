<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InvoicesController;
use App\Http\Controllers\API\MaintenanceController;
use App\Http\Controllers\API\TripsController;
use App\Http\Controllers\API\TruckController;
use App\Http\Controllers\API\UsersController;
use App\Models\Invoice;
use App\Models\Trip;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
});
Route::controller(UsersController::class)->group(function () {
    Route::get('/users', 'users');
    Route::put('/users/{id}', 'update');
    Route::delete('/users/{id}', 'delete');
});
Route::controller(InvoicesController::class)->group(function () {
    Route::get('/invoices', 'index');
});
Route::controller(TruckController::class)->group(function () {
    Route::get('/trucks', 'index');
    Route::post('/trucks', 'store');
    Route::put('/trucks/{id}', 'update');
    Route::delete('/trucks/{id}', 'delete');
});
Route::controller(TripsController::class)->group(function () {
    Route::get('/trips', 'index');
    Route::put('/trips/{id}', 'update');
    Route::post('/trips', 'store');
});

Route::controller(MaintenanceController::class)->group(function () {
    Route::get('/maintenances', 'index');
    Route::post('/maintenances', 'store');
    Route::put('/maintenances/{id}', 'update');
});
