<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function anggaranDasar()
    {
        $organisasi = Organisasi::first();
        return response()->json([
            'success' => true,
            'message' => 'Anggaran Dasar',
            'data' => $organisasi->anggaran_dasar
        ]);
    }

    public function anggaranRumahTangga()
    {
        $organisasi = Organisasi::first();
        return response()->json([
            'success' => true,
            'message' => 'Anggaran Rumah Tangga',
            'data' => $organisasi->anggaran_rumah_tangga
        ]);
    }

    public function tentangOrganisasi()
    {
        $organisasi = Organisasi::first();
        return response()->json([
            'success' => true,
            'message' => 'Tentang organisasi',
            'data' => $organisasi->tentang_organisasi
        ]);
    }

    public function peraturanOrganisasi()
    {
        $organisasi = Organisasi::first();
        return response()->json([
            'success' => true,
            'message' => 'Peraturan organisasi',
            'data' => $organisasi->peraturan_organisasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
