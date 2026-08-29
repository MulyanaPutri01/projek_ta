<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\SekretarisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\TakmirController;
use App\Http\Controllers\PosisiController;
use App\Http\Controllers\KepanitiaanController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\LandingPageController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\ProfilMasjidController;

// -------------------------------------------------------------
// Guest / Landing Page Routes
// -------------------------------------------------------------
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
});

// Authentication Routes (Hanya untuk pengguna yang BELUM login)
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// -------------------------------------------------------------
// Authenticated Routes (Harus Login)
// -------------------------------------------------------------
Route::middleware(['auth', 'prevent-back'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // Routes for ADMIN (Hanya Pengguna & Galeri)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Kelola Pengguna (Users & Takmir)
        Route::resource('users', UserController::class);
        Route::resource('takmir', TakmirController::class);
        Route::match(['post', 'put'], 'takmir/{id_takmir}/toggle-status', [TakmirController::class, 'toggleStatus'])->name('takmir.toggleStatus');

        // Kelola Galeri
        Route::resource('galeri', GaleriController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('profilmasjid', ProfilMasjidController::class)->except(['show']);
    });

    // ==========================================
    // Routes for BENDAHARA
    // ==========================================
    Route::middleware('role:bendahara')->group(function () {
        Route::get('/bendahara-dashboard', [BendaharaController::class, 'index'])->name('bendahara.dashboard');
        Route::resource('keuangan', KeuanganController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('donatur', DonaturController::class);
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');
        Route::get('/laporan-cetak', [LaporanKeuanganController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/laporan-pdf', [LaporanKeuanganController::class, 'pdf'])->name('laporan.pdf');
    });

    // ==========================================
    // Routes for SEKRETARIS
    // ==========================================
    Route::middleware('role:sekretaris')->group(function () {
        Route::get('/sekretaris-dashboard', [SekretarisController::class, 'index'])->name('sekretaris.dashboard');
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('kepanitiaan', KepanitiaanController::class);
        Route::resource('posisi', PosisiController::class);
        Route::resource('inventaris', InventarisController::class);
        Route::resource('catatan', CatatanController::class);
        Route::resource('kondisi', KondisiController::class);
        //Route::resource('galeri', GaleriController::class);
    });
});

// -------------------------------------------------------------
// Public / General Routes
// -------------------------------------------------------------


Route::get('/api/kegiatan', [KegiatanController::class, 'getEvents'])->name('kegiatan.api');
Route::get('/kegiatan-calendar', [KegiatanController::class, 'calendar'])->name('kegiatan.calendar');
Route::get('/inventaris-pdf', [InventarisController::class, 'exportPdf'])->name('inventaris.pdf');
