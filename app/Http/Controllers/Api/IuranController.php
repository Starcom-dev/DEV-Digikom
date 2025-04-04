<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\IuranResource;
use App\Models\Iuran;

class IuranController extends Controller
{
    public function index()
    {
        //get all posts
        // $iurans = Iuran::latest()->paginate(5);
        $iurans = Iuran::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new IuranResource(true, 'List Data Iuran', $iurans);
    }

    public function show($id)
    {
        // Mencari iuran berdasarkan ID
        $iuran = Iuran::with('creator')->find($id);

        // Jika iuran tidak ditemukan, return response error
        if (!$iuran) {
            return response()->json([
                'success' => false,
                'message' => 'Iuran tidak ditemukan',
            ], 404);
        }

        // Return data iuran
        return new IuranResource(true, 'Detail Data Iuran', $iuran);
    }

}
