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

    public function tentangOrganisasi()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $tentangOrganisasi = $organisasi->tentang_organisasi ?? '';
        return view('pages.tentang_organisasi.index', compact('idOrganisasi', 'tentangOrganisasi'));
    }

    public function createTentangOrganisasi()
    {
        return view('pages.tentang_organisasi.create');
    }

    public function storeTentangOrganisasi(Request $request)
    {
        Organisasi::create(['tentang_organisasi' => $request->tentang]);
        return redirect()->route('tentang-organisasi')->with('success', 'Tentang Organisasi berhasil dibuat!');
    }

    public function editTentangOrganisasi($id)
    {
        $organisasi = Organisasi::find($id);
        return view('pages.tentang_organisasi.edit', compact('organisasi'));
    }

    public function updateTentangOrganisasi(Request $request)
    {
        $organisasi = Organisasi::find($request->id);
        $organisasi->tentang_organisasi = $request->tentang;
        $organisasi->update();
        return redirect()->route('tentang-organisasi')->with('success', 'Tentang Organisasi berhasil diubah!');
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
