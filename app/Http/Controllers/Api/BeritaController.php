<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BeritaResource;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        //get all posts
        // $beritas = Berita::latest()->paginate(5);
        $beritas = Berita::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new BeritaResource(true, 'List Data Berita', $beritas);
    }

    public function show($id)
    {
        // Mencari berita berdasarkan ID
        $berita = Berita::with('creator')->find($id);

        // Jika berita tidak ditemukan, return response error
        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        // Return data berita
        return new BeritaResource(true, 'Detail Data Berita', $berita);
    }

    public function search(Request $request)
{
    $request->validate([
        'query' => 'required|string',
    ]);

    $query = $request->input('query');
    \Log::info('Pencarian query: ' . $query);

    $beritas = Berita::
        whereRaw('LOWER(tittle) LIKE ?', ['%' . strtolower($query) . '%'])
        ->orWhereRaw('LOWER(content) LIKE ?', ['%' . strtolower($query) . '%'])
        ->latest()
        ->get();

    // Debugging hasil query
    \Log::info('Beritas:', $beritas->toArray());

    if ($beritas->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Berita tidak ditemukan',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Hasil Pencarian Berita',
        'data' => $beritas,
    ]);
}

}
