<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PekerjaanResource;
use App\Models\Pekerjaan;

class PekerjaanController extends Controller
{
    public function index()
    {
        //get all posts
        // $pekerjaans = Pekerjaan::latest()->paginate(5);
        $pekerjaans = Pekerjaan::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new PekerjaanResource(true, 'List Data Pekerjaan', $pekerjaans);
    }

    public function show($id)
    {
        // Mencari pendidikan berdasarkan ID
        $pendidikan = Pekerjaan::with('creator')->find($id);

        // Jika pendidikan tidak ditemukan, return response error
        if (!$pendidikan) {
            return response()->json([
                'success' => false,
                'message' => 'Pekerjaan tidak ditemukan',
            ], 404);
        }

        // Return data pendidikan
        return new PekerjaanResource(true, 'Detail Data Pekerjaan', $pendidikan);
    }

}
