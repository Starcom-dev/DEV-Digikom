<?php

namespace App\Http\Controllers\Api\Pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class FinpayController extends Controller
{
    public function bayar(Request $request)
    {
        try {
            $validated = $request->validate([
                'iuran_id' => 'required|numeric',
                'metode_pembayaran' => 'required|string',
                'nomor_handphone' => 'required|string'
            ]);

            // Ambil user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // cek iuran exist
            $iuran = DB::table('iurans')->where(['id' => $request->iuran_id])->first();
            if (!$iuran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Iuran tidak ditemukan'
                ], 404);
            }

            // create id transaksi
            $id_transaksi = 'DGX' . now()->format('YmdHis') . $validated['iuran_id'];

            // create payload untuk finpay
            $ewallet_methode = ['dana', 'linkaja', 'ovo', 'shopeepay', 'gopay'];
            $bank_methode = ['bni', 'bri', 'bca'];
            $va_methode = ['vamandiri', 'vabca', 'vabjb', 'vabni', 'vabri', 'vabsi', 'vabtn'];
            $qris_methode = ['qris'];
            $cc_methode = ['cc'];
            if (in_array($request->metode_pembayaran, $ewallet_methode)) {
                $payload = $this->payload_ewallet($request, $user, $id_transaksi, $iuran);
            } else if (in_array($request->metode_pembayaran, $bank_methode)) {
                $payload = $this->payload_bank($request, $user, $id_transaksi, $iuran);
            } else if (in_array($request->metode_pembayaran, $va_methode)) {
                $payload = $this->payload_va($request, $user, $id_transaksi, $iuran);
            } else if (in_array($request->metode_pembayaran, $qris_methode)) {
                $payload = $this->payload_qris($request, $user, $id_transaksi, $iuran);
            } else if (in_array($request->metode_pembayaran, $cc_methode)) {
                $payload =  $this->payload_va($request, $user, $id_transaksi, $iuran);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Metode pembayaran tidak sesuai'
                ], 404);
            }

            // create authorization
            $key = config('services.finpay.merchant_id') . ':' . config('services.finpay.merchant_key');
            $authorizathion = 'Basic ' . base64_encode($key);
            $url = config('services.finpay.url_sandbox');

            // create request finpay
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => $authorizathion,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($url, $payload);

            // Log::channel('single')->info('Response Finpay :' . $response);
            Log::channel('single')->info('Status respons dari Finpay', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
            ]);

            // convert response to json type
            $json = $response->json();

            // create response by methode payment
            if ($response->status() != 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error : ' . $json['responseMessage']
                ], 403);
            }
            $default_response = [
                'response_message' => $json['responseMessage'],
                'redirect_url'     => $json['redirecturl'],
                'expiry_link'      => $json['expiryLink'],
            ];
            if (in_array($request->metode_pembayaran, $cc_methode)) {
                $data_response = array_merge($default_response, [
                    'app_url'     => '',
                    'image_url'   => '',
                    'payment_code' => '',
                    'string_qr'   => '',
                ]);
            } else {
                $data_response = array_merge($default_response, [
                    'app_url'     => $json['appurl'] ?? '',
                    'image_url'   => $json['imageurl'] ?? '',
                    'payment_code' => $json['paymentCode'] ?? '',
                    'string_qr'   => $json['stringQr'] ?? '',
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $data_response
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

    public function payload_ewallet($request, $user, $id_transaksi, $iuran)
    {
        // create payload untuk finpay
        $payload = [
            'customer' => [
                'id' => 'cust_' . $user->id,
                'email' => $user->email,
                'firstName' => 'first_name_cust',
                'lastName' => 'last_name_cust',
                'mobilePhone' => $this->convert_mobilephone_format_62($request->nomor_handphone),
            ],
            'order' => [
                'id' => $id_transaksi,
                'amount' => $iuran->jumlah,
                'currency' => 'IDR',
                'description' => 'Testing ' . $request->metode_pembayaran,
                'item' => [[
                    'name' => $iuran->keterangan,
                    'quantity' => 1,
                    'unitPrice' => $iuran->jumlah,
                    'category' => "Some category",
                    'description' => "Item description",
                    'unitPrice' => 10000
                ]]
            ],
            'url' => [
                'callbackUrl' => 'https://sandbox.finpay.co.id/simdev/finpay/result/resultsuccess.php'
            ],
            'sourceOfFunds' => [
                'type' => $request->metode_pembayaran,
                'accountId' => $this->convert_mobilephone_format_08($request->nomor_handphone),
            ]
        ];

        return $payload;
    }

    public function payload_bank($request, $user, $id_transaksi, $iuran)
    {
        $payload = [
            'customer' => [
                'email' => $user->email,
                'firstName' => '',
                'firstName' => '',
                'mobilePhone' => $this->convert_mobilephone_format_62($request->nomor_handphone),
            ],
            'order' => [
                'id' => $id_transaksi,
                'amount' => $iuran->nominal,
                'description' => 'Testing ' . $request->metode_pembayaran,
            ],
            'url' => [
                'successUrl' => "https://sandbox.finpay.co.id/simdev/finpay/result/resultsuccess.php",
                'failUrl' => "https://sandbox.finpay.co.id/simdev/finpay/result/resultfailed.php",
                'callbackUrl' => "https://sandbox.finpay.co.id/simdev/finpay/result/resultfailed.php"
            ],
            'sourceOfFunds' => [
                'type' => "ovo",
            ]
        ];
        return $payload;
    }

    public function payload_qris($request, $user, $id_transaksi, $iuran)
    {
        $payload  = [
            'customer' => [
                'email' => $user->email,
                'firstName' => "First name customer",
                'lastName' => "Last name customer",
                'mobilePhone' => $this->convert_mobilephone_format_62($request->nomor_handphone)
            ],
            'order' => [
                'id' => $id_transaksi,
                'amount' => $iuran->jumlah,
                'description' => 'Testing ' . $request->metode_pembayaran,
            ],
            'url' => [
                'callbackUrl' => "https://sandbox.finpay.co.id/simdev/finpay/result/resultsuccess.php"
            ],
            'sourceOfFunds' => [
                'type' => "qris"
            ]
        ];
        return $payload;
    }

    public function payload_cc($request, $user, $id_transaksi, $iuran)
    {
        $payload  = [
            'customer' => [
                'email' => $user->email,
                'firstName' => "First name customer",
                'lastName' => "Last name customer",
                'mobilePhone' => $this->convert_mobilephone_format_62($request->nomor_handphone)
            ],
            'order' => [
                'id' => $id_transaksi,
                'amount' => $iuran->jumlah,
                'description' => 'Testing ' . $request->metode_pembayaran,
            ],
            'url' => [
                'callbackUrl' => "https://sandboxx.finpay.co.id/simdev/finpay/result/tangkapCurl.php"
            ],
            'sourceOfFunds' => [
                'type' => 'cc'
            ]
        ];
        return $payload;
    }
    public function payload_va($request, $user, $id_transaksi, $iuran)
    {
        $payload  = [
            'customer' => [
                'email' => $user->email,
                'firstName' => "First name customer",
                'lastName' => "Last name customer",
                'mobilePhone' => $this->convert_mobilephone_format_62($request->nomor_handphone)
            ],
            'order' => [
                'id' => $id_transaksi,
                'amount' => $iuran->jumlah,
                'currency' => 'IDR',
                'description' => 'Testing ' . $request->metode_pembayaran,
            ],
            'url' => [
                'callbackUrl' => "https://sandbox.finpay.co.id/simdev/finpay/result/resultsuccess.php"
            ],
            'sourceOfFunds' => [
                'type' => $request->metode_pembayaran
            ]
        ];
        return $payload;
    }

    function convert_mobilephone_format_62($mobile_phone)
    {
        $mobile_phone = preg_replace('/[\s\-.]/', '', $mobile_phone);
        if (substr($mobile_phone, 0, 2) === '08') {
            return '+62' . substr($mobile_phone, 1);
        }
        if (substr($mobile_phone, 0, 3) === '+62') {
            return $mobile_phone;
        }
        if (substr($mobile_phone, 0, 2) === '62') {
            return '+' . $mobile_phone;
        }
        return $mobile_phone;
    }

    function convert_mobilephone_format_08($mobile_phone)
    {
        $mobile_phone = preg_replace('/[\s\-.]/', '', $mobile_phone);
        if (substr($mobile_phone, 0, 3) === '+62') {
            return '08' . substr($mobile_phone, 1);
        }
        if (substr($mobile_phone, 0, 2) === '08') {
            return $mobile_phone;
        }
        if (substr($mobile_phone, 0, 2) === '62') {
            return '08' . substr($mobile_phone, 1);
        }
        return $mobile_phone;
    }
}
