<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pegawai\DTPHPController;
use App\Http\Controllers\Dtphp\ApiJenisTanamanController;

// DTPHP
Route::get('/dtphp', [DTPHPController::class, 'index'])->name('api.dtphp.index');
Route::get('/dtphp/panen', [DTPHPController::class, 'panen'])->name('api.dtphp.panen');
Route::get('/dtphp/produksi', [DTPHPController::class, 'produksi'])->name('api.dtphp.produksi');
Route::get('/dtphp/{jenisKomoditas}', [DTPHPController::class, 'listItem'])->name('api.dtphp.listItem');  // Prosses
Route::post('/dtphp', [DTPHPController::class, 'store'])->name('api.dtphp.store');
Route::put('/dtphp/{id}', [DTPHPController::class, 'update'])->name('api.dtphp.update');
Route::delete('/dtphp/{id}', [DTPHPController::class, 'destroy']);

// Jenis Tanaman
Route::get('/jenis-tanaman', [ApiJenisTanamanController::class, 'index'])->name('api.jenis-tanaman.index');
Route::post('/jenis-tanaman', [ApiJenisTanamanController::class, 'store'])->name('api.jenis-tanaman.store');
Route::put('/jenis-tanaman/{id}', [ApiJenisTanamanController::class, 'update'])->name('api.jenis-tanaman.update');
Route::delete('/jenis-tanaman/{id}', [ApiJenisTanamanController::class, 'destroy']);