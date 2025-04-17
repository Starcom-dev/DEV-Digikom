<?php

namespace App\Http\Controllers\Api\Pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class PembayaranEwalletController extends Controller
{
    public function bayarEwallet(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'iuran_id' => 'required|integer',
                // 'nominal' => 'required|numeric|min:1',
                'metode_pembayaran' => 'required|string|in:ID_OVO,ID_DANA,ID_LINKAJA,ID_SHOPEEPAY,ID_GOPAY,ID_QRIS',
                'no_hp' => 'nullable|string',
                // 'keterangan' => 'nullable|string|max:255',
            ]);

            $adminFee = DB::table('opsi_bayars')
                ->where('kode', $validated['metode_pembayaran'])
                ->value('biaya_tetap');

            // Ambil user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Buat ID Transaksi unik
            $id_transaksi = 'DGX' . now()->format('YmdHis') . $validated['iuran_id'];
            // $nominal = $validated['nominal'];

            // get nominal iuran
            $nominal = DB::table('iurans')->where(['id' => $validated['iuran_id']])->value('harga');

            // Konfigurasi payload
            $payload = [
                "reference_id" => $id_transaksi,
                "currency" => "IDR",
                "amount" => $nominal + $adminFee,
                "checkout_method" => "ONE_TIME_PAYMENT",
                "channel_code" => $validated['metode_pembayaran'],
                "channel_properties" => $this->generateChannelProperties($validated),
                "metadata" => [
                    "branch_area" => "PLUIT",
                    "branch_city" => "JAKARTA"
                ]
            ];

            Log::channel('single')->debug('Payload untuk API Xendit', $payload);

            $response = Http::timeout(30)  // Timeout 30 detik
                ->withBasicAuth(config('services.xendit.api_key'), '')
                ->withHeaders([  // Menambahkan headers kustom
                    'Authorization' => 'Basic ' . base64_encode(config('services.xendit.api_key') . ':'),
                    'for-user-id' => config('services.xendit.user_id'), // ID pengguna yang benar
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.xendit.co/ewallets/charges', $payload);

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
            Log::channel('single')->info('Transaksi Ewallet berhasil diproses', $json);

            // Ambil informasi kode bayar
            $kode_bayar = $this->getKodeBayar($validated['metode_pembayaran'], $json, $validated['no_hp']);

            // Simpan transaksi ke database
            // DB::table('tagihans')
            //     ->where('iuran_id', $validated['iuran_id'])
            //     ->update([
            //         'user_id' => $user->id,
            //         'status' => 'Belum Lunas',
            //         'tanggal_bayar' => now(),
            //         'nominal' => $validated['nominal'] + $adminFee,
            //         'metode_pembayaran' => $validated['metode_pembayaran'],
            //         'payment_status' => $json['status'],
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // $tagihan = DB::table('tagihans')->where('iuran_id', $validated['iuran_id'])->first();
            // if (!$tagihan) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Tagihan tidak ditemukan'
            //     ]);
            // }
            $tagihan_id = DB::table('tagihans')->insertGetId([
                'user_id' => $user->id,
                'iuran_id' => $validated['iuran_id'],
                'status' => 'Belum Lunas',
                'nominal' => $nominal + $adminFee,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'payment_status' => $json['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('transactions')->insert([
                'status_transaction' => 'pending',
                'id_transaction' => $id_transaksi,  // You may want to change this if it's generated elsewhere
                'created_at' => now(),
                'user_id' => $user->id,
                // 'tagihan_id' => $validated['iuran_id'],
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
                'data' => [
                    'id' => $id_transaksi,
                    'status' => $json['status'],
                    'channel_code' => $validated['metode_pembayaran'],
                    'kode_bayar' => $kode_bayar,
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

    private function generateChannelProperties(array $data): array
    {
        if ($data['metode_pembayaran'] === 'ID_OVO') {
            if (empty($data['no_hp'])) {
                throw new \InvalidArgumentException('Nomor HP diperlukan untuk pembayaran OVO.');
            }

            // Periksa dan ubah nomor HP ke format internasional
            $formattedNoHp = $this->formatPhoneNumber($data['no_hp']);
            return [
                'mobile_number' => $formattedNoHp,
            ];
        }

        return [
            'success_redirect_url' => config('app.url'),
        ];
    }

    private function formatPhoneNumber(string $no_hp): string
    {
        // Hapus spasi dan karakter selain angka
        $no_hp = preg_replace('/\D/', '', $no_hp);

        // Pastikan nomor HP dimulai dengan +62 (kode negara Indonesia)
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '+62' . substr($no_hp, 1);
        }

        // Validasi apakah nomor HP sudah sesuai dengan format internasional
        if (!preg_match('/^\+?[1-9]\d{1,14}$/', $no_hp)) {
            throw new \InvalidArgumentException('Nomor HP tidak valid.');
        }

        return $no_hp;
    }

    private function getKodeBayar(string $metode, array $json, ?string $no_hp): ?string
    {
        return match ($metode) {
            'ID_OVO' => $no_hp,
            'ID_DANA', 'ID_LINKAJA' => $json['actions']['mobile_web_checkout_url'] ?? null,
            'ID_SHOPEEPAY' => $json['actions']['mobile_deeplink_checkout_url'] ?? null,
            'ID_QRIS' => $json['actions']['qr_checkout_string'] ?? null,
            default => null,
        };
    }
}
