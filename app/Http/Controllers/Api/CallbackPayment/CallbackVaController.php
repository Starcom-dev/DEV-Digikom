<?php

namespace App\Http\Controllers\Api\CallbackPayment;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CallbackVaController extends Controller
{
    public function handle(Request $request)
    {
        // Simpan log callback untuk debug awal
        Log::channel('single')->info('Xendit Callback VA:' . json_encode($request->all()));

        $token = $request->header('x-callback-token');
        $callBackToken = env('XENDIT_CALLBACK_TOKEN');
        try {
            DB::beginTransaction();
            if (!$token) {
                return response()->json(['message' => 'Token callback not found'], 404);
            }
            if ($token !== $callBackToken) {
                return response()->json(['message' => 'Token callback invalid'], 401);
            }
            $payload = json_decode(json_encode($request->all()));
            // $status = $payload->data->status ?? null;
            $external_id = $payload->external_id ?? null;

            if (isset($payload->amount)) {
                $transaction = DB::table('transactions')->where('id_transaction', $external_id)->first();
                if ($transaction) {
                    // update status transasction pada table transactions
                    DB::table('transactions')->where([
                        'id_transaction' => $transaction->id_transaction,
                        'tagihan_id' => $transaction->tagihan_id
                    ])->update(['status_transaction' => 'success']);
                    // get data tagihan
                    $tagihan = DB::table('tagihans')->where(['id' => $transaction->tagihan_id])->first();
                    // update status, tgl bayar dan payment_status pada table tagihans
                    DB::table('tagihans')->where([
                        'id' => $transaction->tagihan_id
                    ])->update([
                        'tanggal_bayar' => now(),
                        'status' => 'Lunas',
                        'payment_status' => 'SUCCEEDED',
                        'updated_at' => now()
                    ]);
                    // get detail iuran membership
                    $iuran = DB::table('iurans')->where([
                        'id' => $tagihan->iuran_id,
                    ])->first();
                    // update status membership user
                    $typeMembership = $iuran->masa_aktif;
                    $membershipStart = Carbon::now();
                    $membershipEnd = Carbon::now()->addMonths($typeMembership);
                    DB::table('users')->where([
                        'id' => $transaction->user_id
                    ])->update([
                        'is_membership' => 'true',
                        'membership_start' => $membershipStart,
                        'membership_end' => $membershipEnd
                    ]);
                    DB::commit();
                    Log::channel('single')->info('Update status transaction berhasil');
                } else {
                    DB::rollBack();
                    Log::warning("Transaksi dengan ID $external_id tidak ditemukan.");
                }
                DB::commit();
                return response('', 200);
            }
        } catch (\Throwable $th) {
            Log::channel('single')->error('Xendit Error Callback Va ' . $th);
            DB::rollBack();
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $th
            ], 500);
        }
    }
}
