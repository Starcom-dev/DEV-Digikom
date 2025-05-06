<?php

use App\Http\Controllers\HtmlController;
use App\Http\Controllers\IuranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\SyaratKetentuanAplikasi;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage linked successfully!';
});

Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('/auth/reset-password', [AuthController::class, 'saveResetPassword'])->name('reset-password');
Route::get('/auth/reset-password-success', [AuthController::class, 'successResetPassword'])->name('reset-password-success');

Route::middleware(['auth:admin'])->group(function () {
    Route::resource('/', \App\Http\Controllers\IndexController::class);
    Route::get('/tagihan/{id}', [IuranController::class, 'showTagihan'])->name('tagihan.show');

    Route::resource('/berita', \App\Http\Controllers\BeritaController::class);
    Route::resource('/kegiatan', \App\Http\Controllers\KegiatanController::class);
    Route::resource('/anggaran-dasar', \App\Http\Controllers\AnggaranDasarController::class);
    Route::resource('/anggaran-rumah-tangga', \App\Http\Controllers\AnggaranRumahTanggaController::class);
    // Route::resource('/peraturan-organisasi', \App\Http\Controllers\PeraturanOrganisasiController::class);

    // Route::resource('/peraturan-organisasi', [OrganisasiController::class, 'peraturanOrganisasi'])->name('peraturan-organisasi');

    Route::get('/anggaran-dasar', [OrganisasiController::class, 'anggaranDasar'])->name('anggaran-dasar');
    Route::get('/edit-anggaran-dasar', [OrganisasiController::class, 'createAnggaranDasar'])->name('edit-anggaran-dasar');
    Route::post('/save-anggaran-dasar', [OrganisasiController::class, 'updateAnggaranDasar'])->name('save-anggaran-dasar');

    Route::get('/anggaran-rumah-tangga', [OrganisasiController::class, 'anggaranRumahTangga'])->name('anggaran-rumah-tangga');
    Route::get('/edit-anggaran-rumah-tangga', [OrganisasiController::class, 'createAnggaranRumahTangga'])->name('edit-anggaran-rumah-tangga');
    Route::post('/save-anggaran-rumah-tangga', [OrganisasiController::class, 'updateAnggaranRumahTangga'])->name('save-anggaran-rumah-tangga');

    Route::get('/peraturan-organisasi', [OrganisasiController::class, 'peraturanOrganisasi'])->name('peraturan-organisasi');
    Route::get('/peraturan-organisasi/edit', [OrganisasiController::class, 'createPeraturanOrganisasi'])->name('edit-peraturan-organisasi');
    Route::post('/peraturan-organisasi/save', [OrganisasiController::class, 'updatePeraturanOrganisasi'])->name('save-peraturan-organisasi');

    Route::get('/tentang-organisasi', [OrganisasiController::class, 'tentangOrganisasi'])->name('tentang-organisasi');
    Route::get('/tentang-organisasi/edit', [OrganisasiController::class, 'createTentangOrganisasi'])->name('edit-tentang-organisasi');
    Route::post('/tentang-organisasi/save', [OrganisasiController::class, 'updateTentangOrganisasi'])->name('save-tentang-organisasi');

    Route::get('/privacy-edit', [OrganisasiController::class, 'privacy'])->name('privacy-edit');
    Route::post('/privacy-save', [OrganisasiController::class, 'updatePrivacy'])->name('privacy-save');

    Route::get('/syaratketentuanaplikasi-edit', [OrganisasiController::class, 'syaratAplikasi'])->name('syaratketentuanaplikasi-edit');
    Route::post('/syaratketentuanaplikasi-save', [OrganisasiController::class, 'updateSyaratAplikasi'])->name('syaratketentuanaplikasi-save');

    Route::resource('/jabatan', \App\Http\Controllers\JabatanController::class);
    Route::post('/anggota/toggle-suspend/{id}', [UserController::class, 'toggleSuspend'])->name('anggota.toggleSuspend');

    Route::resource('/anggota', \App\Http\Controllers\UserController::class);
    Route::get('/pendaftar', [RegisterController::class, 'index'])->name('pendaftar');
    Route::get('/pendaftar/{user}', [RegisterController::class, 'show'])->name('pendaftar.show');
    Route::put('/pendaftar/update/{id}/{status}', [RegisterController::class, 'update'])->name('update_pendaftar');

    Route::resource('/pengurus', \App\Http\Controllers\PengurusController::class);
    Route::resource('/usaha', \App\Http\Controllers\UsahaController::class);

    Route::resource('/iuran', \App\Http\Controllers\IuranController::class);
    Route::get('/laporan-iuran', [IuranController::class, 'laporanIuran'])->name('iuran.tagihan');
    Route::get('/print-iuran', [IuranController::class, 'printIuran'])->name('iuran.print');
    Route::get('/iuran/{id}/enroll', [IuranController::class, 'enrollTagihan'])->name('iuran.enroll');

    Route::resource('/banner', \App\Http\Controllers\BannerController::class);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::get('/peraturanOrganisasi', [HtmlController::class, 'indexPeraturanOrganisasi'])->name('peraturanOrganisasi');
// Route::get('/anggaranDasar', [HtmlController::class, 'indexAnggaranDasar'])->name('anggaranDasar');
// Route::get('/anggaranRumahTangga', [HtmlController::class, 'indexAnggaranRumahTangga'])->name('anggaranRumahTangga');
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
Route::get('/syarat-ketentuan-penggunaan-aplikasi', [SyaratKetentuanAplikasi::class, 'syaratApk']);
