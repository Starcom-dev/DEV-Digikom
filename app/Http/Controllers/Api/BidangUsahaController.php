<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BidangUsahaResource;
use App\Models\BidangUsaha;
use Illuminate\Http\Request;

class BidangUsahaController extends Controller
{
    public function index()
    {
        $bidangUsaha = BidangUsaha::orderBy('nama', 'ASC')->get();
        return new BidangUsahaResource(true, 'List Data Bidang Usaha', $bidangUsaha);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required'
            ]);
            BidangUsaha::create(['nama' => $request->nama]);
            return response()->json([
                'success' => true,
                'message' => 'Bidang Usaha berhasil di tambahkan'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalah create Bidang Usaha',
                'error' => $th
            ], 500);
        }
    }
}
