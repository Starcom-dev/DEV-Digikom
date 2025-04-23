<?php

use App\Http\Controllers\HtmlController;
use App\Http\Controllers\IuranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PrivacyController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage linked successfully!';
});

Route::middleware(['auth:admin'])->group(function () {
    Route::resource('/', \App\Http\Controllers\IndexController::class);
    Route::resource('/iuran', \App\Http\Controllers\IuranController::class);
    Route::get('/tagihan/{id}', [IuranController::class, 'showTagihan'])->name('tagihan.show');

    Route::get('/laporan-iuran', [IuranController::class, 'laporanIuran'])->name('iuran.tagihan');
    Route::resource('/berita', \App\Http\Controllers\BeritaController::class);
    Route::resource('/kegiatan', \App\Http\Controllers\KegiatanController::class);
    Route::resource('/anggaran-dasar', \App\Http\Controllers\AnggaranDasarController::class);
    Route::resource('/anggaran-rumah-tangga', \App\Http\Controllers\AnggaranRumahTanggaController::class);
    Route::resource('/peraturan-organisasi', \App\Http\Controllers\PeraturanOrganisasiController::class);
    Route::resource('/jabatan', \App\Http\Controllers\JabatanController::class);
    Route::post('/anggota/toggle-suspend/{id}', [UserController::class, 'toggleSuspend'])->name('anggota.toggleSuspend');

    Route::resource('/anggota', \App\Http\Controllers\UserController::class);
    Route::get('/pendaftar', [RegisterController::class, 'index'])->name('pendaftar');
    Route::get('/pendaftar/{user}', [RegisterController::class, 'show'])->name('pendaftar.show');
    Route::put('/pendaftar/update/{id}/{status}', [RegisterController::class, 'update'])->name('update_pendaftar');

    Route::resource('/pengurus', \App\Http\Controllers\PengurusController::class);
    Route::resource('/usaha', \App\Http\Controllers\UsahaController::class);
    Route::get('/iuran/{id}/enroll', [IuranController::class, 'enrollTagihan'])->name('iuran.enroll');

    Route::resource('/banner', \App\Http\Controllers\BannerController::class);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/peraturanOrganisasi', [HtmlController::class, 'indexPeraturanOrganisasi'])->name('peraturanOrganisasi');
Route::get('/anggaranDasar', [HtmlController::class, 'indexAnggaranDasar'])->name('anggaranDasar');
Route::get('/anggaranRumahTangga', [HtmlController::class, 'indexAnggaranRumahTangga'])->name('anggaranRumahTangga');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/test-log', function () {
    try {
        Log::info('Test log entry');
        return 'Log successfully written!';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

Route::get('/privacy', [PrivacyController::class, 'privacy'])->name('privacy');
Route::get('/privacy/remove', [PrivacyController::class, 'remove'])->name('privacy.remove');
