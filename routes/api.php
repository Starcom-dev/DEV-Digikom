<?php

use App\Http\Controllers\Api\OpsiBayarController;
use App\Http\Controllers\Api\KategoriPembayaranController;
use App\Http\Controllers\Api\UsahaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\IuranController;
use App\Http\Controllers\Api\AnggaranDasarController;
use App\Http\Controllers\Api\AnggaranRumahTanggaController;
use App\Http\Controllers\Api\PeraturanOrganisasiController;
use App\Http\Controllers\Api\PengurusController;
use App\Http\Controllers\Api\UsahaAnggotaController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\AgamaController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TagihanController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\Pembayaran\PembayaranEwalletController;
use App\Http\Controllers\Api\Pembayaran\PembayaranVaController;
use App\Http\Controllers\Api\Pembayaran\PembayaranQrisController;
use App\Http\Controllers\Api\Pembayaran\PembayaranCardController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BidangUsahaController;
use App\Http\Controllers\Api\CallbackPayment\CallbackEwalletController;
use App\Http\Controllers\Api\CallbackPayment\CallbackQrisController;
use App\Http\Controllers\Api\CallbackPayment\CallbackVaController;
use App\Http\Controllers\Api\CategoryUsahaController;
use App\Http\Controllers\API\JabatanController;
use App\Http\Controllers\API\OrganisasiController;
use App\Http\Controllers\Api\Pembayaran\FinpayController;
use App\Http\Middleware\CheckMembership;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;


Route::post('/auth/logout', LogoutController::class)->middleware('jwt.auth')->name('logout');
Route::post('/auth/login', LoginController::class)->name('login');
Route::post('/auth/register', [RegisterController::class, 'register']);
Route::delete('/auth/user/{id}', [RegisterController::class, 'destroy']);

Route::get('/test-log', function () {
    Log::channel('single')->info('Test Log: Verifying single channel logging.');
    return response()->json(['message' => 'Log written!']);
});

Route::middleware(['jwt.auth'])->group(function () {
    Route::apiResource('/user', UserController::class);
    Route::get('/smart-card', [UserController::class, 'smartCard']);
    Route::post('/user/edit-profile', [UserController::class, 'update']);
    Route::post('/user/edit-foto-profile', [UserController::class, 'updateFoto']);
    // ubah agar tidak menggunakan route post
    Route::apiResource('/usaha', UsahaController::class)->middleware(CheckMembership::class);

    Route::apiResource('/berita', BeritaController::class)
        ->middleware(CheckMembership::class)
        ->names([
            'index' => 'berita.index',
            'store' => 'berita.store',
            'show' => 'berita.show',
            'update' => 'berita.update',
            'destroy' => 'berita.destroy',
            'search' => 'berita.search',
        ]);

    Route::apiResource('/kegiatan', KegiatanController::class)->middleware(CheckMembership::class);

    Route::apiResource('/iuran', IuranController::class)
        ->names([
            'index' => 'iuran_custom.index',
            'store' => 'iuran_custom.store',
            'show' => 'iuran_custom.show',
            'update' => 'iuran_custom.update',
            'destroy' => 'iuran_custom.destroy',
        ]);

    Route::apiResource('/anggaran-dasar', AnggaranDasarController::class)->middleware(CheckMembership::class);

    Route::apiResource('/anggaran-rumah-tangga', AnggaranRumahTanggaController::class)->middleware(CheckMembership::class);

    Route::apiResource('/peraturan-organisasi', PeraturanOrganisasiController::class);

    Route::apiResource('/jabatan', JabatanController::class);

    Route::apiResource('/pengurus', PengurusController::class);
    Route::get('/pengurus/jabatan/{jabatan}', [PengurusController::class, 'search']);

    Route::apiResource('/usaha-anggota', UsahaAnggotaController::class);
    Route::get('/my-usaha', [UsahaAnggotaController::class, 'myUsaha']);
    Route::get('/bidang-usaha', [BidangUsahaController::class, 'index']);
    Route::post('/bidang-usaha', [BidangUsahaController::class, 'store']);
    Route::get('/category-usaha', [CategoryUsahaController::class, 'index']);
    Route::post('/category-usaha', [CategoryUsahaController::class, 'store']);

    Route::apiResource('/pendidikan', PendidikanController::class);

    Route::apiResource('/agama', AgamaController::class);

    Route::apiResource('/pekerjaan', PekerjaanController::class);

    // Route::apiResource('/tagihan', TagihanController::class);

    Route::apiResource('/opsi-bayar', OpsiBayarController::class);

    Route::apiResource('/kategori-bayar', KategoriPembayaranController::class);

    // Route::post('/tagihan/bayar-card', [PembayaranCardController::class, 'bayarCard']);
    Route::post('/tagihan/bayar-ewallet', [PembayaranEwalletController::class, 'bayarEwallet']);
    Route::post('/tagihan/bayar-va', [PembayaranVaController::class, 'bayarVa']);
    Route::post('/tagihan/bayar-qris', [PembayaranQrisController::class, 'bayarQris']);

    Route::get('transactions', [TransactionController::class, 'index']);
    Route::get('transactions/{id}', [TransactionController::class, 'show']);

    Route::get('/banner', [BannerController::class, 'index'])->middleware(CheckMembership::class);

    Route::get('/tentang-organisasi', [OrganisasiController::class, 'tentangOrganisasi']);

    // finpay payment
    Route::post('/finpay', [FinpayController::class, 'bayar']);
});

Route::get('/privacy/show', function () {
    // Return JSON response
    return response()->json([
        'success' => true,
        'data' => false, // atau false, tergantung kondisi
    ], 200);
});

// callback payment
Route::post('/callbackEwallet', [CallbackEwalletController::class, 'handle']);
Route::post('/callbackQris', [CallbackQrisController::class, 'handle']);
Route::post('/callbackVa', [CallbackVaController::class, 'handle']);
// github webhook
Route::post('/git-webhook', function () {
    Log::channel('single')->info('Test Log: Verifiy git webhook..');
    try {
        $output = Artisan::call('git:pull');
        Log::channel('single')->info('Git pull output:', ['output' => Artisan::output()]);
    } catch (\Exception $e) {
        Log::error('Git pull error: ' . $e->getMessage());
    }
    return response()->json(['status' => 'success']);
});

// test create callback yong
Route::post('/callbackFinpay', function () {
    Log::channel('single')->info('Test FInpay...');
});
