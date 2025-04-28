<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BeritaResource;
use App\Models\Berita;
use Illuminate\Support\Facades\Log;

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

    public function show($id, Request $request)
    {
        // Mencari berita berdasarkan ID
        if ($id === 'search') {
            $query = $request->query('query');
            Log::channel('single')->info('Pencarian query: ' . $query);

            $beritas = Berita::whereRaw('LOWER(tittle) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orWhereRaw('LOWER(content) LIKE ?', ['%' . strtolower($query) . '%'])
                ->latest()
                ->get();

            // Debugging hasil query
            Log::channel('single')->info('Beritas:', $beritas->toArray());

            if ($beritas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukans',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Hasil Pencarian Berita',
                'data' => $beritas,
            ]);
        }
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

    // public function search($query)
    // {

    //     Log::channel('single')->info('Pencarian query: ' . $query);

    //     $beritas = Berita::whereRaw('LOWER(tittle) LIKE ?', ['%' . strtolower($query) . '%'])
    //         ->orWhereRaw('LOWER(content) LIKE ?', ['%' . strtolower($query) . '%'])
    //         ->latest()
    //         ->get();

    //     // Debugging hasil query
    //     Log::channel('single')->info('Beritas:', $beritas->toArray());

    //     if ($beritas->isEmpty()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Berita tidak ditemukans',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Hasil Pencarian Berita',
    //         'data' => $beritas,
    //     ]);
    // }
}
