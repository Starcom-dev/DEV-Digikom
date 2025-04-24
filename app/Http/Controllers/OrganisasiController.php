<?php

namespace App\Http\Controllers;

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

    public function peraturanOrganisasi()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $peraturanOrganisasi = $organisasi->peraturan_organisasi ?? '';
        return view('pages.organisasi.peraturan_organisasi.index', compact('idOrganisasi', 'peraturanOrganisasi'));
    }

    public function createPeraturanOrganisasi()
    {
        $organisasi = Organisasi::first();
        $peraturanOrganisasi = $organisasi->peraturan_organisasi ?? '';
        return view('pages.organisasi.peraturan_organisasi.create', compact('peraturanOrganisasi'));
    }

    public function updatePeraturanOrganisasi(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->peraturan_organisasi = $request->peraturan;
        $organisasi->save();
        return redirect()->route('peraturan-organisasi')->with('success', 'Peraturan Organisasi berhasil diperbarui!');
    }

    public function tentangOrganisasi()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $tentangOrganisasi = $organisasi->tentang_organisasi ?? '';
        return view('pages.organisasi.tentang_organisasi.index', compact('idOrganisasi', 'tentangOrganisasi'));
    }

    public function createTentangOrganisasi()
    {
        $organisasi = Organisasi::first();
        $tentangOrganisasi = $organisasi->tentang_organisasi ?? '';
        return view('pages.organisasi.tentang_organisasi.create', compact('tentangOrganisasi'));
    }

    public function updateTentangOrganisasi(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->tentang_organisasi = $request->tentang;
        $organisasi->save();
        return redirect()->route('tentang-organisasi')->with('success', 'Tentang Organisasi berhasil diperbarui!');
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
