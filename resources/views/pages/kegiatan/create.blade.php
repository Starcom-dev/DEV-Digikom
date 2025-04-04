@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat kegiatan Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('kegiatan.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar Kegiatan
                </button>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kegiatan" class="text-white" style="font-weight: bold;">Nama Kegiatan</label>
                        <input type="text" class="form-control text-white" name="nama_kegiatan" id="tittle" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kegiatan" class="text-white" style="font-weight: bold;">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" name="tanggal_kegiatan" id="tanggal_kegiatan" required>
                    </div>

                    <div class="form-group">
                        <label for="waktu_kegiatan" class="text-white" style="font-weight: bold;">Waktu Kegiatan</label>
                        <input type="time" class="form-control" name="waktu_kegiatan" id="waktu_kegiatan" required>
                    </div>

                    <div class="form-group">
                        <label for="lokasi_kegiatan" class="text-white" style="font-weight: bold;">Lokasi Kegiatan</label>
                        <textarea class="form-control text-white" name="lokasi_kegiatan" id="lokasi_kegiatan" rows="2" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi_kegiatan" class="text-white" style="font-weight: bold;">Deskripsi Kegiatan</label>
                        <textarea class="form-control text-white" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
                </form>
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
@include( 'components.footer')