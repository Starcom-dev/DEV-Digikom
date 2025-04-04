<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionController extends Controller
{
    /**
     * Get All Transactions for the Authenticated User
     */
    public function index(Request $request)
{
    // Ambil user yang sedang login
    $user = JWTAuth::user();

    // Ambil semua transaksi milik user, sertakan detail tagihan
    $transactions = Transaction::with('tagihan')
        ->where('user_id', $user->id)
        ->get();



    // Format data untuk setiap transaksi
    $data = $transactions->map(function ($transaction) {
        $tagihan = $transaction->tagihan;
        $metode_pembayaran = $tagihan->metode_pembayaran;
    
        // Query the opsi_bayar table to get the payment method and set a default if not found
        $opsi_bayar = \DB::table('opsi_bayars')
            ->where('kode', $metode_pembayaran)
            ->value('opsi_bayar') ?? 'Unknown';
    
        // Query the opsi_bayar table again to get the admin fee (biaya_tetap)
        $adminFee = \DB::table('opsi_bayars')
            ->where('kode', $metode_pembayaran)  // Use metode_pembayaran to fetch the admin fee
            ->value('biaya_tetap') ?? 0;  // Default to 0 if no admin fee is found
    
        return [
            'id' => $transaction->id,
            'id_transaction' => $transaction->id_transaction,
            'status_transaction' => $transaction->status_transaction,
            'created_at' => $transaction->created_at,
            'tagihan' => [
                'bulan' => $tagihan->keterangan,
                'tahun' => $tagihan->iuran->tahun,
                'status' => $tagihan->status,
                'metode_pembayaran' => $opsi_bayar,
                'nominal' => $tagihan->iuran->jumlah,
                'admin' => $adminFee,
                'total' => $tagihan->iuran->jumlah + $adminFee,
                ],
        ];
    });
    
    
    

    // Kembalikan respons daftar transaksi
    return response()->json([
        'success' => true,
        'message' => 'Daftar Transaksi',
        'data' => $data,
    ]);
}


    /**
     * Get Transaction Details
     */
    public function show($id)
    {
        // Ambil user yang sedang login
        $user = JWTAuth::user();

        // Cari transaksi berdasarkan ID dan pastikan milik user yang sedang login
        $transaction = Transaction::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        // Jika transaksi tidak ditemukan, kembalikan error
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }
        $tagihan = $transaction->tagihan;
        $metode_pembayaran = $tagihan->metode_pembayaran;
        $opsi_bayar = \DB::table('opsi_bayars')
        ->where('kode', $metode_pembayaran)
        ->value('opsi_bayar') ?? 'Unknown';
        $adminFee = \DB::table('opsi_bayars')
        ->where('kode', $metode_pembayaran)  // Use metode_pembayaran to fetch the admin fee
        ->value('biaya_tetap') ?? 0;  // Default to 0 if no admin fee is found
        
        $data = [
            'id' => $transaction->id,
            'id_transaction' => $transaction->id_transaction,
            'status_transaction' => $transaction->status_transaction,
            'created_at' => $transaction->created_at,
            'tagihan' => [
                'bulan' => $tagihan->keterangan ?? 'Tidak ada keterangan',
                'tahun' => $tagihan->iuran->tahun ?? 'Tidak ada tahun',
                'status' => $tagihan->status ?? 'Tidak ada status',
                'metode_pembayaran' => $opsi_bayar ?? 'Tidak ada metode pembayaran',
                'nominal' => $tagihan->iuran->jumlah,
                'admin' => $adminFee,
                'total' => $tagihan->iuran->jumlah + $adminFee,
            ],
        ];
    
        // Kembalikan detail transaksi dalam bentuk JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Transaksi',
            'data' => $data,
        ]);
    }
}
