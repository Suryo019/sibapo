<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pegawai\DPController;
use App\Http\Controllers\Pegawai\DPPController;
use App\Http\Controllers\Pegawai\DKPPController;
use App\Http\Controllers\Pegawai\DTPHPController;
use App\Http\Controllers\Pimpinan\ReadDataController;

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
Route::post('/dpp', [DPPController::class, 'store'])->name('api.dpp.store');
Route::put('/dpp/{id}', [DPPController::class, 'update'])->name('api.dpp.update');
Route::delete('/dpp/{id}', [DPPController::class, 'destroy']);

// DTPHP
Route::get('/dtphp', [DTPHPController::class, 'index'])->name('api.dtphp.index');
Route::get('/dtphp/{jenisKomoditas}', [DTPHPController::class, 'listItem'])->name('api.dtphp.listItem');  // Prosses
Route::post('/dtphp', [DTPHPController::class, 'store'])->name('api.dtphp.store');
Route::put('/dtphp/{id}', [DTPHPController::class, 'update'])->name('api.dtphp.update');
Route::delete('/dtphp/{id}', [DTPHPController::class, 'destroy']);