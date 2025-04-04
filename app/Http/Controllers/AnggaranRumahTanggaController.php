<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

//import model product
use App\Models\AnggaranRumahTangga; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

//import return type View
use Illuminate\View\View;

class AnggaranRumahTanggaController extends Controller
{
    public function index(Request $request) : View
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'judul_utama'); // Default sort by 'judul_utama'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $anggaran_rumah_tangga = AnggaranRumahTangga::when($search, function ($query, $search) {
                return $query->where('judul_utama', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return view('pages.AD_ART.anggaran_rumah_tangga.index', compact('anggaran_rumah_tangga', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        $anggaran_rumah_tangga = AnggaranRumahTangga::with('creator')->findOrFail($id); // Ambil anggaran_rumah_tangga berdasarkan ID
        return view('pages.AD_ART.anggaran_rumah_tangga.show', compact('anggaran_rumah_tangga'));
    }

     // Menampilkan form untuk membuat anggaran_rumah_tangga baru
    public function create()
    {
        return view('pages.AD_ART.anggaran_rumah_tangga.create');
    }

     // Menyimpan anggaran_rumah_tangga baru
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'judul_utama' => 'required|unique:anggaran_rumah_tanggas,judul_utama',
            'sub_judul' => 'required',
            'deskripsi' => 'required',
        ]);

         // Menyimpan data anggaran_rumah_tangga ke database
        $anggaran_rumah_tangga = new AnggaranRumahTangga;
        $anggaran_rumah_tangga->judul_utama = $request->judul_utama;
        $anggaran_rumah_tangga->sub_judul = $request->sub_judul;
        $anggaran_rumah_tangga->deskripsi = $request->deskripsi;
        $anggaran_rumah_tangga->created_by = Auth::guard('admin')->user()->id; 
        $anggaran_rumah_tangga->save();
         // Redirect setelah berhasil menyimpan
        return redirect()->route('anggaran-rumah-tangga.index')->with('success', 'Anggaran Dasar berhasil dibuat!');
    }


    public function edit($id)
    {
        $anggaran_rumah_tangga = AnggaranRumahTangga::findOrFail($id); // Ambil anggaran_rumah_tangga berdasarkan ID
        return view('pages.AD_ART.anggaran_rumah_tangga.edit', compact('anggaran_rumah_tangga'));
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'judul_utama' => 'required',
        'sub_judul' => 'required',
        'deskripsi' => 'required',
    ]);

    // Cari anggaran_rumah_tangga berdasarkan ID
    $anggaran_rumah_tangga = AnggaranRumahTangga::findOrFail($id);

    // Update data anggaran_rumah_tangga
    $anggaran_rumah_tangga->judul_utama = $request->judul_utama;
    $anggaran_rumah_tangga->sub_judul = $request->sub_judul;
    $anggaran_rumah_tangga->deskripsi = $request->deskripsi;

    $anggaran_rumah_tangga->created_by = Auth::guard('admin')->user()->id; 
    $anggaran_rumah_tangga->save();

    return redirect()->route('anggaran-rumah-tangga.index')->with('success', 'Anggaran Dasar berhasil diperbarui!');
}

    public function destroy($id)
    {
        $anggaran_rumah_tangga = AnggaranRumahTangga::findOrFail($id); // Ambil anggaran_rumah_tangga berdasarkan ID

        // Hapus banner dari storage jika ada
        if ($anggaran_rumah_tangga->banner) {
            Storage::delete('public/anggaran_rumah_tangga/' . $anggaran_rumah_tangga->banner);
        }

        $anggaran_rumah_tangga->delete(); // Hapus data anggaran_rumah_tangga

        return redirect()->route('anggaran-rumah-tangga.index')->with('success', 'anggaran_rumah_tangga berhasil dihapus!');
    }
}
