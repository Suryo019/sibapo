<?php

use App\Models\DPP;
use App\Models\DKPP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DkppController;
use App\Http\Controllers\Web\DisperindagController;
use App\Http\Controllers\Web\Pegawai\PegawaiDkppController;
use App\Http\Controllers\Web\Pegawai\PegawaiDisperindagController;

// ADMIN
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.admin-dashboard');
})->name('dashboard');

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

Route::get('/dtphp', function () {
    return view('admin.admin-dtphp');
});


Route::get('/perikanan', function () {
    return view('admin.admin-perikanan');
});

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