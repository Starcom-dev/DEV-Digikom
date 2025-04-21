<?php

namespace App\Http\Controllers\Api\Pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class PembayaranQrisController extends Controller
{
    public function bayarQris(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'iuran_id' => 'required|integer',
                'metode_pembayaran' => 'required|string|in:ID_QRIS',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Ambil user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Buat ID Transaksi unik
            $id_transaksi = 'DGX' . now()->format('YmdHis') . $validated['iuran_id'];

            // get nominal iuran
            $nominal = DB::table('iurans')->where(['id' => $validated['iuran_id']])->value('harga');

            $payload = [
                'external_id' => $id_transaksi,
                'type' => 'DYNAMIC',
                'currency' => 'IDR',
                'amount' => $nominal,
                'callback_url' => config('app.url') . 'api/callbackQris',
            ];

            Log::channel('single')->debug('Payload QRIS untuk API Xendit', $payload);

            // Kirim permintaan ke API Xendit menggunakan Http:: (Laravel)
            $apiKey = config('services.xendit.api_key');
            $authHeader = 'Basic ' . base64_encode($apiKey . ':');
            $response = Http::timeout(30)  // Timeout 30 detik
                ->withHeaders([  // Menambahkan headers kustom
                    'Authorization' => $authHeader,
                    'for-user-id' => config('services.xendit.user_id'),  // Gunakan ID pengguna terautentikasi
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.xendit.co/qr_codes', $payload);

            // Log status dan respons
            Log::channel('single')->info('Status respons QRIS dari API Xendit', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
            ]);

            // Cek jika request gagal
            if ($response->failed()) {
                Log::channel('single')->error('Gagal memproses pembayaran QRIS', [
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
            Log::channel('single')->info('Transaksi QRIS berhasil diproses', $json);

            // Ambil informasi kode bayar (QRIS)
            // $kode_bayar = $json['actions']['qr_checkout_string'] ?? null;

            // Simpan transaksi ke database
            $tagihan_id = DB::table('tagihans')->insertGetId([
                'user_id' => $user->id,
                'iuran_id' => $validated['iuran_id'],
                'status' => 'Belum Lunas',
                'tanggal_bayar' => null,
                'nominal' => $nominal,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'keterangan' => $validated['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
                'payment_status' => 'PENDING',
                'kode_bayar' => $json['qr_string']
            ]);

            DB::table('transactions')->insert([
                'status_transaction' => 'pending',
                'id_transaction' => $id_transaksi,  // You may want to change this if it's generated elsewhere
                'created_at' => now(),
                'user_id' => $user->id,
                // 'tagihan_id' => $validated['iuran_id'],
                'tagihan_id' => $tagihan_id,
                'nominal' => $nominal
            ]);

            Log::channel('single')->info('Transaksi QRIS berhasil disimpan', ['user_id' => $user->id, 'id_transaksi' => $id_transaksi]);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil diproses.',
                'data' => [
                    'id' => $json['external_id'],
                    'status' => $json['status'],
                    'channel_code' => $validated['metode_pembayaran'],
                    'qr_string' => $json['qr_string'], // Menampilkan QRIS untuk pembayaran
                ],
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('single')->error('Validasi gagal', ['errors' => $e->errors()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'details' => $e->errors(),
            ], 422);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            Log::channel('single')->error('JWT error', ['message' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid.',
                'details' => $e->getMessage(),
            ], 401);
        } catch (\Exception $e) {
            Log::channel('single')->error('Kesalahan server', ['exception' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
