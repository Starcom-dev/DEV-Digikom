<?php

namespace App\Http\Middleware;

use App\Models\Tagihan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Middleware untuk mengecek apakah user sudah menjadi member.
 * Jika tidak, periksa apakah ada tagihan belum lunas, dan kembalikan response sesuai.
 */
class CheckMembership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->is_membership !== 'true') {
            $getHistoryTagihan = Tagihan::with(['iuran', 'transactions', 'opsiBayar'])->where(['user_id' => $user->id, 'status' => 'Belum Lunas'])->orderBy('created_at', 'DESC')->first();
            Log::channel('single')->info('Get History Tagihan', $getHistoryTagihan->toArray());
            if ($getHistoryTagihan) {
                return response()->json([
                    'success' => false,
                    'is_checkout' => true,
                    'message' => 'Anda sudah melakukan transaksi, silahkan melakukan pembayaran',
                    'data' => [
                        'subscription' => [
                            'harga' => $getHistoryTagihan->iuran->harga,
                            'keterangan' => $getHistoryTagihan->iuran->keterangan,
                        ],
                        'detail_pembayaran' => [
                            'id_transaksi' => $getHistoryTagihan->transactions->id_transaction,
                            'metode_pembayaran' => $getHistoryTagihan->opsiBayar->opsi_bayar,
                            'kode_bayar' => $getHistoryTagihan->kode_bayar
                        ]
                    ]
                ], 403);
            }
            return response()->json([
                'success' => false,
                'is_checkout' => false,
                'message' => 'Anda bukan member, tidak dapat mengakses konten ini'
            ], 403);
        }
        return $next($request);
    }
}
