<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PendidikanResource;
use App\Models\Pendidikan;

class PendidikanController extends Controller
{
    public function index()
    {
        //get all posts
        // $pendidikans = Pendidikan::latest()->paginate(5);
        $pendidikans = Pendidikan::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new PendidikanResource(true, 'List Data Pendidikan', $pendidikans);
    }

    public function show($id)
    {
        // Mencari pendidikan berdasarkan ID
        $pendidikan = Pendidikan::with('creator')->find($id);

        // Jika pendidikan tidak ditemukan, return response error
        if (!$pendidikan) {
            return response()->json([
                'success' => false,
                'message' => 'Pendidikan tidak ditemukan',
            ], 404);
        }

        // Return data pendidikan
        return new PendidikanResource(true, 'Detail Data Pendidikan', $pendidikan);
    }

}
