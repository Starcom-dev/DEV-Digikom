@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat Jabatan Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('jabatan.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar Jabatan
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
                <form action="{{ route('jabatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_jabatan" class="text-white" style="font-weight: bold;">Nama Jabatan</label>
                        <input type="text" class="form-control text-white" name="nama_jabatan" id="nama_jabatan" required>
                    </div>
                    <div class="form-group">
                            <label for="deskripsi" class="text-white">Deskripsi</label>
                            <textarea class="form-control text-white" name="deskripsi" id="deskripsi" rows="5" required></textarea>
                    </div>

                    <!-- <div class="form-group">
                        <label for="keterangan" class="text-white" style="font-weight: bold;">keterangan</label>
                        <input type="text" class="form-control text-white" name="keterangan" id="keterangan" required>
                    </div> -->

                    <button type="submit" class="btn btn-primary">Simpan Jabatan</button>
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