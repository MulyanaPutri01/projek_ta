<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\SekretarisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TakmirController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KepanitiaanController;
use App\Http\Controllers\PosisiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\ProfilMasjidController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// -------------------------------------------------------------
// Landing Page (Publik)
// -------------------------------------------------------------
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// -------------------------------------------------------------
// Authentication Routes
// -------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// -------------------------------------------------------------
// Authenticated Routes (Harus Login) - Protected by Dynamic Permissions
// -------------------------------------------------------------
Route::middleware(['auth', 'prevent-back'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboards
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/bendahara-dashboard', [BendaharaController::class, 'index'])->name('bendahara.dashboard');
    Route::get('/sekretaris-dashboard', [SekretarisController::class, 'index'])->name('sekretaris.dashboard');

    // Manajemen Pengguna & Hak Akses (Spatie Permissions)
    Route::middleware('permission:user-list|user-create|user-edit|user-delete')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('takmir', TakmirController::class);
        Route::match(['post', 'put'], 'takmir/{id}/toggle-status', [TakmirController::class, 'toggleStatus'])->name('takmir.toggleStatus');
    });

    Route::middleware('permission:role-list|role-create|role-edit|role-delete')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // Manajemen Keuangan & Donatur (Spatie Permissions)
    Route::middleware('permission:keuangan-list|keuangan-create|keuangan-edit|keuangan-delete')->group(function () {
        Route::resource('keuangan', KeuanganController::class);
    });

    Route::middleware('permission:donatur-list|donatur-create|donatur-edit|donatur-delete')->group(function () {
        Route::resource('donatur', DonaturController::class);
    });

    Route::middleware('permission:kategori-list|kategori-manage')->group(function () {
        Route::resource('kategori', KategoriController::class);
    });

    Route::middleware('permission:laporan-view')->group(function () {
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');
        Route::get('/laporan-keuangan/datatables', [LaporanKeuanganController::class, 'datatables'])->name('laporan.datatables');
    });

    Route::middleware('permission:laporan-print')->group(function () {
        Route::get('/laporan-cetak', [LaporanKeuanganController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/laporan-pdf', [LaporanKeuanganController::class, 'pdf'])->name('laporan.pdf');
    });

    // Agenda Kegiatan & Kepanitiaan (Spatie Permissions)
    Route::middleware('permission:kegiatan-list|kegiatan-create|kegiatan-edit|kegiatan-delete')->group(function () {
        Route::resource('kegiatan', KegiatanController::class)->except(['calendar']);
    });

    Route::middleware('permission:kepanitiaan-list|kepanitiaan-manage')->group(function () {
        Route::resource('kepanitiaan', KepanitiaanController::class);
    });

    Route::middleware('permission:posisi-manage')->group(function () {
        Route::resource('posisi', PosisiController::class);
    });

    // Inventaris & Catatan (Spatie Permissions)
    Route::middleware('permission:inventaris-list|inventaris-create|inventaris-edit|inventaris-delete')->group(function () {
        Route::resource('inventaris', InventarisController::class);
    });

    Route::middleware('permission:catatan-list|catatan-create|catatan-edit|catatan-delete')->group(function () {
        Route::resource('catatan', CatatanController::class);
    });

    Route::middleware('permission:kondisi-manage')->group(function () {
        Route::resource('kondisi', KondisiController::class);
    });

    // Informasi & Publikasi (Profil & Galeri) (Spatie Permissions)
    Route::middleware('permission:profilmasjid-view|profilmasjid-edit')->group(function () {
        Route::get('profilmasjid', [ProfilMasjidController::class, 'index'])->name('profilmasjid.index');
        Route::put('profilmasjid/{id}', [ProfilMasjidController::class, 'update'])->name('profilmasjid.update');
    });

    Route::middleware('permission:galeri-list|galeri-create|galeri-edit|galeri-delete')->group(function () {
        Route::resource('galeri', GaleriController::class);
    });
});

// -------------------------------------------------------------
// Public / General Routes
// -------------------------------------------------------------
Route::get('/api/kegiatan', [KegiatanController::class, 'getEvents'])->name('kegiatan.api');
Route::get('/kegiatan-calendar', [KegiatanController::class, 'calendar'])->name('kegiatan.calendar');
Route::get('/inventaris-pdf', [InventarisController::class, 'exportPdf'])->name('inventaris.pdf');
