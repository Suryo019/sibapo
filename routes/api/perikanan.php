<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pegawai\DPController;
use App\Http\Controllers\Perikanan\ApiJenisIkanController;

// DP
Route::get('/dp', [DPController::class, 'index'])->name('api.dp.index');
// Route::get('/dp/detail', [DPController::class, 'detail'])->name('api.dp.detail');
Route::get('/dp/{jenisIkan}', [DPController::class, 'listItem'])->name('api.dp.listItem');
Route::post('/dp', [DPController::class, 'store'])->name('api.dp.store');
Route::put('/dp/{id}', [DPController::class, 'update'])->name('api.dp.update');
Route::delete('/dp/{id}', [DPController::class, 'destroy']);

// Jenis Ikan
Route::get('/jenis-ikan', [ApiJenisIkanController::class, 'index'])->name('api.jenis-ikan.index');
Route::post('/jenis-ikan', [ApiJenisIkanController::class, 'store'])->name('api.jenis-ikan.store');
Route::put('/jenis-ikan/{id}', [ApiJenisIkanController::class, 'update'])->name('api.jenis-ikan.update');
Route::delete('/jenis-ikan/{id}', [ApiJenisIkanController::class, 'destroy']);