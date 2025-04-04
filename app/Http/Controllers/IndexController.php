<?php

namespace App\Http\Controllers;


//import model product

//import return type View
use Illuminate\View\View;
use App\Models\User; 
// use App\Models\User; 
use App\Models\Kegiatan; 
use App\Models\Berita; 

class IndexController extends Controller
{
    public function index() : View
    {
        //render view with products
        $totalAnggota = User::count();
        $totalUsahaAnggota = User::count();
        $totalKegiatan = Kegiatan::count();
        $totalBerita = Berita::count();
      	$totalPendaftar = User::where('status', 2)->count();

             // Gabungkan semua data ke dalam satu array
        $data = [
            'totalAnggota' => $totalAnggota,
            'totalUsahaAnggota' => $totalUsahaAnggota,
            'totalKegiatan' => $totalKegiatan,
            'totalBerita' => $totalBerita,
          	'totalPendaftar' => $totalPendaftar
        ];


         // Render view dengan total anggota
        return view('index', $data);
    }
}
