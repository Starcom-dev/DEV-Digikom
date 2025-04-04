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

class UserController extends Controller
{
    public function index(Request $request) : View
    {
        // Ambil input untuk search dan sort
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'full_name'); // Default sort by 'full_name'
        $order = $request->input('order', 'asc'); // Default order 'asc'
        $perPage = $request->input('per_page', 10);
        // Query dengan pencarian dan pengurutan
        $user = User::when($search, function ($query, $search) {
                return $query->where('full_name', 'like', "%{$search}%");})
          	->where('status', '!=', 2)
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return view('pages.user.index', compact('user', 'search', 'sortBy', 'order'));
    }


    public function show($id)
    {
        $user = user::with('creator')->findOrFail($id); // Ambil user berdasarkan ID
        return view('pages.user.show', compact('user'));
    }

     // Menampilkan form untuk membuat user baru
    public function create()
    { 
            $jabatans = Jabatan::all();
            return view('pages.user.create', compact(var_name: 'jabatans'));
    }

     // Menyimpan user baru
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'full_name' => 'required|unique:users,full_name',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',  // Menambahkan aturan minimal panjang password
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Mengubah 'imge' menjadi 'image' dan menambahkan nullable
            'phone_number' => 'required',
            'jabatan_id' => 'required|exists:jabatans,id', // Memastikan jabatan_id valid
        ]);
    
         // Menyimpan data user ke database
        $user = new User;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);  // Mengenkripsi password menggunakan bcrypt
    
         // Menyimpan profile picture jika ada
        if ($request->hasFile('profile_picture')) {
             // Menyimpan file gambar ke folder 'uploads/profile_pictures'
             $imagePath = $request->file('profile_picture')->store('profile_picture', 'public');
             $user->profile_picture = $imagePath; // Simpan path lengkap
        }
      
      	// Proses file profile_picture jika ada
        if ($request->hasFile('profile_picture')) {
            //$data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
          	$oldImage = $user->profile_picture;
            if($oldImage){
              Storage::disk('public')->delete($oldImage);
            }
            $user->profile_picture = $this->resizeAndStoreImage($request->file('profile_picture'), 'profile_pictures');
        }
    
        $user->phone_number = $request->phone_number;
        $user->jabatan_id = $request->jabatan_id;
        
    
        $user->save();
    
         // Redirect setelah berhasil menyimpan
        return redirect()->route('anggota.index')->with('success', 'User berhasil dibuat!');
    }
    

    public function edit($id)
    {
        $jabatans = Jabatan::all();
        $user = user::findOrFail($id); // Ambil user berdasarkan ID
        return view('pages.user.edit', compact('user', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
    
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);  // Menemukan user berdasarkan ID, jika tidak ada maka 404
    
        // Menyimpan data yang telah diubah ke database
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);  // Mengenkripsi password menggunakan bcrypt

      	if ($request->hasFile('profile_picture')) {
          $oldImage = $user->profile_picture;
          if($oldImage){
            Storage::disk('public')->delete($oldImage);
          }
          $user->profile_picture = $this->resizeAndStoreImage($request->file('profile_picture'), 'profile_pictures');
        }

        $user->phone_number = $request->phone_number;
        $user->jabatan_id = $request->jabatan_id;

        $user->save();  // Simpan perubahan ke database

        return redirect()->route('anggota.index')->with('success', 'User berhasil diperbarui!');
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
  
  	public function resizeAndStoreImage($file, $folder)
    {
        $compressionPercentage = 50;
        $image = Image::read($file);
        // Kurangi ukuran berdasarkan persentase
        $newQuality = 100 - $compressionPercentage;
        // Simpan gambar sementara ke dalam storage
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = storage_path('app/public/' . $folder . '/' . $filename);
        // Simpan gambar yang sudah dikompresi
        $image->save($path, $newQuality);
        return $folder . '/' . $filename;
    }
}
