<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AnggaranRumahTanggaResource;
use App\Models\AnggaranRumahTangga;

class AnggaranRumahTanggaController extends Controller
{
    public function index()
    {
        //get all posts
        // $anggaran_rumah_tangga = AnggaranRumahTangga::latest()->paginate(5);
        $anggaran_rumah_tangga = AnggaranRumahTangga::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new AnggaranRumahTanggaResource(true, 'List Data Anggaran Dasar', $anggaran_rumah_tangga);
    }

    public function show($id)
    {
        // Mencari anggaran_rumah_tangga berdasarkan ID
        $anggaran_rumah_tangga = AnggaranRumahTangga::with('creator')->find($id);

        // Jika anggaran_rumah_tangga tidak ditemukan, return response error
        if (!$anggaran_rumah_tangga) {
            return response()->json([
                'success' => false,
                'message' => 'Anggaran Dasar tidak ditemukan',
            ], 404);
        }

        // Return data anggaran_rumah_tangga
        return new AnggaranRumahTanggaResource(true, 'Detail Data Anggaran Dasar', $anggaran_rumah_tangga);
    }

}
