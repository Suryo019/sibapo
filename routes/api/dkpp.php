<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pegawai\DPPController;
use App\Http\Controllers\Pegawai\DKPPController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Dkpp\ApiJenisKomoditasDkppController;

// Dashboard
Route::get('/persendkpp', [AdminDashboardController::class, 'persen_dkpp']);
Route::get('/grafikdkpp', [AdminDashboardController::class, 'grafik_dkpp']);

// DKPP
Route::get('/dkpp', [DKPPController::class, 'index'])->name('api.dkpp.index');
Route::get('/dkpp/detail', [DKPPController::class, 'detail'])->name('api.dkpp.detail');
Route::get('/dkpp/{bahanPokok}', [DPPController::class, 'listItem'])->name('api.dkpp.listItem');
Route::post('/dkpp', [DKPPController::class, 'store'])->name('api.dkpp.store');
Route::put('/dkpp/{id}', [DKPPController::class, 'update'])->name('api.dkpp.update');
Route::delete('/dkpp/{id}', [DKPPController::class, 'destroy']);

// Jenis Komoditas
Route::get('/jenis-komoditas', [ApiJenisKomoditasDkppController::class, 'index'])->name('api.jenis-komoditas.index');
Route::post('/jenis-komoditas', [ApiJenisKomoditasDkppController::class, 'store'])->name('api.jenis-komoditas.store');
Route::put('/jenis-komoditas/{id}', [ApiJenisKomoditasDkppController::class, 'update'])->name('api.jenis-komoditas.update');
Route::delete('/jenis-komoditas/{id}', [ApiJenisKomoditasDkppController::class, 'destroy']);
