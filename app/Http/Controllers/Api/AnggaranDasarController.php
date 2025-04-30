<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AnggaranDasarResource;
use App\Models\AnggaranDasar;

class AnggaranDasarController extends Controller
{
    public function index()
    {
        //get all posts
        // $anggaran_dasar = AnggaranDasar::latest()->paginate(5);
        $anggaran_dasar = AnggaranDasar::with('creator')->orderBy('id', 'ASC')->get();
        //return collection of posts as a resource
        return new AnggaranDasarResource(true, 'List Data Anggaran Dasar', $anggaran_dasar);
    }

    public function show($id)
    {
        // Mencari anggaran_dasar berdasarkan ID
        $anggaran_dasar = AnggaranDasar::with('creator')->find($id);

        // Jika anggaran_dasar tidak ditemukan, return response error
        if (!$anggaran_dasar) {
            return response()->json([
                'success' => false,
                'message' => 'Anggaran Dasar tidak ditemukan',
            ], 404);
        }

        // Return data anggaran_dasar
        return new AnggaranDasarResource(true, 'Detail Data Anggaran Dasar', $anggaran_dasar);
    }
}
