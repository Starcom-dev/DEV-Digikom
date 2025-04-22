<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validasi input
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
                // 'phone_number' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,phone_number',
                //'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                //'nomor_ktp' => 'nullable|integer|unique:users,nomor_ktp',
                //'tanggal_lahir' => 'nullable|date',
                //'tempat_lahir' => 'nullable|string|max:100',
                //'alamat' => 'nullable|string|max:255',
                //'pekerjaan_id' => 'nullable|integer',
                //'jabatan_id' => 'nullable|integer',
                //'agama_id' => 'nullable|integer',
                //'pendidikan_id' => 'nullable|integer',
            ]);

            // Proses penyimpanan file
            //$profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Proses penyimpanan data user
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // 'phone_number' => $request->phone_number,
                'status' => 2
                //'profile_picture' => $profilePicturePath,
                //'nomor_ktp' => $request->nomor_ktp,
                //'tanggal_lahir' => $request->tanggal_lahir,
                //'tempat_lahir' => $request->tempat_lahir,
                //'alamat' => $request->alamat,
                //'pekerjaan_id' => $request->pekerjaan_id,
                //'agama_id' => $request->agama_id,
                //'pendidikan_id' => $request->pendidikan_id,
            ]);

            // Tambahkan data ke tabel Penguruses
            // Penguruses::create([
            //     'jabatan_pengurus' => 4, // Ubah sesuai dengan kebutuhan
            //     'nama_pengurus' => $user->id
            // ]);

            return response()->json(new UserResource(true, 'User Registered Successfully', $user), 201);
        } catch (\Exception $e) {
            Log::channel('single')->info('Error register' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to register user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Cari user berdasarkan ID
            $user = User::findOrFail($id);

            // Hapus user
            $user->delete();

            // Berikan respon sukses
            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully',
            ], 200);
        } catch (\Exception $e) {
            // Tangkap dan berikan respon error
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
