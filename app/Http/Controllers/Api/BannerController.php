<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BannerResource;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        //get all banner
        $banners = Banner::with('creator')->latest()->get();
        //return collection of posts as a resource
        return new BannerResource(true, 'List Data Banner', $banners);
    }
    
    public function store(Request $request)
    {
        // Menyimpan data banner ke database
        $banner = new Banner;
        $banner->gambar = $request->gambar;
        $banner->created_by = Auth::user()->id;
        // Menyimpan banner gambar
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('banner', 'public');
            $banner->gambar = $imagePath; // Simpan path lengkap
        }
        $banner->save();
        return new BannerResource(true, 'Data Banner', $banner);
    }

    public function show($id)
    {
        // Mencari banner berdasarkan ID
        $banner = Banner::with('creator')->find($id);
        // Jika banner tidak ditemukan, return response error
        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner tidak ditemukan',
            ], 404);
        }
        // Return data banner
        return new BannerResource(true, 'Detail Data Banner', $banner);
    }
}
