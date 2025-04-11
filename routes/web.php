<?php

use App\Models\DPP;
use App\Models\DKPP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DkppController;
use App\Http\Controllers\Web\DtphpController;
use App\Http\Controllers\Web\PerikananController;
use App\Http\Controllers\Web\DisperindagController;

Route::get('/', function () {
    return view('welcome');
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

// Route::get('/disperindag/detail', [DisperindagController::class, 'detail'])->name('disperindag.detail');


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

Route::get('dkpp-detail', function () {
    $dkpp = DKPP::all();
    return view('admin.dkpp.admin-dkpp-detail', [
        'title' => 'Lihat Detail Data',
        'data' => $dkpp
    ]);
})->name('dkpp.detail');

// Route::get('/dkpp', function () {
//     return view('admin.admin-dkpp');
// });


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

// Route::get('dtphp-detail', function () {
//     return view('admin.dtphp.admin-dtphp',[
//         'title' => 'Lihat Detail Data',
//         // 'data' => $dtphp
//     ]);
// })->name('dtphp.detail');

Route::get('dtphp-detail', [DtphpController::class, 'detail'])->name('dtphp.detail');

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