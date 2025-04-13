<?php

use App\Models\DPP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DkppController;
use App\Http\Controllers\Web\DisperindagController;
use App\Models\DKPP;

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

// Route::get('/disperindag/detail', [DisperindagController::class, 'detail'])->name('disperindag.detail');

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


Route::get('/dtphp', function () {
    return view('admin.admin-dtphp');
});


Route::get('/perikanan', function () {
    return view('admin.admin-perikanan');
});