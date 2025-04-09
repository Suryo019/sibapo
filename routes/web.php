<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.admin-dashboard');
});

Route::get('/disperindag', function () {
    return view('admin.admin-disperindag');
});

Route::get('/dtphp', function () {
    return view('admin.admin-dtphp');
});

Route::get('/dkpp', function () {
    return view('admin.admin-dkpp');
});

Route::get('/perikanan', function () {
    return view('admin.admin-perikanan');
});