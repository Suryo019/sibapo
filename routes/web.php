<?php

use App\Models\DP;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\DTPHP;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DkppController;
use App\Http\Controllers\Web\DtphpController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Web\PerikananController;
use App\Http\Controllers\Web\Tamu\TamuController;
use App\Http\Controllers\NotifikasiAdminController;
use App\Http\Controllers\Web\DisperindagController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\Disperindag\PasarController;
use App\Http\Controllers\Web\Pimpinan\PimpinanController;
use App\Http\Controllers\Web\Disperindag\BpokokController;
use App\Http\Controllers\Web\Dtphp\JenisTanamanController;
use App\Http\Controllers\Web\Dkpp\NotifikasiDkppController;
use App\Http\Controllers\Web\Pegawai\PegawaiDkppController;
use App\Http\Controllers\Web\Perikanan\JenisIkanController;
use App\Http\Controllers\Web\Pegawai\PegawaiDtphpController;
use App\Http\Controllers\Web\Pegawai\PegawaiPasarController;
use App\Http\Controllers\Web\Dtphp\NotifikasiDtphpController;
use App\Http\Controllers\Web\Makundinas\MakundinasController;
use App\Http\Controllers\Web\Dkpp\JenisKomoditasDkppController;
use App\Http\Controllers\Web\Pegawai\PegawaiPerikananController;
use App\Http\Controllers\Web\Dtphp\PegawaiJenisTanamanController;
use App\Http\Controllers\Web\Pegawai\PegawaiBahanPokokController;
use App\Http\Controllers\Web\Pegawai\PegawaiDisperindagController;
use App\Http\Controllers\Web\Perikanan\PegawaiJenisIkanController;
use App\Http\Controllers\Web\Perikanan\NotifikasiPerikananController;
use App\Http\Controllers\Web\Dkpp\PegawaiJenisKomoditasDkppController;
use App\Http\Controllers\Web\Disperindag\NotifikasiDisperindagController;


// Tamu
Route::get('/', [TamuController::class, 'beranda'])->name('beranda');
Route::get('/komoditas', [TamuController::class, 'komoditas_filter'])->name('tamu.komoditas');
Route::get('/pasar/search', [TamuController::class, 'pasar_filter'])->name('tamu.pasar.search');
Route::get('/statistik', [TamuController::class, 'statistik'])->name('tamu.statistik');
Route::get('/metadata', [TamuController::class, 'metadata'])->name('tamu.metadata');
Route::get('/tentang-kami', [TamuController::class, 'tentang_kami'])->name('tamu.tentang-kami');
// Route::get('/hubungi-kami', [TamuController::class, 'hubungi_kami'])->name('tamu.hubungi-kami');
// Route::middleware('guest')->group(function () {
// });

// Export Data PDF
Route::post('/export-pdf-chart', [Controller::class, 'exportChartPdf']);

// ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    
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
    
    Route::resource('pasar', PasarController::class)->names([
        'index' => 'pasar.index',
        'create' => 'pasar.create',
        'edit' => 'pasar.edit',
    ]);
    
    Route::resource('bahan_pokok', BpokokController::class)->names([
        'index' => 'bahan_pokok.index',
        'create' => 'bahan_pokok.create',
        'edit' => 'bahan_pokok.edit',
    ]);
    
    
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
    
    Route::resource('jenis_komoditas', JenisKomoditasDkppController::class)->names([
        'index' => 'jenis-komoditas.index',
        'create' => 'jenis-komoditas.create',
        'edit' => 'jenis-komoditas.edit',
    ]);
    
    
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
    
    Route::resource('jenis_tanaman', JenisTanamanController::class)->names([
        'index' => 'jenis-tanaman.index',
        'create' => 'jenis-tanaman.create',
        'edit' => 'jenis-tanaman.edit',
    ]);
    
    
    // PERIKANAN
    Route::resource('perikanan', PerikananController::class)->names([
        'index' => 'perikanan.index',
        'create' => 'perikanan.create',
        'edit' => 'perikanan.edit',
    ]);
    
    Route::get('perikanan-detail', [PerikananController::class, 'detail'])->name('perikanan.detail');
    
    // JenisIkan
    Route::resource('jenis_ikan', JenisIkanController::class)->names([
        'index' => 'jenis-ikan.index',
        'create' => 'jenis-ikan.create',
        'edit' => 'jenis-ikan.edit',
    ]);
    
    // Manajemen Akun Dinas
    Route::get('/makundinas/dashboard', function () {
        return view('admin.makundinas.makundinas-dashboard');
    })->name('admin.makundinas.dashboard');
    
    Route::resource('makundinas', MakundinasController::class)->names([
        'index' => 'makundinas.index',
        'create' => 'makundinas.create',
        'edit' => 'makundinas.edit',
    ]);
    
    // Route::get('/notifikasi', function() {
    //     return view('admin.admin-notifikasi');
    // });

    Route::get('/notifikasi', [NotifikasiAdminController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifications/header', [NotifikasiAdminController::class, 'getHeaderNotifications']);
    Route::post('/notifications/mark-read', [NotifikasiAdminController::class, 'markAsRead']);

    Route::post('/notifications/{id}/complete', [NotifikasiAdminController::class, 'markAsCompleted']);
    Route::post('/notifications/{id}/incomplete', [NotifikasiAdminController::class, 'markAsIncomplete']);
    Route::delete('/notifications/{id}', [NotifikasiAdminController::class, 'destroy']);

    Route::get('/notifikasi/filter', [NotifikasiAdminController::class, 'filter'])->name('admin.notifikasi.filter');

});
// ADMIN END


// PEGAWAI

// DISPERINDAG
Route::middleware(['auth', 'role:disperindag'])->group(function () {
    Route::get('/pegawai/disperindag/dashboard', [PegawaiDisperindagController::class, 'dashboard'])->name('pegawai.disperindag.dashboard');
    
    Route::resource('/pegawai/disperindag/data', PegawaiDisperindagController::class)->names([
        'index' => 'pegawai.disperindag.index',
        'create' => 'pegawai.disperindag.create',
        'store' => 'pegawai.disperindag.store',
        'show' => 'pegawai.disperindag.show',
        'edit' => 'pegawai.disperindag.edit',
        'update' => 'pegawai.disperindag.update',
        'destroy' => 'pegawai.disperindag.destroy',
    ]);
    Route::get('/pegawai/disperindag-detail', [PegawaiDisperindagController::class, 'dppDetail'])->name('pegawai.disperindag.detail');
    
    Route::get('/pegawai/disperindag/pasar/detail', [PegawaiPasarController::class, 'index'])->name('pegawai.disperindag.pasar.index');
    Route::get('/pegawai/disperindag/pasar/create', [PegawaiPasarController::class, 'create'])->name('pegawai.disperindag.pasar.create');
    Route::get('/pegawai/disperindag/pasar/edit/{pasar:id}', [PegawaiPasarController::class, 'edit'])->name('pegawai.disperindag.pasar.edit');
    
    Route::get('/pegawai/disperindag/bahanpokok/detail', [PegawaiBahanPokokController::class, 'index'])->name('pegawai.disperindag.bahanpokok.index');
    Route::get('/pegawai/disperindag/bahanpokok/create', [PegawaiBahanPokokController::class, 'create'])->name('pegawai.disperindag.bahanpokok.create');
    Route::get('/pegawai/disperindag/bahanpokok/edit/{bahanpokok:id}', [PegawaiBahanPokokController::class, 'edit'])->name('pegawai.disperindag.bahanpokok.edit');
    
    Route::get('/pegawai/disperindag/notifikasi', [NotifikasiDisperindagController::class, 'index'])->name('pegawai.disperindag.notifikasi.index');
    Route::get('pegawai/disperindag/notifications/header', [NotifikasiDisperindagController::class, 'getHeaderNotifications']);
    Route::post('pegawai/disperindag/notifications/mark-read', [NotifikasiDisperindagController::class, 'markAsRead']);

    Route::post('/pegawai/disperindag/notifications/{id}/complete', [NotifikasiDisperindagController::class, 'markAsCompleted']);
    Route::post('/pegawai/disperindag/notifications/{id}/incomplete', [NotifikasiDisperindagController::class, 'markAsIncomplete']);
    Route::delete('pegawai/disperindag/notifications/{id}', [NotifikasiDisperindagController::class, 'destroy']);

    Route::post('pegawai/disperindag/notifikasi/filter', [NotifikasiDisperindagController::class, 'filter'])->name('pegawai.disperindag.notifikasi.filter');
    
    // Route::get('/pegawai/disperindag/notifikasi', function() {
    //     return view('pegawai.disperindag.pegawai-notifikasi-disperindag');
    // });
});
// DISPERINDAG END


// DKPP
Route::middleware(['auth', 'role:dkpp'])->group(function () {
    Route::get('/pegawai/dkpp/dashboard', [PegawaiDkppController::class, 'dashboard'])->name('pegawai.dkpp.dashboard');
    
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
   
    Route::resource('/pegawai/jenis_komoditas', PegawaiJenisKomoditasDkppController::class)->names([
        'index'   => 'pegawai.jenis-komoditas.index',
        'create'  => 'pegawai.jenis-komoditas.create',
        'store'   => 'pegawai.jenis-komoditas.store',
        'show'    => 'pegawai.jenis-komoditas.show',
        'edit'    => 'pegawai.jenis-komoditas.edit',
        'update'  => 'pegawai.jenis-komoditas.update',
        'destroy' => 'pegawai.jenis-komoditas.destroy',
    ]);


    Route::get('/pegawai/dkpp-notifikasi', [NotifikasiDkppController::class, 'index'])->name('pegawai.dkpp.notifikasi.index');
    Route::get('pegawai/dkpp/notifications/header', [NotifikasiDkppController::class, 'getHeaderNotifications']);
    Route::post('pegawai/dkpp/notifications/mark-read', [NotifikasiDkppController::class, 'markAsRead']);

    Route::post('/pegawai/dkpp/notifications/{id}/complete', [NotifikasiDkppController::class, 'markAsCompleted']);
    Route::post('/pegawai/dkpp/notifications/{id}/incomplete', [NotifikasiDkppController::class, 'markAsIncomplete']);
    Route::delete('pegawai/dkpp/notifications/{id}', [NotifikasiDkppController::class, 'destroy']);

    Route::post('pegawai/dkpp/notifikasi/filter', [NotifikasiDkppController::class, 'filter'])->name('pegawai.dkpp.notifikasi.filter');


    // Route::get('/pegawai/dkpp/notifikasi', function() {
    //     return view('pegawai.dkpp.pegawai-notifikasi-dkpp');
    // });
});
// DKPP END

// DTPHP
Route::middleware(['auth', 'role:dtphp'])->group(function () {
    Route::get('/pegawai/dtphp/dashboard', [PegawaiDtphpController::class, 'dashboard'])
        ->name('pegawai.dtphp.dashboard');
        
    Route::get('/pegawai/dtphp/dashboard-panen', [PegawaiDtphpController::class, 'dashboardPanen'])
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
    
    Route::resource('/pegawai/jenis_tanaman', PegawaiJenisTanamanController::class)->names([
        'index'   => 'pegawai.jenis-tanaman.index',
        'create'  => 'pegawai.jenis-tanaman.create',
        'store'   => 'pegawai.jenis-tanaman.store',
        'show'    => 'pegawai.jenis-tanaman.show',
        'edit'    => 'pegawai.jenis-tanaman.edit',
        'update'  => 'pegawai.jenis-tanaman.update',
        'destroy' => 'pegawai.jenis-tanaman.destroy',
    ]);


    Route::get('/pegawai/dtphp-notifikasi', [NotifikasiDtphpController::class, 'index'])->name('pegawai.dtphp.notifikasi.index');
    Route::get('pegawai/dtphp/notifications/header', [NotifikasiDtphpController::class, 'getHeaderNotifications']);
    Route::post('pegawai/dtphp/notifications/mark-read', [NotifikasiDtphpController::class, 'markAsRead']);

    Route::post('/pegawai/dtphp/notifications/{id}/complete', [NotifikasiDtphpController::class, 'markAsCompleted']);
    Route::post('/pegawai/dtphp/notifications/{id}/incomplete', [NotifikasiDtphpController::class, 'markAsIncomplete']);
    Route::delete('pegawai/dtphp/notifications/{id}', [NotifikasiDtphpController::class, 'destroy']);

    Route::post('pegawai/dtphp/notifikasi/filter', [NotifikasiDtphpController::class, 'filter'])->name('pegawai.dtphp.notifikasi.filter');

    // Route::get('/pegawai/dtphp/notifikasi', function() {
    //     return view('pegawai.dtphp.pegawai-notifikasi-dtphp');
    // });
});
// DTPHP END

// PERIKANAN
Route::middleware(['auth', 'role:perikanan'])->group(function () {
    Route::get('/pegawai/perikanan/dashboard', [PegawaiPerikananController::class, 'dashboard'])
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
    
    Route::resource('/pegawai/jenis_ikan', PegawaiJenisIkanController::class)->names([
        'index'   => 'pegawai.jenis-ikan.index',
        'create'  => 'pegawai.jenis-ikan.create',
        'store'   => 'pegawai.jenis-ikan.store',
        'show'    => 'pegawai.jenis-ikan.show',
        'edit'    => 'pegawai.jenis-ikan.edit',
        'update'  => 'pegawai.jenis-ikan.update',
        'destroy' => 'pegawai.jenis-ikan.destroy',
    ]);


    Route::get('/pegawai/perikanan-notifikasi', [NotifikasiPerikananController::class, 'index'])->name('pegawai.perikanan.notifikasi.index');
    Route::get('pegawai/perikanan/notifications/header', [NotifikasiPerikananController::class, 'getHeaderNotifications']);
    Route::post('pegawai/perikanan/notifications/mark-read', [NotifikasiPerikananController::class, 'markAsRead']);

    Route::post('/pegawai/perikanan/notifications/{id}/complete', [NotifikasiPerikananController::class, 'markAsCompleted']);
    Route::post('/pegawai/perikanan/notifications/{id}/incomplete', [NotifikasiPerikananController::class, 'markAsIncomplete']);
    Route::delete('pegawai/perikanan/notifications/{id}', [NotifikasiPerikananController::class, 'destroy']);

    Route::post('pegawai/perikanan/notifikasi/filter', [NotifikasiPerikananController::class, 'filter'])->name('pegawai.perikanan.notifikasi.filter');

    // Route::get('/pegawai/perikanan/notifikasi', function() {
    //     return view('pegawai.perikanan.pegawai-notifikasi-perikanan');
    // });
});
// PERIKANAN END

// PEGAWAI END

Route::middleware(['auth', 'role:pimpinan'])->group(function () {
    //Pimpinan 
    Route::get('/pimpinan/dashboard', [PimpinanController::class,'index'] )->name('pimpinan.dashboard');
    Route::get('/pimpinan/disperindag', [PimpinanController::class,'disperindag'] )->name('pimpinan.disperindag');
    Route::get('/pimpinan/dkpp', [PimpinanController::class,'dkpp'] )->name('pimpinan.dkpp');
    Route::get('/pimpinan/dtphp-panen', [PimpinanController::class,'panen'] )->name('pimpinan.dtphp-panen');
    Route::get('/pimpinan/dtphp-volume', [PimpinanController::class,'volume'] )->name('pimpinan.dtphp-volume');
    Route::get('/pimpinan/perikanan', [PimpinanController::class,'perikanan'] )->name('pimpinan.perikanan');
    //Pimpinan END
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
