<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;
use Log;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan Anda memiliki view ini
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // Attempt to login via guard admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Arahkan ke dashboard
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Arahkan ke halaman login
    }

    public function resetPassword($token)
    {
        $email = Crypt::decrypt($token);
        $emailExist = User::where('email', $email)->firstOrFail();
        if (!$emailExist) {
            // Log::channel('single')->info('Email user tidak ditemukan', $email);
            abort(404, 'Email user tidak ditemukan');
        }
        return view('auth/resetPassword', compact('email'));
    }

    public function saveResetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required',
            ]);
            $email = $request->email;
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($request->new_password);
            $user->update();
            return redirect('/auth/reset-password-success')->with('success', 'Update Password Berhasil');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstErrorMessage = collect($e->errors())->first()[0];
            return response()->json([
                'success' => false,
                'message' => $firstErrorMessage,
            ], 422);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function successResetPassword()
    {
        return view('auth/successRessetPassword');
    }
}
