<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Middleware untuk mengecek apakah user sudah menjadi member.
 * Jika tidak, periksa apakah ada tagihan belum lunas, dan kembalikan response sesuai.
 */
class CheckMembership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->is_membership !== 'true') {
            return response()->json([
                'success' => false,
                'is_checkout' => false,
                'message' => 'Anda bukan member, tidak dapat mengakses konten ini'
            ], 403);
        }
        return $next($request);
    }
}
