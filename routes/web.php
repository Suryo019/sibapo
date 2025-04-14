<?php

use App\Models\DP;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\DTPHP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DkppController;
use App\Http\Controllers\Web\DtphpController;
use App\Http\Controllers\Web\PerikananController;
use App\Http\Controllers\Web\DisperindagController;
use App\Http\Controllers\Web\Pegawai\PegawaiDkppController;
use App\Http\Controllers\Web\Pegawai\PegawaiPerikananController;
use App\Http\Controllers\Web\Pegawai\PegawaiDisperindagController;

// ADMIN
Route::get('/', function () {
    return view('admin.admin-dashboard');
});

Route::get('/dashboard', function () {
    return view('admin.admin-dashboard');
})->name('dashboard');



// Disperindag
Route::resource('disperindag', DisperindagController::class)->names([
    'index' => 'disperindag.index',
    'create' => 'disperindag.create',
    'store' => 'disperindag.store',
    'show' => 'disperindag.show',
    'edit' => 'disperindag.edit',
    'update' => 'disperindag.update',
    'destroy' => 'disperindag.destroy',
]);

Route::get('disperindag-detail', [DisperindagController::class, 'detail'])->name('disperindag.detail');


// DKPP
Route::resource('dkpp', DkppController::class)->names([
    'index' => 'dkpp.index',
    'create' => 'dkpp.create',
    'store' => 'dkpp.store',
    'show' => 'dkpp.show',
    'edit' => 'dkpp.edit',
    'update' => 'dkpp.update',
    'destroy' => 'dkpp.destroy',
]);
Route::get('dkpp-detail', [DkppController::class, 'detail'])->name('dkpp.detail');


// DTPHP
Route::resource('dtphp', DtphpController::class)->names([
    'index' => 'dtphp.index',
    'create' => 'dtphp.create',
    'store' => 'dtphp.store',
    'show' => 'dtphp.show',
    'edit' => 'dtphp.edit',
    'update' => 'dtphp.update',
    'destroy' => 'dtphp.destroy',
]);

Route::get('dtphp-detail-produksi', [DtphpController::class, 'detailProduksi'])->name('dtphp.detail.produksi');
Route::get('dtphp-detail-panen', [DtphpController::class, 'detailPanen'])->name('dtphp.detail.panen');


// PERIKANAN
Route::resource('perikanan', PerikananController::class)->names([
    'index' => 'perikanan.index',
    'create' => 'perikanan.create',
    'store' => 'perikanan.store',
    'show' => 'perikanan.show',
    'edit' => 'perikanan.edit',
    'update' => 'perikanan.update',
    'destroy' => 'perikanan.destroy',
]);

Route::get('perikanan-detail', [PerikananController::class, 'detail'])->name('perikanan.detail');


// PEGAWAI

// DISPERINDAG
Route::get('/pegawai/disperindag/dashboard', function () {
    return view('pegawai.disperindag.pegawai-disperindag-dashboard');
})->name('pegawai.disperindag.dashboard');

Route::resource('/pegawai/disperindag', PegawaiDisperindagController::class)->names([
    'index' => 'pegawai.disperindag.index',
    'create' => 'pegawai.disperindag.create',
    'store' => 'pegawai.disperindag.store',
    'show' => 'pegawai.disperindag.show',
    'edit' => 'pegawai.disperindag.edit',
    'update' => 'pegawai.disperindag.update',
    'destroy' => 'pegawai.disperindag.destroy',
]);
Route::get('/pegawai/disperindag-detail', [PegawaiDisperindagController::class, 'detail'])->name('pegawai.disperindag.detail');


// DKPP
Route::get('/pegawai/dkpp/dashboard', function () {
    return view('pegawai.dkpp.pegawai-dkpp-dashboard');
})->name('pegawai.dkpp.dashboard');

Route::resource('/pegawai/dkpp', PegawaiDkppController::class)->names([
    'index' => 'pegawai.dkpp.index',
    'create' => 'pegawai.dkpp.create',
    'store' => 'pegawai.dkpp.store',
    'show' => 'pegawai.dkpp.show',
    'edit' => 'pegawai.dkpp.edit',
    'update' => 'pegawai.dkpp.update',
    'destroy' => 'pegawai.dkpp.destroy',
]);
Route::get('/pegawai/dkpp-detail', [PegawaiDkppController::class, 'detail'])->name('pegawai.dkpp.detail');


// // DTPHP
// Route::resource('dtphp', DtphpController::class)->names([
//     'index' => 'dtphp.index',
//     'create' => 'dtphp.create',
//     'store' => 'dtphp.store',
//     'show' => 'dtphp.show',
//     'edit' => 'dtphp.edit',
//     'update' => 'dtphp.update',
//     'destroy' => 'dtphp.destroy',
// ]);

// Route::get('dtphp-detail-produksi', [DtphpController::class, 'detailProduksi'])->name('dtphp.detail.produksi');
// Route::get('dtphp-detail-panen', [DtphpController::class, 'detailPanen'])->name('dtphp.detail.panen');


// PERIKANAN
Route::get('/pegawai/perikanan/dashboard', function () {
    return view('pegawai.perikanan.pegawai-perikanan-dashboard');
})->name('pegawai.perikanan.dashboard');

Route::resource('/pegawai/perikanan', PegawaiPerikananController::class)->names([
    'index' => 'pegawai.perikanan.index',
    'create' => 'pegawai.perikanan.create',
    'store' => 'pegawai.perikanan.store',
    'show' => 'pegawai.perikanan.show',
    'edit' => 'pegawai.perikanan.edit',
    'update' => 'pegawai.perikanan.update',
    'destroy' => 'pegawai.perikanan.destroy',
]);

Route::get('/pegawai/perikanan-detail', [PegawaiPerikananController::class, 'detail'])->name('pegawai.perikanan.detail');