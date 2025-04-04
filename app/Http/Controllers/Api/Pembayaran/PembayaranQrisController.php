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
                'nominal' => 'required|numeric|min:1',
                'metode_pembayaran' => 'required|string|in:ID_QRIS',
                'keterangan' => 'nullable|string|max:255',
            ]);
    
            // Ambil user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();
    
            // Buat ID Transaksi unik
            $id_transaksi = 'DGX' . now()->format('YmdHis') . $validated['iuran_id'];
            $nominal = $validated['nominal'];
    
            // Konfigurasi payload untuk QRIS
            $payload = [
                "reference_id" => $id_transaksi,
                "currency" => "IDR",
                "amount" => $nominal,
                "checkout_method" => "ONE_TIME_PAYMENT",
                "channel_code" => $validated['metode_pembayaran'],
                "channel_properties" => [
                    'success_redirect_url' => config('app.url'),
                ],
            ];
    
            Log::channel('single')->debug('Payload untuk API Xendit QRIS', $payload);
    
            // Kirim permintaan ke API Xendit menggunakan Http:: (Laravel)
            $response = Http::timeout(30)  // Timeout 30 detik
                ->withBasicAuth(config('services.xendit.api_key'), '')
                ->withHeaders([  // Menambahkan headers kustom
                    'Authorization' => 'Basic ' . base64_encode(config('services.xendit.api_key') . ':'),
                    'for-user-id' => '65694e8b303521a8abfbd7db',  // Gunakan ID pengguna terautentikasi
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.xendit.co/qr/charges', $payload);
    
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
    
            // Ambil informasi kode bayar (QRIS)
            $kode_bayar = $json['actions']['qr_checkout_string'] ?? null;
    
            // Simpan transaksi ke database
            DB::table('tagihan')->insert([
                'user_id' => $user->id,
                'iuran_id' => $validated['iuran_id'],
                'status' => 'Belum Lunas',
                'tanggal_bayar' => null,
                'nominal' => $nominal,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'keterangan' => $validated['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            Log::channel('single')->info('Transaksi berhasil disimpan', ['user_id' => $user->id, 'id_transaksi' => $id_transaksi]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil diproses.',
                'data' => [
                    'id' => $json['id'],
                    'status' => $json['status'],
                    'channel_code' => $validated['metode_pembayaran'],
                    'kode_bayar' => $kode_bayar, // Menampilkan QRIS untuk pembayaran
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
