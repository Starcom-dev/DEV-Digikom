<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriPembayaranResource;
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;

class KategoriPembayaranController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $kategoris = KategoriPembayaran::latest()->get();
        return new KategoriPembayaranResource( true, 'Detail Kategori', $kategoris);
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $kategori = KategoriPembayaran::find($id);
        
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return new KategoriPembayaranResource( true, 'Detail Kategori', $kategori);
    }
}
