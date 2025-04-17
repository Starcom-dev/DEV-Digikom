<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IuranResource;
use App\Models\Iuran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class IuranController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $getHistoryTagihan = Tagihan::with(['iuran', 'transactions', 'opsiBayar'])->where(['user_id' => $user->id, 'status' => 'Belum Lunas'])->orderBy('created_at', 'DESC')->first();
        Log::channel('single')->info('Get History Tagihan' . $getHistoryTagihan);
        if ($getHistoryTagihan) {
            $nominal = $getHistoryTagihan->iuran->nominal;
            $adminFee = $getHistoryTagihan->opsiBayar->biaya_tetap;
            return response()->json([
                'success' => true,
                'message' => 'Transaksi telah dibuat, silahkan melakukan pembayaran.',
                'nominal' => $nominal,
                'admin' => $adminFee,
                'total' => $nominal + $adminFee,
                'id_transaksi' => $getHistoryTagihan->transactions->id_transaction,
                'data' => [
                    'id' => '',
                    'status' => $getHistoryTagihan->status,
                    'channel_code' => $getHistoryTagihan->opsiBayar->opsi_bayar,
                    'kode_bayar' => $getHistoryTagihan->kode_bayar, // Ambil account_number dari response Xendit
                ],
            ], 403);
        } else {
            //get all posts
            $iurans = Iuran::orderBy('harga', 'ASC')->get();
            //return collection of posts as a resource
            return new IuranResource(true, 'List Data Subscription', $iurans);
        }
    }

    public function show($id)
    {
        // Mencari iuran berdasarkan ID
        $iuran = Iuran::with('creator')->find($id);

        // Jika iuran tidak ditemukan, return response error
        if (!$iuran) {
            return response()->json([
                'success' => false,
                'message' => 'Iuran tidak ditemukan',
            ], 404);
        }

        // Return data iuran
        return new IuranResource(true, 'Detail Data Iuran', $iuran);
    }
}
