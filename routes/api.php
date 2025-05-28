<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pegawai\DPController;
use App\Http\Controllers\Pegawai\DPPController;
use App\Http\Controllers\Pegawai\DKPPController;
use App\Http\Controllers\Pegawai\DTPHPController;
use App\Http\Controllers\Akun\AkunDinasController;
use App\Http\Controllers\Pimpinan\ReadDataController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Disperindag\ApiPasarController;
use App\Http\Controllers\Disperindag\ApiBpokokController;
use App\Http\Controllers\Dtphp\ApiJenisTanamanController;
use App\Http\Controllers\Beranda\HargaKomoditasController;
use App\Http\Controllers\Perikanan\ApiJenisIkanController;
use App\Http\Controllers\Dkpp\ApiJenisKomoditasDkppController;

Route::middleware('auth:sanctum')->group(function () {
    // CRUD Akun Dinas
    Route::get('/makundinas', [AkunDinasController::class, 'index'])->name('api.makundinas.index');
    Route::post('/makundinas', [AkunDinasController::class, 'store'])->name('api.makundinas.store');
    Route::put('/makundinas/{id}', [AkunDinasController::class, 'update'])->name('api.makundinas.update');
    Route::delete('/makundinas/{id}', [AkunDinasController::class, 'destroy']);

    require __DIR__.'/api/disperindag.php';
    require __DIR__.'/api/dkpp.php';
    require __DIR__.'/api/dtphp.php';
    require __DIR__.'/api/perikanan.php';
});

Route::middleware('auth:sanctum')->group(function () {
    require __DIR__.'/api/disperindag.php';
});

Route::middleware('auth:sanctum')->group(function () {
    require __DIR__.'/api/dkpp.php';
});

Route::middleware('auth:sanctum')->group(function () {
    require __DIR__.'/api/dtphp.php';
});

Route::middleware('auth:sanctum')->group(function () {
    require __DIR__.'/api/perikanan.php';
});

Route::middleware('auth:sanctum')->group(function () {
    // Read Data Pimpinan
    Route::get('/pimpinan', [ReadDataController::class, 'getDPP']);
    Route::get('/pimpinan/dpp', [ReadDataController::class, 'getDPP']);
    Route::get('/pimpinan/dtphp', [ReadDataController::class, 'getDTPHP']);
    Route::get('/pimpinan/dkpp', [ReadDataController::class, 'getDKPP']);
    Route::get('/pimpinan/dp', [ReadDataController::class, 'getDP']);
});

//Read Data Harga Komoditas
Route::get('/', [HargaKomoditasController::class, 'index'])->name('api.beranda.index');
Route::get('/komoditas', [HargaKomoditasController::class, 'komoditas_filter'])->name('api.komoditas');
Route::get('/pasar/search', [HargaKomoditasController::class, 'pasar_filter'])->name('api.pasar.search');
Route::get('/sorting_items', [HargaKomoditasController::class, 'render_sorting_child_items'])->name('api.sorting_items');
Route::get('/statistik_pasar', [HargaKomoditasController::class, 'statistik_pasar_filter'])->name('api.statistik_pasar');
Route::get('/statistik_jenis_bahan_pokok', [HargaKomoditasController::class, 'statistik_jenis_bahan_pokok_filter'])->name('api.statistik_jenis_bahan_pokok');