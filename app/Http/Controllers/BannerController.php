<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
//import return type View
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(Request $request) : View
    {
        //Query ambil semua data banner
        $banners = Banner::with('creator')->get();
        return view('pages.banner.index', compact('banners'));
    }

     // Menampilkan form untuk membuat banner baru
    public function create()
    {
        return view('pages.banner.create');
    }

    public function store(Request $request)
    {
      	// Validasi input
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:10048', // Maksimum 2MB
        ]);
        // Menyimpan data berita ke database
        $banner = new Banner;
        $banner->created_by = Auth::guard('admin')->user()->id;
        // Menyimpan banner gambar
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('banner', 'public');
            $banner->gambar = $imagePath; // Simpan path lengkap
        }
        $banner->save();
        return redirect()->route('banner.index')->with('success', 'Banner berhasil dibuat!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id); // Ambil banner berdasarkan ID
        return view('pages.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
	{
      // Validasi input
      $request->validate([
          'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      // Cari banner berdasarkan ID
      $banner = Banner::findOrFail($id);
      // Update banner
      if ($request->hasFile('gambar')) {
        	//Hapus gambar banner lama
        	if ($banner->gambar && Storage::exists('public/' . $banner->gambar)) {
                Storage::delete('public/' . $banner->gambar);
            }
        	//Simpan gambar banner baru
            $imagePath = $request->file('gambar')->store('banner', 'public');
            $banner->gambar = $imagePath; // Simpan path lengkap
      }
      $banner->save();
      return redirect()->route('banner.index')->with('success', 'Banner berhasil diperbarui!');
  	}

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id); // Ambil banner berdasarkan ID
        // Hapus gambar dari storage jika ada
        if ($banner->gambar && Storage::exists('public/' . $banner->gambar)) {
          	Storage::delete('public/' . $banner->gambar);
        }
        $banner->delete(); // Hapus data banner
        return redirect()->route('banner.index')->with('success', 'Banner berhasil dihapus!');
    }

}
