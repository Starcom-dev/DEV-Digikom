<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PengurusResource;
use App\Models\Jabatan;
use App\Models\Pengurus;

class PengurusController extends Controller
{
    public function index()
    {
        //get all posts
        // $penguruses = Pengurus::latest()->paginate(5);
        $penguruses = Pengurus::with('user', 'jabatan')->latest()->get();
        //return collection of posts as a resource
        return new PengurusResource(true, 'List Data Pengurus', $penguruses);
    }

    public function show($id)
    {
        // Mencari pengurus berdasarkan ID
        $pengurus = Pengurus::with('user', 'jabatan')->find($id);

        // Jika pengurus tidak ditemukan, return response error
        if (!$pengurus) {
            return response()->json([
                'success' => false,
                'message' => 'Pengurus tidak ditemukan',
            ], 404);
        }

        // Return data pengurus
        return new PengurusResource(true, 'Detail Data Pengurus', $pengurus);
    }

    public function search(Jabatan $jabatan)
    {
        $idJabatan = $jabatan->id;
        $pengurus = Pengurus::with('user', 'jabatan')->where('jabatan_pengurus', $idJabatan)->get();
        if (count($pengurus) <= 0) {
            return response()->json([
                'success' => true,
                'message' => 'Tidak ada pengurus dengan jabatan ' . $jabatan->nama_jabatan,
                'data' => []
            ], 404);
        }
        return new PengurusResource(true, 'Detail Data Pengurus', $pengurus);
    }
}
