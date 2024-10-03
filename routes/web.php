<?php

use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemCheckController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada

use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Fallback route jika rute tidak ditemukan
Route::fallback(function () {
    if (Auth::check()) {
        return redirect()->route('admin.admin.dashboard')->with('error', 'Halaman yang Anda cari tidak ditemukan.');
    }
    
    return redirect()->route('login')->with('error', 'Halaman tidak ditemukan. Silakan login terlebih dahulu.');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/forgot-password', function () {
    return view('auth.forgotPass');
})->name('forgotPass');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:1,2,4'])->group(function () {
    // Menampilkan daftar lokasi
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');

    // Menampilkan form pengecekan barang di lokasi tertentu
    Route::get('/export-pdf/{location}', [ItemCheckController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export-excel/{location}', [ItemCheckController::class, 'exportExcel'])->name('export.excel');
    Route::get('locations/{location}/item-checks/create', [ItemCheckController::class, 'create'])->name('item_checks.create');
    Route::post('locations/{location}/item-checks', [ItemCheckController::class, 'store'])->name('item_checks.store');
    Route::get('locations/{location}/item-checks/history', [ItemCheckController::class, 'history'])->name('item_checks.history');
});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('divisions', DivisionController::class)->middleware('role:1');
    Route::resource('inventory', InventoryController::class)->middleware('role:1,3');
    Route::resource('locations', AdminLocationController::class)->middleware('role:1,3');
    Route::get('alokasi', [AdminLocationController::class, 'indexadd'])->name('alokasi.index')->middleware('role:1,2,3');
    Route::get('locations/{location}/addinventories', [AdminLocationController::class, 'addinventories'])->name('location.inventories')->middleware('role:1,2,3');
    Route::post('locations/{location}/addinventories/action', [AdminLocationController::class, 'addaction'])->name('location.action.inventories')->middleware('role:1,2,3');
    Route::resource('suppliers', SupplierController::class)->middleware('role:1,3');
    Route::resource('units', UnitController::class)->middleware('role:1,3');
    Route::resource('users', UserController::class)->middleware('role:1,2');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('updateprofile/{user}', [UserController::class, 'updateprofile'])->name('updateprofile');
});
