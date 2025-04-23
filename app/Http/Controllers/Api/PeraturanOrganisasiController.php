<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PeraturanOrganisasiResource;
use App\Models\PeraturanOrganisasi;

class PeraturanOrganisasiController extends Controller
{
    public function index()
    {
        //get all posts
        // $peraturans = PeraturanOrganisasi::latest()->paginate(5);
        $peraturans = PeraturanOrganisasi::with('creator')->first();
        //return collection of posts as a resource
        // return new PeraturanOrganisasiResource(true, 'List Data PeraturanOrganisasi', $peraturans);
        return response()->json([
            'success' => true,
            'message' => 'Peraturan organisasi',
            'data' => $peraturans->text_editor
        ]);
    }

    public function show($id)
    {
        // Mencari peraturan berdasarkan ID
        $peraturan = PeraturanOrganisasi::with('creator')->find($id);

        // Jika peraturan tidak ditemukan, return response error
        if (!$peraturan) {
            return response()->json([
                'success' => false,
                'message' => 'PeraturanOrganisasi tidak ditemukan',
            ], 404);
        }

        // Return data peraturan
        // return new PeraturanOrganisasiResource(true, 'Detail Data PeraturanOrganisasi', $peraturan);
        return response()->json([
            'success' => true,
            'message' => 'Peraturan organisasi',
            'data' => $peraturan->text_editor
        ]);
    }
}
