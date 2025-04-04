<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\IuranResource;
use App\Models\Iuran;
use Tymon\JWTAuth\Facades\JWTAuth;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Authenticate the user and get their information
            $user = JWTAuth::parseToken()->authenticate();
    
            // Ambil tahun saat ini
            $currentYear = now()->year;
    
            // Ambil parameter tahun dari query string jika ada
            $yearFilter = $request->query('tahun', $currentYear); // Default ke tahun sekarang jika tidak ada parameter tahun
    
            // Retrieve tagihans for the authenticated user
            $tagihans = Tagihan::where('user_id', $user->id)
                ->whereHas('iuran', function ($query) use ($yearFilter) {
                    // Filter berdasarkan tahun yang diinginkan
                    $query->where('tahun', $yearFilter);
                })
                ->get();
    
            // Format the result
            $result = $tagihans->map(function ($tagihan) {
                // Access related iuran data through the relationship
                $iuran = $tagihan->iuran;  // This will fetch the related iuran record
        
                return [
                    'id' => $tagihan->id,
                    'iuran_id' => $tagihan->iuran_id,
                    'bulan' => $tagihan->keterangan,
                    'tahun' => $iuran ? $iuran->tahun : 'N/A',
                    'jumlah' => $tagihan->nominal,
                    'status' => $tagihan->status,
                    'status_payment' => $tagihan->payment_status,
                    'tanggal_bayar' => $tagihan->tanggal_bayar ?? 'Belum Dibayar',  // If no tanggal_bayar, show 'Belum Dibayar'
                    'nominal' => $tagihan->nominal ?? 0, // If no nominal, default to 0
                ];
            });
    
            // Return the response with the data
            return response()->json([
                'success' => true,
                'message' => 'List Data Tagihan',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function show($id)
    {
        try {
            // Fetch the Tagihan by id
            $tagihan = Tagihan::findOrFail($id);
    
            // Access related iuran data through the relationship
            $iuran = $tagihan->iuran;  // This will fetch the related iuran record
    
            // Format the result
            $result = [
                'id' => $tagihan->id,
                'iuran_id' => $tagihan->iuran_id,
                'bulan' => $iuran ? $iuran->bulan : 'N/A', // Check if iuran exists
                'jumlah' => $iuran ? $iuran->jumlah : 0,   // Check if iuran exists
                'status' => $tagihan->status,
                'status_pembayaran' => $tagihan->status_payment,
                'tanggal_bayar' => $tagihan->tanggal_bayar ?? 'Belum Dibayar',  // If no tanggal_bayar, show 'Belum Dibayar'
                'nominal' => $tagihan->nominal ?? 0, // If no nominal, default to 0
            ];
    
            // Return response
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Iuran',
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    public function store(Request $request)
    {
        try {
            // Ambil user yang sedang login
            $user = JWTAuth::parseToken()->authenticate();
    
            // Validasi input
            $request->validate([
                'tagihan_id' => 'required|exists:tagihans,id', // Pastikan tagihan_id ada di tabel tagihans
                'opsi_id' => 'required|exists:opsi_bayars,id', // Pastikan opsi_id ada di tabel opsi_bayars
                'jumlah' => 'required|numeric|min:0', // Pastikan jumlah valid
                'tanggal_pembayaran' => 'required|date', // Pastikan tanggal_pembayaran valid
                'status_pembayaran' => 'required|string|in:pending,paid,canceled', // Pastikan status_pembayaran valid
            ]);
    
            // Cek apakah tagihan ini sudah dibayar sebelumnya
            $existingPayment = Pembayaran::where('user_id', $user->id)
                ->where('tagihan_id', $request->tagihan_id)
                ->first();
    
            if ($existingPayment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran untuk tagihan ini sudah dilakukan.',
                ], 400);
            }
    
            // Buat pembayaran baru
            $payment = Pembayaran::create([
                'user_id' => $user->id,
                'tagihan_id' => $request->tagihan_id,
                'opsi_id' => $request->opsi_id,
                'jumlah' => $request->jumlah,   
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'status_pembayaran' => $request->status_pembayaran, // Misalnya 'paid'
                'created_at' => now(),
            ]);
    
            // Update status tagihan menjadi 'Lunas' jika sudah dibayar
            $tagihan = Tagihan::find($request->tagihan_id);
            if ($payment->status_pembayaran === 'Belum Lunas') {
                $tagihan->status = 'Lunas';
                $tagihan->tanggal_bayar = $request->tanggal_pembayaran;
                $tagihan->save();
            }
    
            // Return response sukses
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diproses',
                'data' => $payment,
            ], 201);
    
        } catch (\Exception $e) {
            // Tangkap dan return error
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

}
