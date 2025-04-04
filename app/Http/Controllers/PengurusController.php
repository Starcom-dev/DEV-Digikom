<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//import model product
use App\Models\Pengurus; 
use App\Models\User; 
use App\Models\Jabatan; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//import return type View
use Illuminate\View\View;

class PengurusController extends Controller
{
    public function index(Request $request) : View
    {
        // Ambil input untuk search dan sort
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'nama_pengurus'); // Default sort by 'nama_pengurus'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $pengurus = pengurus::when($search, function ($query, $search) {
                return $query->where('nama_pengurus', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return view('pages.pengurus.index', compact('pengurus', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        $pengurus = Pengurus::with(['jabatan', 'user'])->findOrFail($id); // Ambil pengurus berdasarkan ID
        return view('pages.pengurus.show', compact('pengurus'));
    }

     // Menampilkan form untuk membuat pengurus baru
    public function create()
    {        
            $users = User::all();
            $jabatans = Jabatan::all();
            return view('pages.pengurus.create', compact('users', 'jabatans'));
    }

     // Menyimpan pengurus baru
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'nama_pengurus' => 'required',
            'jabatan_pengurus' => 'required',
        ]);

         // Menyimpan data pengurus ke database
        $pengurus = new pengurus;
        $pengurus->nama_pengurus = $request->nama_pengurus;
        $pengurus->jabatan_pengurus = $request->jabatan_pengurus;
        $pengurus->save();
         // Redirect setelah berhasil menyimpan
        return redirect()->route('pengurus.index')->with('success', 'pengurus berhasil dibuat!');
    }

    public function edit($id)
    {
        $users = User::all();// Ambil pengurus berdasarkan ID
        $jabatans = Jabatan::all();
        $pengurus = pengurus::findOrFail($id);
        return view('pages.pengurus.edit', compact('users', 'pengurus', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            // 'nama_pengurus' => 'required',
            'jabatan_pengurus' => 'required',
        ]);
        // Cari pengurus berdasarkan ID
        $pengurus = pengurus::findOrFail($id);

            // Menyimpan data pengurus ke database
            // $pengurus->nama_pengurus = $request->nama_pengurus;
            $pengurus->jabatan_pengurus = $request->jabatan_pengurus;
            $pengurus->save();

        return redirect()->route('pengurus.index')->with('success', 'pengurus berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengurus = pengurus::findOrFail($id); // Ambil pengurus berdasarkan ID

        $pengurus->delete(); // Hapus data pengurus

        return redirect()->route('pengurus.index')->with('success', 'pengurus berhasil dihapus!');
    }
}
