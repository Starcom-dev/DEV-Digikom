<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//import model product
use App\Models\Jabatan; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//import return type View
use Illuminate\View\View;

class JabatanController extends Controller
{
    public function index(Request $request) : View
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'nama_jabatan'); // Default sort by 'nama_jabatan'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $jabatan = Jabatan::when($search, function ($query, $search) {
                return $query->where('nama_jabatan', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return view('pages.jabatan.index', compact('jabatan', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        // $jabatan = Jabatan::with('creator')->findOrFail($id); // Ambil jabatan berdasarkan ID
        $jabatan = Jabatan::findOrFail($id); // Ambil jabatan berdasarkan ID
        return view('pages.jabatan.show', compact('jabatan'));
    }

     // Menampilkan form untuk membuat jabatan baru
    public function create()
    {
        return view('pages.jabatan.create');
    }

     // Menyimpan jabatan baru
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan',
            'deskripsi' => 'required',
        ]);

         // Menyimpan data jabatan ke database
        $jabatan = new Jabatan;
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->deskripsi = $request->deskripsi;
        $jabatan->save();
         // Redirect setelah berhasil menyimpan
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dibuat!');
    }


    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id); // Ambil jabatan berdasarkan ID
        return view('pages.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nama_jabatan' => 'required',
        'deskripsi' => 'required',
    ]);

    // Cari jabatan berdasarkan ID
    $jabatan = Jabatan::findOrFail($id);

    // Update data jabatan
    $jabatan->nama_jabatan = $request->nama_jabatan;
    $jabatan->deskripsi = $request->deskripsi;
    $jabatan->save();

    return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui!');
}

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id); // Ambil jabatan berdasarkan ID

        $jabatan->delete(); // Hapus data jabatan

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus!');
    }
}
