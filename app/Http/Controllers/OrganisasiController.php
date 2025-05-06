<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function anggaranDasar()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $anggaranDasar = $organisasi->anggaran_dasar ?? '';
        return view('pages.organisasi.anggaran_dasar.index', compact('idOrganisasi', 'anggaranDasar'));
    }

    public function createAnggaranDasar()
    {
        $organisasi = Organisasi::first();
        $anggaranDasar = $organisasi->anggaran_dasar ?? '';
        return view('pages.organisasi.anggaran_dasar.create', compact('anggaranDasar'));
    }

    public function updateAnggaranDasar(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->anggaran_dasar = $request->anggaran_dasar;
        $organisasi->save();
        return redirect()->route('anggaran-dasar')->with('success', 'Anggaran dasar berhasil diperbarui!');
    }

    public function anggaranRumahTangga()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $anggaranRumahTangga = $organisasi->anggaran_rumah_tangga ?? '';
        return view('pages.organisasi.anggaran_rumah_tangga.index', compact('idOrganisasi', 'anggaranRumahTangga'));
    }

    public function createAnggaranRumahTangga()
    {
        $organisasi = Organisasi::first();
        $anggaranRumahTangga = $organisasi->anggaran_rumah_tangga ?? '';
        return view('pages.organisasi.anggaran_rumah_tangga.create', compact('anggaranRumahTangga'));
    }

    public function updateAnggaranRumahTangga(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->anggaran_rumah_tangga = $request->anggaran_rumah_tangga;
        $organisasi->save();
        return redirect()->route('anggaran-rumah-tangga')->with('success', 'Anggaran dasar berhasil diperbarui!');
    }

    public function peraturanOrganisasi()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $peraturanOrganisasi = $organisasi->peraturan_organisasi ?? '';
        return view('pages.organisasi.peraturan_organisasi.index', compact('idOrganisasi', 'peraturanOrganisasi'));
    }

    public function createPeraturanOrganisasi()
    {
        $organisasi = Organisasi::first();
        $peraturanOrganisasi = $organisasi->peraturan_organisasi ?? '';
        return view('pages.organisasi.peraturan_organisasi.create', compact('peraturanOrganisasi'));
    }

    public function updatePeraturanOrganisasi(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->peraturan_organisasi = $request->peraturan;
        $organisasi->save();
        return redirect()->route('peraturan-organisasi')->with('success', 'Peraturan Organisasi berhasil diperbarui!');
    }

    public function tentangOrganisasi()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $tentangOrganisasi = $organisasi->tentang_organisasi ?? '';
        return view('pages.organisasi.tentang_organisasi.index', compact('idOrganisasi', 'tentangOrganisasi'));
    }

    public function createTentangOrganisasi()
    {
        $organisasi = Organisasi::first();
        $tentangOrganisasi = $organisasi->tentang_organisasi ?? '';
        return view('pages.organisasi.tentang_organisasi.create', compact('tentangOrganisasi'));
    }

    public function updateTentangOrganisasi(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->tentang_organisasi = $request->tentang;
        $organisasi->save();
        return redirect()->route('tentang-organisasi')->with('success', 'Tentang Organisasi berhasil diperbarui!');
    }

    public function privacy()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $privacy = $organisasi->privacy ?? '';
        return view('pages.organisasi.privacy.index', compact('idOrganisasi', 'privacy'));
    }

    public function updatePrivacy(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->privacy = $request->privacy;
        $organisasi->save();
        return redirect()->route('privacy-edit')->with('success', 'Privacy berhasil diperbarui!');
    }

    public function syaratAplikasi()
    {
        $organisasi = Organisasi::first();
        $idOrganisasi = $organisasi->id ?? '';
        $syaratApk = $organisasi->syarat_ketentuan_aplikasi ?? '';
        return view('pages.organisasi.syarat_ketentuan_aplikasi.index', compact('idOrganisasi', 'syaratApk'));
    }

    public function updateSyaratAplikasi(Request $request)
    {
        $organisasi = Organisasi::first();
        $organisasi->syarat_ketentuan_aplikasi = $request->syarat_apk;
        $organisasi->save();
        return redirect()->route('syaratketentuanaplikasi-edit')->with('success', 'Syarat ketentuan aplikasi berhasil diperbarui!');
    }
}
