<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\Api\DashboardApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Dashboard API Routes with Filtering
 */
Route::prefix('dashboard')->group(function () {
    // Get dashboard stats with optional filters (region, warehouse, days)
    Route::get('/stats', [DashboardApiController::class, 'getStats']);
});

/**
 * Warehouses API
 */
Route::get('/warehouses', [DashboardApiController::class, 'getWarehouses']);




