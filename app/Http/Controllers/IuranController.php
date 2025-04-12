<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Iuran;
use App\Models\User;
use App\Models\Tagihan; // Pastikan model Tagihan diimpor
use Illuminate\View\View;

class IuranController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'tahun'); // Default sort by 'tahun'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);

        $iuran = Iuran::when($search, function ($query, $search) {
            return $query->where('tahun', 'like', "%{$search}%")
                ->orWhere('jumlah', 'like', "%{$search}%");
        })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);

        return view('pages.iuran.index', compact('iuran', 'search', 'sortBy', 'order'));
    }

    public function show($id)
    {
        $iuran = Iuran::with('creator')->findOrFail($id);
        return view('pages.iuran.show', compact('iuran'));
    }

    public function create()
    {
        return view('pages.iuran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'masa_aktif' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        $iuran = new Iuran;
        $iuran->masa_aktif = $request->masa_aktif;
        $iuran->jumlah = $request->jumlah;
        $iuran->keterangan = $request->masa_aktif . ' Bulan';
        $iuran->created_by = Auth::guard('admin')->user()->id;
        $iuran->save();

        return redirect()->route('iuran.index')->with('success', 'Iuran berhasil dibuat!');
    }

    public function edit($id)
    {
        $iuran = Iuran::findOrFail($id);
        return view('pages.iuran.edit', compact('iuran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'masa_aktif' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        $iuran = Iuran::findOrFail($id);
        $iuran->masa_aktif = $request->masa_aktif;
        $iuran->jumlah = $request->jumlah;
        $iuran->keterangan = $request->masa_aktif . ' Bulan';
        $iuran->created_by = Auth::guard('admin')->user()->id;
        $iuran->save();

        return redirect()->route('iuran.index')->with('success', 'Iuran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $iuran = Iuran::findOrFail($id);
        $iuran->delete();

        return redirect()->route('iuran.index')->with('success', 'Iuran berhasil dihapus!');
    }

    /**
     * Enroll tagihan dari iuran untuk bulan Januari hingga Desember.
     */
    public function enrollTagihan($id)
    {
        $iuran = Iuran::findOrFail($id); // Cari iuran berdasarkan ID

        // Ambil semua user yang aktif
        $users = User::where('status', 1)->get();

        $tahun = $iuran->tahun; // Tahun dari iuran
        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        foreach ($users as $user) {
            foreach ($bulan as $index => $namaBulan) {
                // Cek apakah tagihan untuk user, bulan, dan tahun ini sudah ada
                $existingTagihan = Tagihan::where('user_id', $user->id)
                    ->where('iuran_id', $iuran->id)
                    ->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $index + 1)
                    ->first();

                if (!$existingTagihan) {
                    // Jika belum ada, buat tagihan baru
                    $tagihan = new Tagihan;
                    $tagihan->user_id = $user->id;
                    $tagihan->iuran_id = $iuran->id;
                    $tagihan->nominal = $iuran->jumlah;
                    $tagihan->keterangan = $namaBulan;
                    $tagihan->status = 'Belum Lunas'; // Default status
                    $tagihan->created_at = \Carbon\Carbon::create($tahun, $index + 1, 1); // Buat tanggal dengan bulan dan tahun
                    $tagihan->updated_at = \Carbon\Carbon::create($tahun, $index + 1, 1);
                    $tagihan->save();
                } else {
                    return redirect()->route('iuran.index')->with('warning', 'Tagihan untuk tahun ' . $tahun . ' dan bulan ' . $namaBulan . ' sudah ada.');
                }
            }
        }

        return redirect()->route('iuran.index')->with('success', 'Tagihan berhasil dienroll untuk iuran ini!');
    }

    public function laporanIuran(Request $request)
    {
        $search = $request->input('search');
        $year = $request->input('year');
        $month = $request->input('month');
        $userId = $request->input('user_id');
        $sortBy = $request->input('sort_by', 'created_at');  // Change to 'created_at' or another column
        $order = $request->input('order', 'asc');
        $perPage = $request->input('per_page', 10);

        // Build the query
        $iuran = Tagihan::query();

        if ($search) {
            $iuran->where('tahun', 'like', "%{$search}%")
                ->orWhere('jumlah', 'like', "%{$search}%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%");
                });
        }

        if ($year) {
            $iuran->where('tahun', $year);
        }

        if ($month) {
            $iuran->whereMonth('created_at', $month);
        }

        if ($userId) {
            $iuran->where('user_id', $userId);
        }

        // Sort by the selected column (either 'created_at' or 'tahun' if it exists)
        // Pada query laporanIuran
        // Menggunakan eager loading untuk mengoptimalkan performa
        $iuran = Tagihan::with('iuran') // Pastikan relasi iuran sudah didefinisikan
            ->when($search, function ($query) use ($search) {
                $query->where('jumlah', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('full_name', 'like', "%{$search}%");
                    });
            })
            ->when($year, function ($query) use ($year) {
                $query->whereHas('iuran', function ($query) use ($year) {
                    $query->where('tahun', $year);
                });
            })
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('created_at', $month);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy($sortBy, $order)
            ->paginate($perPage);


        // Pass the users for the filter dropdown
        $users = User::all();

        return view('pages.iuran.laporan', compact('iuran', 'users', 'search', 'year', 'month', 'userId'));
    }

    public function showTagihan($id)
    {
        // Cari tagihan berdasarkan ID, bersama dengan relasi 'iuran' dan 'users'
        $tagihan = Tagihan::with(['iuran', 'users'])->findOrFail($id);

        // Tampilkan halaman show dengan data tagihan yang ditemukan
        return view('pages.iuran.laporanDetail', compact('tagihan'));
    }
}
