<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OpsiBayarResource;
use App\Models\OpsiBayar;

class OpsiBayarController extends Controller
{
    public function index()
    {
        // Get all payment options, eager load related category
        $opsis = OpsiBayar::with('kategori')->latest()->get();

        // Return collection of payment options as a resource
        return new OpsiBayarResource(true, 'List Data Opsi Bayar', $opsis);
    }

    public function show($id)
    {
        // Find the payment option by ID and eager load the category
        $opsi = OpsiBayar::with('kategori')->find($id);

        // If payment option not found, return error response
        if (!$opsi) {
            return response()->json([
                'success' => false,
                'message' => 'Opsi Bayar tidak ditemukan',
            ], 404);
        }

        // Return single payment option as a resource
        return new OpsiBayarResource(true, 'Detail Data Opsi Bayar', $opsi);
    }
}
