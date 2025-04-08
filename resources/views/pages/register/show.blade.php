@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<style>
  p, h1, h2, h3, h4, h5, table{
  	color: #000;
    font-family: Arial;
  }
  table{
    width: 100%;
  	border: 1px;
    color: #525252;
  }
  table tr td{
  	padding: 2px;
  }
</style>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
      <div class="card p-2 mt-5" style="background-color: #fff">
        
        <div class="d-flex pl-4 border-bottom" style="height: 7rem;">
          <div class="flex-grow-1" style="transform: translate(0, -50px)">
              <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px;" />
          </div>
          <div class="ml-4 mt-4 d-flex justify-content-between" style="width: 100%">
            <div class="flex-grow-1">
              <h3 class="">{{ $user->full_name }}</h3>
              <p>{{ $user->email }}</p>
            </div>
          	<div>
          		<button onclick="window.location.href='{{ route('pendaftar') }}'" class="btn btn-primary">← Kembali ke Daftar Pendaftar</button>
            </div>
          </div>
        </div>
        
        <div class="d-flex justify-content-center">
          <div class="mt-2 flex-grow-1 m-2" style="background-color: #e6e6e6; border-radius: 10px; padding: 15px;">
            <h5 class="">Detail Profile</h5>
            <table style="font-size: 12px">
              <tr>
                <td>Tempat Lahir</td>
                <td>: {{ $user->tempat_lahir }}</td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td>: {{ $user->tanggal_lahir }}</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>: {{ $user->alamat }}</td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>: {{ $user->agama_id != null ? $user->agama->agama : 'Belum diisi' }}</td>
              </tr>
              <tr>
                <td>Nomor HP</td>
                <td>: {{ $user->phone_number }}</td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>: {{ $user->creator->nama_jabatan ?? 'Tidak Ada Jabatan' }}</td>
              </tr>
              <tr>
                <td>Pendidikan</td>
                <td>: {{ $user->pendidikan_id != null ? $user->pendidikan->pendidikan : 'Belum diisi' }}</td>
              </tr>
              <tr>
                <td>Pekerjaan</td>
                <td>: {{ $user->pekerjaan_id != null ? $user->pekerjaan->pekerjaan : 'Belum diisi' }}</td>
              </tr>
            </table>
          </div>
          <div class="mt-2 flex-grow-1 m-2" style="background-color: #e6e6e6; border-radius: 10px; padding: 15px;">
            <div class="text-center" style="width: 100%">
              	@if($user->ktp_picture != null)
            		<img src="{{ asset('storage/' . $user->ktp_picture) }}" class="img-thumbnail" style="width: 20rem; height: 10rem; object-fit:cover;" alt="ktp_picture"/>
              		<a class="btn btn-sm btn-primary ml-2" href="{{ asset('storage/' . $user->ktp_picture) }}" target="_blank">🔎 Lihat Detail</a>
              	@else
              		<img src="{{ asset('assets/ktp_default.png') }}" class="img-thumbnail" style="width: 20rem; height:10rem;" alt="ktp_picture"/>
              	@endif
            </div>
            <p class="mt-2">No. KTP : {{ $user->nomor_ktp }} </p>
          </div>
        </div>
        
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer" style="background-color: #2A2A2A; padding: 10px 0;">
        <div class="container text-center">
            <span class="text-muted d-block text-white">Copyright © digikom.com {{ date('Y') }}</span>
            <span class="text-muted d-block text-white">All Rights Reserved</span>
        </div>
    </footer>
</div>

@include('components.footer')
