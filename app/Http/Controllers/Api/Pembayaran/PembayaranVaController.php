<?php
namespace App\Http\Controllers\Api\Pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class PembayaranVaController extends Controller
{
    public function bayarVa(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'iuran_id' => 'required|integer',
                'nominal' => 'required|numeric|min:1',
                'metode_pembayaran' => 'required|string|in:BNI,MANDIRI,BRI', // misalnya, sesuaikan dengan bank yang Anda dukung
                'no_hp' => 'nullable|string',
                'keterangan' => 'nullable|string|max:255',
            ]);

            $adminFee = \DB::table('opsi_bayars')
            ->where('kode', $validated['metode_pembayaran'])
            ->value('biaya_tetap');

            // Ambil user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Buat ID Transaksi unik
            $id_transaksi = 'VA' . now()->format('YmdHis') . $validated['iuran_id'];
            $nominal = $validated['nominal'];

            // Konfigurasi payload
            $payload = [
                "external_id" => $id_transaksi,
                "bank_code" => $validated['metode_pembayaran'], // Misal 'BNI'
                "name" => $user->full_name, // Anda bisa ambil nama dari user yang login
                "is_closed" => "true",
                "expected_amount" => $nominal + $adminFee,
                "is_single_use" => "true"
            ];
            Log::channel('single')->debug('Payload untuk API Xendit', $payload);

            // Kirim permintaan ke API Xendit menggunakan Http:: (Laravel)
            // $response = Http::timeout(30)  // Timeout 30 detik
            //     ->withHeaders([  // Menambahkan headers kustom
            //         'Authorization' => 'Basic ' . base64_encode(config('services.xendit.api_key') . ':'),
            //         'for-user-id' => config('services.xendit.user_id'),  // ID pengguna dari konfigurasi
            //         'Content-Type' => 'application/json',
            //     ])
            //     ->post('https://api.xendit.co/callback_virtual_accounts', $payload);

            // $apiKey = 'xnd_public_development_ol47f4f0kEfPw8dc7ZifHxwGaBJhGsDQCqG0sdPKkw50VSWSarz9ubK71YsksPG' ;
            $apiKey = 'xnd_development_5UZCVR2pmMo9zjnFKWjDGaUjSWDWXxLUUKtBcIYXliUy9bqXpovluK3Gu0iXQC' ;
            $authHeader = 'Basic ' . base64_encode($apiKey . ':');
            // Gunakan ID pengguna secara eksplisit

            $userId = '65694e8b303521a8abfbd7db';  // Ganti dengan ID pengguna yang valid

            // Kirim permintaan ke API Xendit menggunakan Http:: (Laravel)
            $response = Http::timeout(30)  // Timeout 30 detik
                ->withHeaders([  // Menambahkan headers kustom
                    'Authorization' => $authHeader,
                    // 'for-user-id' => $userId,  // ID pengguna yang benar
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.xendit.co/callback_virtual_accounts', $payload);


            // Log status dan respons
            Log::channel('single')->info('Status respons dari API Xendit', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
            ]);

            // Cek jika request gagal
            if ($response->failed()) {
                Log::channel('single')->error('Gagal memproses pembayaran', [
                    'status' => $response->status(),
                    'error_message' => $response->body(),
                    'response' => $response->json(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memproses pembayaran.',
                    'details' => $response->json(),
                ], 400);
            }

            // Ambil respons JSON dari Xendit
            $json = $response->json();
            Log::channel('single')->info('Transaksi berhasil diproses', $json);

            // Simpan transaksi ke database
            DB::table('tagihans')
            ->where('id', $validated['iuran_id'])
            ->update([
                'user_id' => $user->id,
                'status' => 'Belum Lunas',
                'tanggal_bayar' => now(),
                'nominal' => $validated['nominal'] + $adminFee,
                'metode_pembayaran' =>  $validated['metode_pembayaran'], // Gabung string
                'payment_status' => $json['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $recentTransaction_id = DB::table('transactions')->insertGetId([
                'status_transaction' => 'pending',
                'id_transaction' => $id_transaksi,  // You may want to change this if it's generated elsewhere
                'created_at' => now(),
                'user_id' => $user->id,
                'tagihan_id' => $validated['iuran_id'],
                'nominal' => $validated['nominal'] + $adminFee,
            ]);

            Log::channel('single')->info('Transaksi berhasil disimpan', ['user_id' => $user->id, 'id_transaksi' => $id_transaksi]);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses.',
                'nominal' => $validated['nominal'],
                'admin' => $adminFee,
                'total' => $validated['nominal'] + $adminFee,
                'id_transaksi' => $recentTransaction_id,
                'data' => [
                    'id' => $json['id'],
                    'status' => $json['status'],
                    'channel_code' => $validated['metode_pembayaran'],
                    'kode_bayar' => $json['account_number'], // Ambil account_number dari response Xendit
                ],
            ], 200);

        } catch (Exception $e) {
            // Tangani error yang terjadi dalam controller
            Log::channel('single')->error('Terjadi kesalahan pada pembayaran Virtual Account', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Mengembalikan error 500 jika ada kesalahan dalam aplikasi
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan internal.',
                'details' => 'Silakan coba lagi nanti.',
            ], 500);
        }
    }
}
