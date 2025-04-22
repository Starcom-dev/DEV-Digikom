<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

//import model product
use App\Models\User;
use App\Models\Jabatan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

//import return type View
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil input untuk search dan sort
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'full_name'); // Default sort by 'full_name'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        $user = User::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%");
        })
            ->where('status', 2)
            ->orderBy($sortBy, $order)
            ->paginate($perPage);

        return view('pages.register.index', compact('user', 'search', 'sortBy', 'order'));
    }

    public function show(User $user)
    {
        $user->load(['pendidikan', 'agama', 'pekerjaan']);
        return view('pages.register.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = user::findOrFail($id); // Ambil user berdasarkan ID

        $user->delete(); // Hapus data user

        return redirect()->route('anggota.index')->with('success', 'user berhasil dihapus!');
    }


    public function toggleSuspend($id)
    {
        $user = User::findOrFail($id);

        // Toggle status: Jika 0 jadi 1, jika 1 jadi 0
        $user->status = $user->status == 0 ? 1 : 0;
        $user->save();

        $message = $user->status == 1 ? 'User berhasil diaktifkan kembali (unsuspend)!' : 'User berhasil disuspend!';
        return redirect()->route('anggota.index')->with('success', $message);
    }

    public function update($id, $status)
    {
        $user = User::findOrFail($id);
        if ($status == 'approve') {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->update();
        $message = 'Success';
        return redirect()->route('anggota.index')->with('success', $message);
    }
}
