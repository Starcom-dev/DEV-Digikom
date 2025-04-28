<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;
use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function sendEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $emailExist = User::where('email', $request->email)->first();
            if (!$emailExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email Not Found'
                ], 404);
            }

            $data = [
                'subject' => 'Reset Password Akun Anda',
                'title' => 'Reset Password',
                'link' =>  config('app.url') . 'auth/reset-password',
                'token' => Crypt::encrypt($request->email)
            ];

            Mail::to($request->email)->send(new SendEmail($data));
            return response()->json([
                'success' => true,
                'message' => 'Email berhasil dikirim'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('single')->error('Error validasi update profile', $e->errors());
            $firstErrorMessage = collect($e->errors())->first()[0];
            return response()->json([
                'success' => false,
                'message' => $firstErrorMessage,
            ], 422);
        } catch (\Exception $e) {
            Log::channel('single')->info('Email gagal dikirim : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Email gagal dikirim',
                'error' => $e->getMessage()
            ]);
        }
    }
}
