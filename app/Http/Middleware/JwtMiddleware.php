<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Mencoba memvalidasi token
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // Token tidak valid
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token is invalid',
                    'error' => 'Invalid token',
                    'status' => 401,
                ], 401);
            }
            // Token telah kedaluwarsa
            elseif ($e instanceof TokenExpiredException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token has expired',
                    'error' => 'Expired token',
                    'status' => 401,
                ], 401);
            }
            // Token tidak diberikan
            elseif ($e instanceof JWTException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not provided',
                    'error' => 'Token missing',
                    'status' => 401,
                ], 401);
            }
            // Token masuk daftar hitam
            elseif ($e instanceof TokenBlacklistedException) {
                return response()->json([
                    'success' => false,
                    'message' => 'The token has been blacklisted',
                    'error' => 'Blacklisted token',
                    'status' => 401,
                ], 401);
            }
            // Kesalahan lain
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the token',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
        // Jika token valid, lanjutkan ke request berikutnya
        return $next($request);
    }
}
