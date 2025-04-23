<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UsahaAnggotaResource;
use App\Models\Usaha;
use Illuminate\Support\Facades\Log;

class UsahaAnggotaController extends Controller
{
    public function index()
    {
        //get all posts
        // $usahas = Usaha::latest()->paginate(5);
        $usahas = Usaha::with(['creator', 'bidangUsaha', 'categoryUsaha'])->latest()->get();
        //return collection of posts as a resource
        return new UsahaAnggotaResource(true, 'List Data Usaha', $usahas);
    }

    public function show($id)
    {
        // Mencari usaha berdasarkan ID
        $usaha = Usaha::with('creator')->find($id);

        // Jika usaha tidak ditemukan, return response error
        if (!$usaha) {
            return response()->json([
                'success' => false,
                'message' => 'Usaha tidak ditemukan',
            ], 404);
        }

        // Return data usaha
        return new UsahaAnggotaResource(true, 'Detail Data Usaha', $usaha);
    }

    public function myUsaha(Request $request)
    {
        try {
            // Ambil pengguna yang sedang login
            $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();

            // Ambil semua usaha milik pengguna yang sedang login
            $usahas = Usaha::with('creator')
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            // Periksa jika tidak ada usaha ditemukan
            if ($usahas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada usaha yang ditemukan untuk pengguna ini.',
                ], 404);
            }

            // Return data usaha
            return new UsahaAnggotaResource(true, 'List Usaha Anda', $usahas);
        } catch (\Exception $e) {
            // Tangkap dan return error
            Log::error('Error fetching user usaha:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usaha',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
