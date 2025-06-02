<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pegawai\DPPController;
use App\Http\Controllers\Disperindag\ApiPasarController;
use App\Http\Controllers\Disperindag\ApiBpokokController;

// DPP
Route::post('/dpp', [DPPController::class, 'store'])->name('api.dpp.store');
Route::put('/dpp/{id}', [DPPController::class, 'update'])->name('api.dpp.update');
Route::delete('/dpp/{id}', [DPPController::class, 'destroy']);

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