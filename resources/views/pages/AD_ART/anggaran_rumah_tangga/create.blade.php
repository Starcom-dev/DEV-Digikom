@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat Anggaran Dasar Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('anggaran-rumah-tangga.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar Anggaran Dasar
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
                <form action="{{ route('anggaran-rumah-tangga.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="judul_utama" class="text-white" style="font-weight: bold;">Judul</label>
                        <input type="text" class="form-control text-white" name="judul_utama" id="judul_utama" required>
                    </div>

                    <div class="form-group">
                        <label for="sub_judul" class="text-white" style="font-weight: bold;">Sub Judul</label>
                        <input type="text" class="form-control text-white" name="sub_judul" id="sub_judul" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
                        <textarea class="form-control text-white" name="deskripsi" id="deskripsi" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Anggaran Dasar</button>
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