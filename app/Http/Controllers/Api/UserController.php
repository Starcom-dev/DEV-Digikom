<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    public function index()
    {
        try {
            // Ambil data user yang sedang login
            $getAuthToken = JWTAuth::parseToken()->authenticate();
          	$getUser = User::with(['pekerjaan', 'pendidikan', 'agama', 'creator'])->find($getAuthToken->id);

            // Return data user sebagai resource
            return new UserResource(true, 'Data Profile', $getUser);
        } catch (\Exception $e) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
                return new UserResource(false, 'Unauthorized', $e->getMessage());
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve user data',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }

  	public function smartCard()
    {
        try {
            // Ambil data user yang sedang login
            $user = JWTAuth::parseToken()->authenticate();

            // Return data user sebagai resource
            return new UserResource(true, 'Data Smart Card', $user);
        } catch (\Exception $e) {
            // Jika terjadi error (contohnya token invalid atau expired)
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:6',
            'phone_number' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:10048',
            'nomor_ktp' => 'nullable|string|max:50|unique:users,nomor_ktp,' . auth()->id(),
            'ktp_pictures' => 'nullable|image|mimes:jpeg,png,jpg|max:10048',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'jabatan_id' => 'nullable|integer',
            'pekerjaan_id' => 'nullable|integer',
            'agama_id' => 'nullable|integer',
            'pendidikan_id' => 'nullable|integer',
        ]);
      
      	try {
            // Ambil pengguna yang terautentikasi dari token
            $user = JWTAuth::parseToken()->authenticate();

            // Siapkan data untuk diupdate
            $data = [
                'full_name' => $request->full_name ?? $user->full_name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'phone_number' => $request->phone_number ?? $user->phone_number,
                'profile_picture' => $user->profile_picture, // default jika tidak ada file baru
                'jabatan_id' => $request->jabatan_id ?? $user->jabatan_id,
                'nomor_ktp' => $request->nomor_ktp ?? $user->nomor_ktp,
                'ktp_picture' => $user->ktp_picture,
                'tanggal_lahir' => $request->tanggal_lahir ?? $user->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir ?? $user->tempat_lahir,
                'alamat' => $request->alamat ?? $user->alamat,
                'pekerjaan_id' => $request->pekerjaan_id ?? $user->pekerjaan_id,
                'agama_id' => $request->agama_id ?? $user->agama_id,
                'pendidikan_id' => $request->pendidikan_id ?? $user->pendidikan_id,
            ];

            // Proses file profile_picture jika ada
            if ($request->hasFile('profile_picture')) {
                //$data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $this->resizeAndStoreImage($request->file('profile_picture'), 'profile_pictures');
              	$oldImage = $user->profile_picture;
              	if($oldImage){
                	Storage::disk('public')->delete($oldImage);
                }
            }

            // Save ktp image jika ada
            if ($request->hasFile('ktp_pictures')) {
                //$data['ktp_pictures'] = $request->file('ktp_pictures')->store('ktp_pictures', 'public');
                $data['ktp_picture'] = $this->resizeAndStoreImage($request->file('ktp_pictures'), 'ktp_pictures');
              	$oldImage = $user->ktp_picture;
              	if($oldImage){
                  Storage::disk('public')->delete($oldImage);
                }
            }
            // Update pengguna
          	
            $user->update($data);

            // Kembalikan respons sukses
            return new UserResource(true, 'User Updated Successfully', $user);
        } catch (\Exception $e) {
            // Tangkap dan kembalikan error
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage(),
            ], 500);
        }
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
