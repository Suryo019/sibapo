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

// Dashboard
Route::get('/persendkpp', [AdminDashboardController::class, 'persen_dkpp']);
Route::get('/grafikdkpp', [AdminDashboardController::class, 'grafik_dkpp']);

// Read Data Pimpinan
Route::get('/pimpinan', [ReadDataController::class, 'getDPP']);
Route::get('/pimpinan/dpp', [ReadDataController::class, 'getDPP']);
Route::get('/pimpinan/dtphp', [ReadDataController::class, 'getDTPHP']);
Route::get('/pimpinan/dkpp', [ReadDataController::class, 'getDKPP']);
Route::get('/pimpinan/dp', [ReadDataController::class, 'getDP']);



// DKPP
Route::get('/dkpp', [DKPPController::class, 'index'])->name('api.dkpp.index');
Route::get('/dkpp/{bahanPokok}', [DPPController::class, 'listItem'])->name('api.dkpp.listItem');
Route::post('/dkpp', [DKPPController::class, 'store'])->name('api.dkpp.store');
Route::put('/dkpp/{id}', [DKPPController::class, 'update'])->name('api.dkpp.update');
Route::delete('/dkpp/{id}', [DKPPController::class, 'destroy']);



// DP
Route::get('/dp', [DPController::class, 'index'])->name('api.dp.index');
Route::get('/dp/{jenisIkan}', [DPController::class, 'listItem'])->name('api.dp.listItem');
Route::post('/dp', [DPController::class, 'store'])->name('api.dp.store');
Route::put('/dp/{id}', [DPController::class, 'update'])->name('api.dp.update');
Route::delete('/dp/{id}', [DPController::class, 'destroy']);



// DPP
Route::get('/dpp', [DPPController::class, 'index'])->name('api.dpp.index');
Route::get('/dpp/{bahanPokok}', [DPPController::class, 'listItem'])->name('api.dpp.listItem');
Route::get('/dpp-filter', [DPPController::class, 'filter'])->name('api.dpp.filter');
Route::post('/dpp', [DPPController::class, 'store'])->name('api.dpp.store');
Route::put('/dpp/{id}', [DPPController::class, 'update'])->name('api.dpp.update');
Route::delete('/dpp/{id}', [DPPController::class, 'destroy']);



// DTPHP
Route::get('/dtphp', [DTPHPController::class, 'index'])->name('api.dtphp.index');
Route::get('/dtphp/panen', [DTPHPController::class, 'panen'])->name('api.dtphp.panen');
Route::get('/dtphp/produksi', [DTPHPController::class, 'produksi'])->name('api.dtphp.produksi');
Route::get('/dtphp/{jenisKomoditas}', [DTPHPController::class, 'listItem'])->name('api.dtphp.listItem');  // Prosses
Route::post('/dtphp', [DTPHPController::class, 'store'])->name('api.dtphp.store');
Route::put('/dtphp/{id}', [DTPHPController::class, 'update'])->name('api.dtphp.update');
Route::delete('/dtphp/{id}', [DTPHPController::class, 'destroy']);



// CRUD Akun Dinas
Route::get('/makundinas', [AkunDinasController::class, 'index'])->name('api.makundinas.index');
Route::post('/makundinas', [AkunDinasController::class, 'store'])->name('api.makundinas.store');
Route::put('/makundinas/{id}', [AkunDinasController::class, 'update'])->name('api.makundinas.update');
Route::delete('/makundinas/{id}', [AkunDinasController::class, 'destroy']);



//Read Data Harga Komoditas
Route::get('/', [HargaKomoditasController::class, 'index'])->name('api.beranda.index');
Route::get('/komoditas', [HargaKomoditasController::class, 'komoditas_filter'])->name('api.komoditas');
Route::get('/pasar/search', [HargaKomoditasController::class, 'pasar_filter'])->name('api.pasar.search');
Route::get('/sorting_items', [HargaKomoditasController::class, 'render_sorting_child_items'])->name('api.sorting_items');
Route::get('/statistik_pasar', [HargaKomoditasController::class, 'statistik_pasar_filter'])->name('api.statistik_pasar');
Route::get('/statistik_jenis_bahan_pokok', [HargaKomoditasController::class, 'statistik_jenis_bahan_pokok_filter'])->name('api.statistik_jenis_bahan_pokok');



// Pasar
Route::get('/pasar', [ApiPasarController::class, 'index'])->name('api.pasar.index');
Route::post('/pasar', [ApiPasarController::class, 'store'])->name('api.pasar.store');
Route::put('/pasar/{id}', [ApiPasarController::class, 'update'])->name('api.pasar.update');
Route::delete('/pasar/{id}', [ApiPasarController::class, 'destroy']);



// Bahan Pokok
Route::get('/bahan_pokok', [ApiBpokokController::class, 'index'])->name('api.bahan_pokok.index');
Route::post('/bahan_pokok', [ApiBpokokController::class, 'store'])->name('api.bahan_pokok.store');
Route::put('/bahan_pokok/{id}', [ApiBpokokController::class, 'update'])->name('api.bahan_pokok.update');
Route::delete('/bahan_pokok/{id}', [ApiBpokokController::class, 'destroy']);



// Jenis Ikan
Route::get('/jenis-ikan', [ApiJenisIkanController::class, 'index'])->name('api.jenis-ikan.index');
Route::post('/jenis-ikan', [ApiJenisIkanController::class, 'store'])->name('api.jenis-ikan.store');
Route::put('/jenis-ikan/{id}', [ApiJenisIkanController::class, 'update'])->name('api.jenis-ikan.update');
Route::delete('/jenis-ikan/{id}', [ApiJenisIkanController::class, 'destroy']);



// Jenis Tanaman
Route::get('/jenis-tanaman', [ApiJenisTanamanController::class, 'index'])->name('api.jenis-tanaman.index');
Route::post('/jenis-tanaman', [ApiJenisTanamanController::class, 'store'])->name('api.jenis-tanaman.store');
Route::put('/jenis-tanaman/{id}', [ApiJenisTanamanController::class, 'update'])->name('api.jenis-tanaman.update');
Route::delete('/jenis-tanaman/{id}', [ApiJenisTanamanController::class, 'destroy']);



// Jenis Komoditas
Route::get('/jenis-komoditas', [ApiJenisKomoditasDkppController::class, 'index'])->name('api.jenis-komoditas.index');
Route::post('/jenis-komoditas', [ApiJenisKomoditasDkppController::class, 'store'])->name('api.jenis-komoditas.store');
Route::put('/jenis-komoditas/{id}', [ApiJenisKomoditasDkppController::class, 'update'])->name('api.jenis-komoditas.update');
Route::delete('/jenis-komoditas/{id}', [ApiJenisKomoditasDkppController::class, 'destroy']);