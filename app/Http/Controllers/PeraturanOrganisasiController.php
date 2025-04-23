<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//import model product
use App\Models\PeraturanOrganisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//import return type View
use Illuminate\View\View;

class PeraturanOrganisasiController  extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'judul'); // Default sort by 'judul'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $peraturan_organisasi = PeraturanOrganisasi::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%{$search}%");
        })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);

        return view('pages.AD_ART.peraturan_organisasi.index', compact('peraturan_organisasi', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        $peraturan_organisasi = PeraturanOrganisasi::with('creator')->findOrFail($id); // Ambil peraturan_organisasi berdasarkan ID
        return view('pages.AD_ART.peraturan_organisasi.show', compact('peraturan_organisasi'));
    }

    // Menampilkan form untuk membuat peraturan_organisasi baru
    public function create()
    {
        return view('pages.AD_ART.peraturan_organisasi.create');
    }

    // Menyimpan peraturan_organisasi baru
    public function store(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'judul' => 'required|unique:peraturan_organisasis,judul',
        //     'deskripsi' => 'required',
        // ]);

        // Menyimpan data peraturan_organisasi ke database
        $peraturan_organisasi = new PeraturanOrganisasi;
        // $peraturan_organisasi->judul = $request->judul;
        // $peraturan_organisasi->deskripsi = $request->deskripsi;
        $peraturan_organisasi->text_editor = $request->peraturan;
        $peraturan_organisasi->created_by = Auth::guard('admin')->user()->id;
        $peraturan_organisasi->save();
        // Redirect setelah berhasil menyimpan
        return redirect()->route('peraturan-organisasi.index')->with('success', 'Anggaran Dasar berhasil dibuat!');
    }

    public function edit($id)
    {
        $peraturan_organisasi = PeraturanOrganisasi::findOrFail($id); // Ambil peraturan_organisasi berdasarkan ID
        return view('pages.AD_ART.peraturan_organisasi.edit', compact('peraturan_organisasi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        // Cari peraturan_organisasi berdasarkan ID
        $peraturan_organisasi = PeraturanOrganisasi::findOrFail($id);

        // Update data peraturan_organisasi
        $peraturan_organisasi->judul = $request->judul;
        $peraturan_organisasi->deskripsi = $request->deskripsi;

        $peraturan_organisasi->created_by = 1;
        $peraturan_organisasi->save();

        return redirect()->route('peraturan-organisasi.index')->with('success', 'Anggaran Dasar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $peraturan_organisasi = PeraturanOrganisasi::findOrFail($id); // Ambil peraturan_organisasi berdasarkan ID

        $peraturan_organisasi->delete(); // Hapus data peraturan_organisasi

        return redirect()->route('peraturan-organisasi.index')->with('success', 'peraturan_organisasi berhasil dihapus!');
    }
}
