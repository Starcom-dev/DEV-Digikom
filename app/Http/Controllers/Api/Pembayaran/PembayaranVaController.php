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
                // 'nominal' => 'required|numeric|min:1',
                'metode_pembayaran' => 'required|string|in:BNI,MANDIRI,BRI', // misalnya, sesuaikan dengan bank yang Anda dukung
                'no_hp' => 'nullable|string',
                'keterangan' => 'nullable|string|max:255',
            ]);

            $adminFee = DB::table('opsi_bayars')
                ->where('kode', $validated['metode_pembayaran'])
                ->value('biaya_tetap');

            // Ambil user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Buat ID Transaksi unik
            $id_transaksi = 'VA' . now()->format('YmdHis') . $validated['iuran_id'];
            // $nominal = $validated['nominal'];

            // get nominal iuran
            $nominal = DB::table('iurans')->where(['id' => $validated['iuran_id']])->value('harga');

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
            $apiKey = config('services.xendit.api_key');
            $authHeader = 'Basic ' . base64_encode($apiKey . ':');
            $response = Http::timeout(30)  // Timeout 30 detik
                ->withHeaders([  // Menambahkan headers kustom
                    'Authorization' => $authHeader,
                    'for-user-id' => config('services.xendit.user_id'),  // ID pengguna yang benar
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
            Log::channel('single')->info('Transaksi VA berhasil diproses', $json);

            // Simpan transaksi  ke database
            $tagihan_id = DB::table('tagihans')->insertGetId([
                'user_id' => $user->id,
                'iuran_id' => $validated['iuran_id'],
                'status' => 'Belum Lunas',
                'tanggal_bayar' => null,
                'nominal' => $nominal + $adminFee,
                'metode_pembayaran' =>  $validated['metode_pembayaran'],
                'payment_status' => $json['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('transactions')->insertGetId([
                'id_transaction' => $id_transaksi,
                'status_transaction' => 'pending',
                'created_at' => now(),
                'user_id' => $user->id,
                'tagihan_id' => $tagihan_id,
                'nominal' => $nominal + $adminFee,
            ]);

            Log::channel('single')->info('Transaksi berhasil disimpan', ['user_id' => $user->id, 'id_transaksi' => $id_transaksi]);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses.',
                'nominal' => $nominal,
                'admin' => $adminFee,
                'total' => $nominal + $adminFee,
                'id_transaksi' => $id_transaksi,
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
