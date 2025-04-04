<?php

namespace App\Http\Controllers;
use App\Models\AnggaranDasar;
use App\Models\AnggaranRumahTangga;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//import model product
use App\Models\PeraturanOrganisasi; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

//import return type View
use Illuminate\View\View;

class HtmlController extends Controller
{
    public function indexPeraturanOrganisasi(Request $request) : View
    {
        $peraturan_organisasi = PeraturanOrganisasi::all();

        return view('pages.html.peraturan.index', compact('peraturan_organisasi'));
    }

    public function indexAnggaranDasar(Request $request) : View
    {
        $anggaran_dasar = AnggaranDasar::all();
        return view('pages.html.anggaranDasar.index', compact('anggaran_dasar'));
    }
    
    public function indexAnggaranRumahTangga(Request $request) : View
    {
        $anggaran_rumah_tangga = AnggaranRumahTangga::all();
        return view('pages.html.anggaranRumahtangga.index', compact('anggaran_rumah_tangga' ));
    }
}
