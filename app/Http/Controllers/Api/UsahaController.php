<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsahaAnggotaResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Usaha;
use Illuminate\Support\Facades\Log;

class UsahaController extends Controller
{
    public function index()
    {
        //get all posts
        $usahas = Usaha::with('creator')->latest()->get();
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

    public function store(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Validasi input
            $request->validate([
                'nama_usaha' => 'required|string|unique:usahas,nama_usaha',
                'waktu_operational' => 'required|max:255',
                'lokasi_usaha' => 'required|max:255',
                'nomor_usaha' => 'nullable|integer',
                'deskripsi' => 'required|string',
                'image_usaha' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'category' => 'required',
                'bidang' => 'required',
            ]);

            // Proses penyimpanan file
            $image_usaha = $request->file('image_usaha')->store('image_usaha', 'public');
            // Siapkan data
            $data = $request->only([
                'nama_usaha',
                'waktu_operational',
                'lokasi_usaha',
                'nomor_usaha',
                'deskripsi',
                'category',
                'bidang'
            ]);
            $data['user_id'] = $user->id;
            $data['image_usaha'] = $image_usaha;

            // Buat usaha baru
            $usaha = Usaha::create($data);

            return new UsahaAnggotaResource(true, 'Usaha created successfully', $usaha);
        } catch (\Exception $e) {
            Log::channel('single')->info('Error API create usaha : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create usaha',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Ambil pengguna yang terautentikasi dari token
            $user = JWTAuth::parseToken()->authenticate();

            // Validasi input
            $request->validate([
                'nama_usaha' => 'nullable|string|max:255',
                'waktu_operational' => 'nullable|max:255',
                'lokasi_usaha' => 'nullable|max:255',
                'nomor_usaha' => 'nullable|integer',
                'deskripsi' => 'nullable|string',
                'image_usaha' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Cari data usaha berdasarkan ID dan pastikan usaha milik pengguna yang login
            $usaha = Usaha::where('id', $id)->where('user_id', $user->id)->first();

            if (!$usaha) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usaha tidak ditemukan atau Anda tidak memiliki akses',
                ], 404);
            }

            // Proses penyimpanan file baru jika ada
            if ($request->hasFile('image_usaha')) {
                $image_usaha = $request->file('image_usaha')->store('image_usaha', 'public');
                $usaha->image_usaha = $image_usaha; // Update image_usaha
            }

            // Perbarui data usaha
            $usaha->update($request->only([
                'nama_usaha',
                'waktu_operational',
                'lokasi_usaha',
                'nomor_usaha',
                'deskripsi',
            ]));

            // Return data usaha yang telah diperbarui
            return new UsahaAnggotaResource(true, 'Usaha berhasil diperbarui', $usaha);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update usaha',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            // Ambil pengguna yang terautentikasi dari token
            $user = JWTAuth::parseToken()->authenticate();

            // Cari data usaha berdasarkan ID dan pastikan usaha milik pengguna yang login
            $usaha = Usaha::where('id', $id)->where('user_id', $user->id)->first();

            if (!$usaha) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usaha tidak ditemukan atau Anda tidak memiliki akses',
                ], 404);
            }

            // Hapus data usaha
            $usaha->delete();

            // Return respon sukses
            return response()->json([
                'success' => true,
                'message' => 'Usaha berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            // Tangkap dan kembalikan error
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete usaha',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
