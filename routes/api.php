<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DPController;
use App\Http\Controllers\DPPController;
use App\Http\Controllers\DKPPController;
use App\Http\Controllers\DTPHPController;

// DKPP
Route::get('/dkpp', [DKPPController::class, 'index']);
Route::post('/dkpp', [DKPPController::class, 'store']);
Route::put('/dkpp/{id}', [DKPPController::class, 'update']);
Route::delete('/dkpp/{id}', [DKPPController::class, 'destroy']);

// DP
Route::get('/dp', [DPController::class, 'index']);
Route::post('/dp', [DPController::class, 'store']);
Route::put('/dp/{id}', [DPController::class, 'update']);
Route::delete('/dp/{id}', [DPController::class, 'destroy']);

// DPP
Route::get('/dpp', [DPPController::class, 'index']);
Route::post('/dpp', [DPPController::class, 'store']);
Route::put('/dpp/{id}', [DPPController::class, 'update']);
Route::delete('/dpp/{id}', [DPPController::class, 'destroy']);

// DTPHP
Route::get('/dtphp', [DTPHPController::class, 'index']);
Route::post('/dtphp', [DTPHPController::class, 'store']);
Route::put('/dtphp/{id}', [DTPHPController::class, 'update']);
Route::delete('/dtphp/{id}', [DTPHPController::class, 'destroy']);