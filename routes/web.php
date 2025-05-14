<?php

use App\Models\DP;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\DTPHP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DkppController;
use App\Http\Controllers\Web\DtphpController;
use App\Http\Controllers\Web\PerikananController;
use App\Http\Controllers\Web\Tamu\TamuController;
use App\Http\Controllers\Web\DisperindagController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\Disperindag\PasarController;
use App\Http\Controllers\Web\Pimpinan\PimpinanController;
use App\Http\Controllers\Web\Disperindag\BpokokController;
use App\Http\Controllers\Web\PerikananDashboardController;
use App\Http\Controllers\Web\Pegawai\PegawaiDkppController;
use App\Http\Controllers\Web\Pegawai\PegawaiDtphpController;
use App\Http\Controllers\Web\Makundinas\MakundinasController;
use App\Http\Controllers\Web\Pegawai\PegawaiPerikananController;
use App\Http\Controllers\Web\Pegawai\PegawaiDisperindagController;


// Tamu
Route::get('/', [TamuController::class, 'beranda'])->name('beranda');
Route::get('/komoditas', [TamuController::class, 'komoditas_filter'])->name('tamu.komoditas');
Route::get('/pasar/search', [TamuController::class, 'pasar_filter'])->name('tamu.pasar.search');
Route::get('/statistik', [TamuController::class, 'statistik'])->name('tamu.statistik');
Route::get('/metadata', [TamuController::class, 'metadata'])->name('tamu.metadata');
Route::get('/tentang-kami', [TamuController::class, 'tentang_kami'])->name('tamu.tentang-kami');
Route::get('/hubungi-kami', [TamuController::class, 'hubungi_kami'])->name('tamu.hubungi-kami');



// ADMIN
Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');


// Disperindag
Route::resource('disperindag', DisperindagController::class)->names([
    'index' => 'disperindag.index',
    'create' => 'disperindag.create',
    'store' => 'disperindag.store',
    'show' => 'disperindag.show',
    'edit' => 'disperindag.edit',
    'update' => 'disperindag.update',
    'destroy' => 'disperindag.destroy',
]);

Route::get('disperindag-detail', [DisperindagController::class, 'dppDetail'])->name('disperindag.detail');


// DKPP
Route::resource('dkpp', DkppController::class)->names([
    'index' => 'dkpp.index',
    'create' => 'dkpp.create',
    'store' => 'dkpp.store',
    'show' => 'dkpp.show',
    'edit' => 'dkpp.edit',
    'update' => 'dkpp.update',
    'destroy' => 'dkpp.destroy',
]);
Route::get('dkpp-detail', [DkppController::class, 'detail'])->name('dkpp.detail');


// DTPHP
Route::resource('dtphp', DtphpController::class)->names([
    'index' => 'dtphp.index',
    'create' => 'dtphp.create',
    'store' => 'dtphp.store',
    'show' => 'dtphp.show',
    'edit' => 'dtphp.edit',
    'update' => 'dtphp.update',
    'destroy' => 'dtphp.destroy',
]);

Route::get('dtphp-detail-produksi', [DtphpController::class, 'detailProduksi'])->name('dtphp.detail.produksi');
Route::get('dtphp-detail-panen', [DtphpController::class, 'detailPanen'])->name('dtphp.detail.panen');
Route::get('dtphp-panen', [DtphpController::class, 'panen'])->name('dtphp.panen');
Route::get('dtphp-produksi', [DtphpController::class, 'produksi'])->name('dtphp.produksi');


// PERIKANAN
Route::resource('perikanan', PerikananController::class)->names([
    'index' => 'perikanan.index',
    'create' => 'perikanan.create',
    'store' => 'perikanan.store',
    'show' => 'perikanan.show',
    'edit' => 'perikanan.edit',
    'update' => 'perikanan.update',
    'destroy' => 'perikanan.destroy',
]);

Route::get('perikanan-detail', [PerikananController::class, 'detail'])->name('perikanan.detail');


// PEGAWAI

// DISPERINDAG
Route::get('/pegawai/disperindag/dashboard', function () {
    return view('pegawai.disperindag.pegawai-disperindag-dashboard');
})->name('pegawai.disperindag.dashboard');

Route::resource('/pegawai/disperindag', PegawaiDisperindagController::class)->names([
    'index' => 'pegawai.disperindag.index',
    'create' => 'pegawai.disperindag.create',
    'store' => 'pegawai.disperindag.store',
    'show' => 'pegawai.disperindag.show',
    'edit' => 'pegawai.disperindag.edit',
    'update' => 'pegawai.disperindag.update',
    'destroy' => 'pegawai.disperindag.destroy',
]);
Route::get('/pegawai/disperindag-detail', [PegawaiDisperindagController::class, 'dppDetail'])->name('pegawai.disperindag.detail');


// DKPP
Route::get('/pegawai/dkpp/dashboard', function () {
    return view('pegawai.dkpp.pegawai-dkpp-dashboard');
})->name('pegawai.dkpp.dashboard');

Route::resource('/pegawai/dkpp', PegawaiDkppController::class)->names([
    'index' => 'pegawai.dkpp.index',
    'create' => 'pegawai.dkpp.create',
    'store' => 'pegawai.dkpp.store',
    'show' => 'pegawai.dkpp.show',
    'edit' => 'pegawai.dkpp.edit',
    'update' => 'pegawai.dkpp.update',
    'destroy' => 'pegawai.dkpp.destroy',
]);
Route::get('/pegawai/dkpp-detail', [PegawaiDkppController::class, 'detail'])->name('pegawai.dkpp.detail');


// DTPHP
Route::get('/pegawai/dtphp/dashboard', [DtphpController::class, 'dashboard'])
    ->name('pegawai.dtphp.dashboard');
    
Route::get('/pegawai/dtphp/dashboard-panen', [DtphpController::class, 'dashboardPanen'])
    ->name('pegawai.dtphp.dashboard.panen');

Route::resource('/pegawai/dtphp', PegawaiDtphpController::class)->names([
    'index' => 'pegawai.dtphp.index',
    'create' => 'pegawai.dtphp.create',
    'store' => 'pegawai.dtphp.store',
    'show' => 'pegawai.dtphp.show',
    'edit' => 'pegawai.dtphp.edit',
    'update' => 'pegawai.dtphp.update',
    'destroy' => 'pegawai.dtphp.destroy',
]);

Route::get('/pegawai/dtphp-detail-produksi', [PegawaiDtphpController::class, 'detailProduksi'])->name('pegawai.dtphp.detail.produksi');
Route::get('/pegawai/dtphp-detail-panen', [PegawaiDtphpController::class, 'detailPanen'])->name('pegawai.dtphp.detail.panen');
Route::get('/pegawai/dtphp-panen', [PegawaiDtphpController::class, 'panen'])->name('pegawai.dtphp.panen');
Route::get('/pegawai/dtphp-produksi', [PegawaiDtphpController::class, 'produksi'])->name('pegawai.dtphp.produksi');


// PERIKANAN
Route::get('/pegawai/perikanan/dashboard', [PerikananController::class, 'dashboard'])
    ->name('pegawai.perikanan.dashboard');

Route::resource('/pegawai/perikanan', PegawaiPerikananController::class)->names([
    'index' => 'pegawai.perikanan.index',
    'create' => 'pegawai.perikanan.create',
    'store' => 'pegawai.perikanan.store',
    'show' => 'pegawai.perikanan.show',
    'edit' => 'pegawai.perikanan.edit',
    'update' => 'pegawai.perikanan.update',
    'destroy' => 'pegawai.perikanan.destroy',
]);

Route::get('/pegawai/perikanan-detail', [PegawaiPerikananController::class, 'detail'])->name('pegawai.perikanan.detail');


// Manajemen Akun Dinas
Route::get('/makundinas/dashboard', function () {
    return view('admin.makundinas.makundinas-dashboard');
})->name('admin.makundinas.dashboard');

Route::resource('makundinas', MakundinasController::class)->names([
    'index' => 'makundinas.index',
    'create' => 'makundinas.create',
    'store' => 'makundinas.store',
    'show' => 'makundinas.show',
    'edit' => 'makundinas.edit',
    'update' => 'makundinas.update',
    'destroy' => 'makundinas.destroy',
]);

Route::get('/makundinas-detail', [MakundinasController::class, 'detail'])->name('makundinas.detail');


// Pasar
Route::resource('pasar', PasarController::class)->names([
    'index' => 'pasar.index',
    'create' => 'pasar.create',
    'store' => 'pasar.store',
    'show' => 'pasar.show',
    'edit' => 'pasar.edit',
    'update' => 'pasar.update',
    'destroy' => 'pasar.destroy',
]);

Route::get('/pasar-detail', [PasarController::class, 'detail'])->name('pasar.detail');


// Bahan Pokok
Route::resource('bahan_pokok', BpokokController::class)->names([
    'index' => 'bahan_pokok.index',
    'create' => 'bahan_pokok.create',
    'store' => 'bahan_pokok.store',
    'show' => 'bahan_pokok.show',
    'edit' => 'bahan_pokok.edit',
    'update' => 'bahan_pokok.update',
    'destroy' => 'bahan_pokok.destroy',
]);

Route::get('/bahan_pokok-detail', [BpokokController::class, 'detail'])->name('bahan_pokok.detail');

//Pimpinan 
Route::get('/pimpinan-dashboard', [PimpinanController::class,'index'] )->name('pimpinan.dashboard');
Route::get('/pimpinan-disperindag', [PimpinanController::class,'disperindag'] )->name('pimpinan.disperindag');
Route::get('/pimpinan-dkpp', [PimpinanController::class,'dkpp'] )->name('pimpinan.dkpp');
Route::get('/pimpinan-dtphp-panen', [PimpinanController::class,'panen'] )->name('pimpinan.dtphp-panen');
Route::get('/pimpinan-dtphp-volume', [PimpinanController::class,'volume'] )->name('pimpinan.dtphp-volume');
Route::get('/pimpinan-perikanan', [PimpinanController::class,'perikanan'] )->name('pimpinan.perikanan');