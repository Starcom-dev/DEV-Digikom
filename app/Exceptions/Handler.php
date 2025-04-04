<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    // public function render($request, Throwable $exception)
    // {
    //     // Tangani TokenBlacklistedException
    //     if ($exception instanceof TokenBlacklistedException) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'The token has been blacklisted',
    //             'error' => 'Blacklisted token',
    //         ], 401);
    //     }

    //     // Tangani TokenInvalidException
    //     if ($exception instanceof TokenInvalidException) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Token is invalid',
    //             'error' => 'Invalid token',
    //         ], 401);
    //     }

    //     // Tangani TokenExpiredException
    //     if ($exception instanceof TokenExpiredException) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Token has expired',
    //             'error' => 'Expired token',
    //         ], 401);
    //     }

    //     // Tangani JWTException
    //     if ($exception instanceof JWTException) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Token not provided',
    //             'error' => 'Token missing',
    //         ], 401);
    //     }

    //     // Tangani UnauthorizedHttpException
    //     if ($exception instanceof UnauthorizedHttpException) {
    //         $previousException = $exception->getPrevious();

    //         if ($previousException instanceof TokenBlacklistedException) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'The token has been blacklisted',
    //                 'error' => 'Blacklisted token',
    //             ], 401);
    //         }

    //         if ($previousException instanceof TokenInvalidException) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Token is invalid',
    //                 'error' => 'Invalid token',
    //             ], 401);
    //         }

    //         if ($previousException instanceof TokenExpiredException) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Token has expired',
    //                 'error' => 'Expired token',
    //             ], 401);
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unauthorized',
    //             'error' => 'Unauthorized access',
    //         ], 401);
    //     }

    //     return parent::render($request, $exception);
    // }
    public function render($request, Throwable $exception)
{
    if ($exception instanceof UnauthorizedHttpException) {
        $previousException = $exception->getPrevious();

        if ($previousException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
            return response()->json([
                'success' => false,
                'message' => 'The token has been blacklisted',
                'error' => 'Blacklisted token',
            ], 401);
        }

        if ($previousException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid',
                'error' => 'Invalid token',
            ], 401);
        }

        if ($previousException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired',
                'error' => 'Expired token',
            ], 401);
        }

        // Default handling for UnauthorizedHttpException
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized',
            'error' => 'Unauthorized access',
        ], 401);
    }

    return parent::render($request, $exception);
}

}
