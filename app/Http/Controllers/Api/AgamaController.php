<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AgamaResource;
use App\Models\Agama;

class AgamaController extends Controller
{
    public function index()
    {
        //get all posts
        // $agamas = Agama::latest()->paginate(5);
        $agamas = Agama::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new AgamaResource(true, 'List Data Agama', $agamas);
    }

    public function show($id)
    {
        // Mencari agama berdasarkan ID
        $agama = Agama::with('creator')->find($id);

        // Jika agama tidak ditemukan, return response error
        if (!$agama) {
            return response()->json([
                'success' => false,
                'message' => 'Agama tidak ditemukan',
            ], 404);
        }

        // Return data agama
        return new AgamaResource(true, 'Detail Data Agama', $agama);
    }

}
