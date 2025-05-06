<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SyaratKetentuanAplikasi extends Controller
{
    public function syaratApk(): View
    {
        $organisasi = Organisasi::first();
        $syaratApk = $organisasi->syarat_ketentuan_aplikasi ?? '';
        return view('pages.syarat_ketentuan_aplikasi.index', compact('syaratApk'));
    }
}
