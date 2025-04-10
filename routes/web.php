<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< Updated upstream
Route::get('/dashboard', function () {
    return view('admin.admin-dashboard');
});

Route::get('/disperindag', function () {
    return view('admin.admin-disperindag');
});
=======
Route::resource('disperindag', DisperindagController::class)->names([
    'index' => 'disperindag.index',
    'create' => 'disperindag.create',
    'store' => 'disperindag.store',
    'show' => 'disperindag.show',
    'edit' => 'disperindag.edit',
    'update' => 'disperindag.update',
    'destroy' => 'disperindag.destroy',
]);
Route::get('disperindag/detail', [DisperindagController::class, 'detail'])->name('disperindag.detail');
>>>>>>> Stashed changes

Route::get('/dtphp', function () {
    return view('admin.admin-dtphp');
});

Route::get('/dkpp', function () {
    return view('admin.admin-dkpp');
});

Route::get('/perikanan', function () {
    return view('admin.admin-perikanan');
});