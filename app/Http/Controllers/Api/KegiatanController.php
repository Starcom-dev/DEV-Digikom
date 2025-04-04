<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\KegiatanResource;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    public function index()
    {
        // $kegiatans = Kegiatan::latest()->paginate(5);
        $kegiatans = Kegiatan::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new KegiatanResource(true, 'List Data Kegiatan', $kegiatans);
    }

    public function show($id)
    {
        // Mencari kegiatan berdasarkan ID
        $kegiatan = Kegiatan::with('creator')->find($id);

        // Jika kegiatan tidak ditemukan
        if (!$kegiatan) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan',
            ], 404);
        }

        // Return detail kegiatan
        return new KegiatanResource(true, 'Detail Data Kegiatan', $kegiatan);
    }
}
