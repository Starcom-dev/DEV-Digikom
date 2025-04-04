<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//import model product
use App\Models\Usaha; 
use App\Models\User; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//import return type View
use Illuminate\View\View;

class UsahaController extends Controller
{
    public function index(Request $request) : View
    {
        // Ambil input untuk search dan sort
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'nama_usaha'); // Default sort by 'nama_usaha'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $usaha = Usaha::when($search, function ($query, $search) {
                return $query->where('nama_usaha', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return view('pages.usaha.index', compact('usaha', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        $usaha = Usaha::with('creator')->findOrFail($id); // Ambil usaha berdasarkan ID
        return view('pages.usaha.show', compact('usaha'));
    }

     // Menampilkan form untuk membuat usaha baru
    public function create()
    {        
            $users = User::all();
            return view('pages.usaha.create', compact('users'));
    }

     // Menyimpan usaha baru
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'nama_usaha' => 'required|unique:usahas,nama_usaha',
            'waktu_operational' => 'required',
            'lokasi_usaha' => 'required',
            'nomor_usaha' => 'required',
            'deskripsi' => 'required',
            'user_id' => 'required',
        ]);

         // Menyimpan data usaha ke database
        $usaha = new usaha;
        $usaha->nama_usaha = $request->nama_usaha;
        $usaha->waktu_operational = $request->waktu_operational;
        $usaha->lokasi_usaha = $request->lokasi_usaha;
        $usaha->nomor_usaha = $request->nomor_usaha;
        $usaha->deskripsi = $request->deskripsi;
        $usaha->user_id = $request->user_id;
        $usaha->save();
         // Redirect setelah berhasil menyimpan
        return redirect()->route('usaha.index')->with('success', 'usaha berhasil dibuat!');
    }

    public function edit($id)
    {
        $users = User::all();// Ambil usaha berdasarkan ID
        $usaha = Usaha::findOrFail($id);
        return view('pages.usaha.edit', compact('users', 'usaha'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_usaha' => 'required|unique:usahas,nama_usaha',
            'waktu_operational' => 'required',
            'lokasi_usaha' => 'required',
            'nomor_usaha' => 'required',
            'deskripsi' => 'required',
            // 'user_id' => 'required',
        ]);
        // Cari usaha berdasarkan ID
        $usaha = Usaha::findOrFail($id);

            // Menyimpan data usaha ke database
            $usaha->nama_usaha = $request->nama_usaha;
            $usaha->waktu_operational = $request->waktu_operational;
            $usaha->lokasi_usaha = $request->lokasi_usaha;
            $usaha->nomor_usaha = $request->nomor_usaha;
            $usaha->deskripsi = $request->deskripsi;
            // $usaha->user_id = $request->user_id;
            $usaha->save();

        return redirect()->route('usaha.index')->with('success', 'usaha berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $usaha = Usaha::findOrFail($id); // Ambil usaha berdasarkan ID

        $usaha->delete(); // Hapus data usaha

        return redirect()->route('usaha.index')->with('success', 'usaha berhasil dihapus!');
    }
}
