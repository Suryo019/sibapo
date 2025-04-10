<?php

use App\Http\Controllers\Web\DisperindagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('disperindag', DisperindagController::class)->names([
    'index' => 'disperindag.index',
    'create' => 'disperindag.create',
    'store' => 'disperindag.store',
    'show' => 'disperindag.show',
    'edit' => 'disperindag.edit',
    'update' => 'disperindag.update',
    'destroy' => 'disperindag.destroy',
]);

Route::get('/dtphp', function () {
    return view('admin.admin-dtphp');
});

Route::get('/dkpp', function () {
    return view('admin.admin-dkpp');
});

Route::get('/perikanan', function () {
    return view('admin.admin-perikanan');
});