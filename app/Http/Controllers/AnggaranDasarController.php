<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//import model product
use App\Models\AnggaranDasar; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//import return type View
use Illuminate\View\View;

class AnggaranDasarController extends Controller
{
    public function index(Request $request) : View
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'judul_utama'); // Default sort by 'judul_utama'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $anggaran_dasar = AnggaranDasar::when($search, function ($query, $search) {
                return $query->where('judul_utama', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return view('pages.AD_ART.anggaran_dasar.index', compact('anggaran_dasar', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        $anggaran_dasar = AnggaranDasar::with('creator')->findOrFail($id); // Ambil anggaran_dasar berdasarkan ID
        return view('pages.AD_ART.anggaran_dasar.show', compact('anggaran_dasar'));
    }

     // Menampilkan form untuk membuat anggaran_dasar baru
    public function create()
    {
        return view('pages.AD_ART.anggaran_dasar.create');
    }

     // Menyimpan anggaran_dasar baru
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'judul_utama' => 'required|unique:anggaran_dasars,judul_utama',
            'sub_judul' => 'required',
            'deskripsi' => 'required',
        ]);

         // Menyimpan data anggaran_dasar ke database
        $anggaran_dasar = new AnggaranDasar;
        $anggaran_dasar->judul_utama = $request->judul_utama;
        $anggaran_dasar->sub_judul = $request->sub_judul;
        $anggaran_dasar->deskripsi = $request->deskripsi;
        $anggaran_dasar->created_by = Auth::guard('admin')->user()->id; 
        $anggaran_dasar->save();
         // Redirect setelah berhasil menyimpan
        return redirect()->route('anggaran-dasar.index')->with('success', 'Anggaran Dasar berhasil dibuat!');
    }


    public function edit($id)
    {
        $anggaran_dasar = AnggaranDasar::findOrFail($id); // Ambil anggaran_dasar berdasarkan ID
        return view('pages.AD_ART.anggaran_dasar.edit', compact('anggaran_dasar'));
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'judul_utama' => 'required',
        'sub_judul' => 'required',
        'deskripsi' => 'required',
    ]);

    // Cari anggaran_dasar berdasarkan ID
    $anggaran_dasar = AnggaranDasar::findOrFail($id);

    // Update data anggaran_dasar
    $anggaran_dasar->judul_utama = $request->judul_utama;
    $anggaran_dasar->sub_judul = $request->sub_judul;
    $anggaran_dasar->deskripsi = $request->deskripsi;

    $anggaran_dasar->created_by = Auth::guard('admin')->user()->id; 
    $anggaran_dasar->save();

    return redirect()->route('anggaran-dasar.index')->with('success', 'Anggaran Dasar berhasil diperbarui!');
}

    public function destroy($id)
    {
        $anggaran_dasar = AnggaranDasar::findOrFail($id); // Ambil anggaran_dasar berdasarkan ID

        // Hapus banner dari storage jika ada
        if ($anggaran_dasar->banner) {
            Storage::delete('public/anggaran_dasar/' . $anggaran_dasar->banner);
        }

        $anggaran_dasar->delete(); // Hapus data anggaran_dasar

        return redirect()->route('anggaran-dasar.index')->with('success', 'anggaran_dasar berhasil dihapus!');
    }

}
