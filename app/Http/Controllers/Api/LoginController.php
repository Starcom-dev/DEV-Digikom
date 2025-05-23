<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'phone_number'    => 'required',
            'password' => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Kredensial login
        $credentials = $request->only('phone_number', 'password');

        // Jika autentikasi gagal
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'No HP atau password salah'
            ], 401);
        }

        // Ambil data user
        $user = auth()->user();

        if ($user->status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Akun anda sedang dalam mode suspend'
            ], 403);
        }

        // Tambahkan data user ke dalam token
        $customClaims = [
            'email'           => $user->email,
            'full_name'       => $user->full_name,
            'profile_picture' => $user->profile_picture,
            'phone_number'    => $user->phone_number,
            'jabatan'         => $user->creator->nama_jabatan ?? null,
        ];

        $token = JWTAuth::claims($customClaims)->attempt($credentials);

        // Jika autentikasi berhasil
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token
        ], 200);
    }
}
