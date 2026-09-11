<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\WarehouseActivityController;
use App\Http\Controllers\NvrController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\NmsCameraController;
use App\Http\Controllers\NmsAreaController;
use App\Http\Controllers\MasterAlertController;
use App\Http\Controllers\SackController;
use App\Http\Controllers\FrsController;
use App\Http\Controllers\IotDropdownController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CameraAlertController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\RegionWarehousesController;
use App\Http\Controllers\NmsPagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CctvRedirectController;
use App\Http\Controllers\GasAlertController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ----------------------------------------------------
// Public Home
// ----------------------------------------------------
Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});

// ----------------------------------------------------
// Authenticated Routes
// ----------------------------------------------------
Route::middleware(['auth'])->group(function () {

    /* ============================
       DASHBOARD AJAX API
    ============================ */
    Route::prefix('api/dashboard')->group(function () {
        Route::get('/stats', [DashboardApiController::class, 'getStats'])->name('api.dashboard.stats');
        Route::post('/refresh', [DashboardApiController::class, 'refreshStats'])->name('api.dashboard.refresh');
    });

    Route::get('/api/nms/strip-summary', [DashboardController::class, 'nmsStripSummary']);


    /* ============================
       DASHBOARD
    ============================ */
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])
        ->middleware('permission:view_dashboard')
        ->name('dashboard');

    Route::get('/admin/logout', [AdminController::class, 'destroy'])
        ->name('admin.logout');

    /* ============================
       SUPERADMIN ONLY (RBAC CONTROL)
    ============================ */
    Route::middleware('role:superadmin')->group(function () {

        Route::get('/users', [UserManagementController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [UserManagementController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserManagementController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])
            ->name('users.edit');

        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])
            ->name('users.destroy');

        Route::post('/users/{user}/update', [UserManagementController::class, 'update'])
            ->name('users.update');
    });

    /* ============================
       PROFILE (ALL AUTH USERS)
    ============================ */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::post('/toggle-theme', function(Request $request) {
        $theme = $request->input('theme', 'light');
        session(['theme' => $theme]);
        return response()->json(['success' => true, 'theme' => $theme]);
    })->name('theme.toggle');

    /* ============================
       REGION MASTER
    ============================ */
    Route::controller(RegionController::class)->group(function () {

        Route::get('/all/region', 'index')
            ->middleware('permission:view_regions')
            ->name('all.region');

        Route::get('/add/region', 'create')
            ->middleware('permission:manage_regions')
            ->name('add.region');

        Route::post('/store/region', 'store')
            ->middleware('permission:manage_regions')
            ->name('store.region');

        Route::get('/edit/region/{id}', 'edit')
            ->middleware('permission:manage_regions')
            ->name('edit.region');

        Route::post('/update/region/{id}', 'update')
            ->middleware('permission:manage_regions')
            ->name('update.region');

        Route::get('/delete/region/{id}', 'destroy')
            ->middleware('permission:manage_regions')
            ->name('delete.region');
    });

    /* ============================
       WAREHOUSE MASTER
    ============================ */
    Route::controller(WarehouseController::class)->group(function () {

        Route::get('/all/warehouse', 'index')
            ->middleware('permission:view_warehouses')
            ->name('all.warehouse');

        Route::get('/add/warehouse', 'create')
            ->middleware('permission:manage_warehouses')
            ->name('add.warehouse');

        Route::post('/store/warehouse', 'store')
            ->middleware('permission:manage_warehouses')
            ->name('store.warehouse');

        Route::get('/edit/warehouse/{id}', 'edit')
            ->middleware('permission:manage_warehouses')
            ->name('edit.warehouse');

        Route::post('/update/warehouse/{id}', 'update')
            ->middleware('permission:manage_warehouses')
            ->name('update.warehouse');

        Route::get('/delete/warehouse/{id}', 'destroy')
            ->middleware('permission:manage_warehouses')
            ->name('delete.warehouse');
    });

   /* ============================
   CAMERA NETWORK ROUTES
============================ */
// Region warehouses page (shows all warehouses for a region)
Route::get('/cameras/region/{region}', [RegionWarehousesController::class, 'index'])
    ->name('cameras.region');

// Individual warehouse details page (UPDATED - uses RegionWarehousesController)
Route::get('/cameras/{region}/{warehouse}/details', [RegionWarehousesController::class, 'show'])
    ->name('cameras.warehouse.details');

// AJAX endpoint for warehouse dropdown (for expandable rows)
Route::get('/cameras/region/{region}/warehouses', [CameraController::class, 'getWarehousesByRegion'])
    ->name('cameras.region.warehouses');

//
// Route::get('/cameras/{region}/{warehouse}/details', [CameraController::class, 'warehouseCameraDetails'])
//     ->name('cameras.warehouse.details');


  Route::prefix('nms')->name('nms.pages.')->group(function () {
    Route::get('/',                [NmsPagesController::class, 'dashboard'])->name('dashboard');
    Route::get('/warehouses', [NmsPagesController::class, 'warehouses'])->name('warehouses');
    Route::get('/warehouses/{id}', [NmsPagesController::class, 'warehouseDetail'])->name('warehouse.detail');
    Route::get('/map',             [NmsPagesController::class, 'map'])->name('map');
    Route::get('/regions',         [NmsPagesController::class, 'regions'])->name('regions');
    Route::get('/regions/{region}', [NmsPagesController::class, 'regionDetail'])->name('region.detail');
    Route::get('/api-monitor', [NmsPagesController::class, 'apiMonitor'])->name('api.monitor');
    Route::get('/poll-history',    [NmsPagesController::class, 'pollHistory'])->name('poll-history');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/warehouse/{id}/activity', [WarehouseActivityController::class, 'index'])
         ->name('warehouse.activity')
         ->where('id', '[0-9]+');
});

// Sack proxy (add inside middleware auth group)
Route::get('/api/proxy/sack', [WarehouseActivityController::class, 'proxySack'])->name('proxy.sack');

Route::get('/api/proxy/frs-logs', [WarehouseActivityController::class, 'proxyFrsLogs'])->name('proxy.frs.logs');

// Sack proxy (add inside middleware auth group)
Route::get('/api/proxy/sack', [WarehouseActivityController::class, 'proxySack'])->name('proxy.sack');

    /* ============================
       FIRE / SMOKE / RODENT ALERTS
    ============================ */
    Route::get('/alerts/fire', [CameraAlertController::class, 'fire'])
        ->middleware('permission:view_reports')
        ->name('alerts.fire');

    Route::get('/alerts/smoke', [CameraAlertController::class, 'smoke'])
        ->middleware('permission:view_reports')
        ->name('alerts.smoke');

    Route::get('/alerts/rodent', [CameraAlertController::class, 'rodent'])
        ->middleware('permission:view_reports')
        ->name('alerts.rodent');

    Route::get('/alerts/locations-by-state', [CameraAlertController::class, 'locationsByState'])
    ->name('alerts.locations-by-state');

    Route::get('/alerts/smoke/export',  [CameraAlertController::class, 'exportSmoke'])->name('alerts.smoke.export');
    Route::get('/alerts/fire/export',   [CameraAlertController::class, 'exportFire'])->name('alerts.fire.export');
    Route::get('/alerts/rodent/export', [CameraAlertController::class, 'exportRodent'])->name('alerts.rodent.export');

    /* ============================
       MASTER ALERT REPORTS
    ============================ */
    Route::get('/alerts', [MasterAlertController::class, 'index'])
        ->middleware('permission:view_reports')
        ->name('alerts.index');

    Route::get('/alerts/fetch', [MasterAlertController::class, 'fetch'])
        ->middleware('permission:view_reports')
        ->name('alerts.fetch');

    Route::get('/alerts/locations/{state}', [MasterAlertController::class, 'locationsByState'])
        ->middleware('permission:view_reports')
        ->name('alerts.locations');

    Route::get('/alerts/export', [MasterAlertController::class, 'exportExcel'])
        ->middleware('permission:view_reports')
        ->name('alerts.export');

// ============================
// GAS ALERTS
// ============================
    Route::prefix('gas-alerts')->name('gas.alerts.')->group(function () {
    Route::get('/',          [GasAlertController::class, 'index'])->name('index');
    Route::get('/locations/{state}', [GasAlertController::class, 'locationsByState'])->name('locations');
    Route::get('/export',    [GasAlertController::class, 'export'])->name('export');
});

    /* ============================
       FRS
    ============================ */
    Route::get('/frs-logs', [FrsController::class, 'index'])
        ->name('frs.logs');

    Route::get('/iot/frs/regions', [IotDropdownController::class, 'frsRegions']);
    Route::get('/iot/frs/warehouses', [IotDropdownController::class, 'frsWarehouses']);

    /* ============================
       SACK COUNTING
    ============================ */
    Route::get('/sack-count', [SackController::class, 'index'])
        ->name('sack.count');
    Route::get('/api/sack/region-summary', [SackController::class, 'regionSummary']);

    Route::get('/iot/sack/regions', [IotDropdownController::class, 'sackRegions']);
    Route::get('/iot/sack/warehouses', [IotDropdownController::class, 'sackWarehouses']);

});

Route::get('/cctv/{portal}', [CctvRedirectController::class, 'redirect'])
    ->name('cctv.redirect')
    ->where('portal', 'new|analog');


/* ============================

       LIve STreaming AutoLogin

    ============================ */

Route::middleware(['auth'])->get('/sso-redirect/{target}', function ($target) {

    $allowed = [

        'new'    => 'https://new.cwcnewcctv.in',

        'analog' => 'https://analog.cwcnewcctv.in',

    ];

    if (!array_key_exists($target, $allowed)) abort(404);

    $email = auth()->user()->email; // logged-in user, or hardcode 'admin@gmail.com'

    $payload = json_encode(['email' => $email, 'exp' => time() + 30]);

    $b64  = base64_encode($payload);

    $sig  = hash_hmac('sha256', $b64, config('services.sso.secret'));

    $token = urlencode($b64 . '.' . $sig);

    return redirect($allowed[$target] . "/sso-login?token={$token}");

}) ->name('sso.redirect');


// ----------------------------------------------------
// Auth Routes
// ----------------------------------------------------
require __DIR__ . '/auth.php';
