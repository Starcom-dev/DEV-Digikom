<?php

namespace App\Http\Controllers\Api\CallbackPayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackEwalletController extends Controller
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

// Contoh validasi sederhana
// if ($request->has('status') && $request->status == 'PAID') {
// Update transaksi kamu di database
// Misalnya berdasarkan external_id atau invoice_id
// Contoh:
/*
    $transaction = Transaction::where('external_id', $request->external_id)->first();
    if ($transaction) {
        $transaction->status = 'paid';
        $transaction->save();
    }
    */
// }
// return response()->json(['message' => 'Callback received'], 200);