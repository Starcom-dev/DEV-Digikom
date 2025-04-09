<?php

namespace App\Http\Controllers\Api\CallbackPayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackQrisController extends Controller
{
    public function handle(Request $request)
    {
        // Simpan log callback untuk debug awal
        Log::info('Xendit Callback:', $request->all());

        $token = $request->header('x-callback-token');
        $callBackToken = env('XENDIT_CALLBACK_TOKEN');
        try {
            if (!$token) {
                return response()->json(['message' => 'Token callback not found'], 404);
            }
            if ($token !== $callBackToken) {
                return response()->json(['message' => 'Token callback invalid'], 401);
            }
            if ($request->has('status') && $request->status == 'PAID') {
            }
            return response()->json(['data' => $request]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $th
            ], 500);
        }
    }
}
