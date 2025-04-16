<?php

namespace App\Http\Controllers\Api\Pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PembayaranCreditCardController extends Controller
{
    public function pay(Request $request)
    {
        // Contoh input dari frontend
        $cardData = [
            'card_number'     => $request->card_number,
            'card_exp_month'  => $request->card_exp_month,
            'card_exp_year'   => $request->card_exp_year,
            'card_cvn'        => $request->card_cvn,
        ];

        $amount = $request->amount ?? 900000; // Amount harus >= 10000 (Rp. 100.000)
        $externalId = 'CC-' . uniqid();

        // 1. Tokenisasi
        $tokenResponse = Http::withBasicAuth(config('services.xendit.api_key'), '')
            ->post('https://api.xendit.co/credit_card_tokens', array_merge($cardData, [
                'is_multiple_use' => false
            ]));

        if (!$tokenResponse->successful()) {
            return response()->json(['error' => 'Tokenization failed', 'detail' => $tokenResponse->json()], 400);
        }

        $tokenId = $tokenResponse['id'];

        // 2. Authentication (3DS)
        $authResponse = Http::withBasicAuth(config('services.xendit.api_key'), '')
            ->post('https://api.xendit.co/credit_card_authentications', [
                'token_id' => $tokenId,
                'amount' => $amount
            ]);

        if (!$authResponse->successful()) {
            return response()->json(['error' => 'Authentication failed', 'detail' => $authResponse->json()], 400);
        }

        $authId = $authResponse['id'];

        // Jika perlu redirect ke 3DS page (biasanya test card tertentu)
        if (isset($authResponse['payer_authentication_url'])) {
            return response()->json([
                'redirect_url' => $authResponse['payer_authentication_url'],
                'message' => 'Redirect user to complete 3DS authentication'
            ]);
        }

        // 3. Charge
        $chargePayload = [
            'token_id'      => $tokenId,
            'authentication_id' => $authId,
            'external_id'   => $externalId,
            'amount'        => $amount,
            'currency'      => 'IDR',
            'descriptor'    => 'Your Store',
            'billing_details' => [
                'given_names'   => 'John',
                'surname'       => 'Doe',
                'email'         => 'johndoe@example.com',
                'mobile_number' => '+628123456789',
                'address'       => [
                    'street_line1'     => 'Jl. Mawar',
                    'street_line2'     => 'No. 1',
                    'city'             => 'Jakarta',
                    'province_state'   => 'DKI Jakarta',
                    'postal_code'      => '12345',
                    'country'          => 'ID',
                ],
            ],
            'metadata' => [
                'order_id' => $externalId,
            ],
        ];

        $chargeResponse = Http::withBasicAuth(config('services.xendit.api_key'), '')
            ->post('https://api.xendit.co/credit_card_charges', $chargePayload);

        if (!$chargeResponse->successful()) {
            return response()->json(['error' => 'Charge failed', 'detail' => $chargeResponse->json()], 400);
        }

        return response()->json([
            'message' => 'Payment successful',
            'data' => $chargeResponse->json()
        ]);
    }
}
