@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat pengurus Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('pengurus.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar pengurus
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
                <form action="{{ route('pengurus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group pb-3">
        <label for="nama_pengurus" class="text-white" style="font-weight: bold;">Pemilik pengurus</label>
        <select name="nama_pengurus" id="nama_pengurus" class="form-control text-white" required>
            <option value="">Nama Pengurus</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group pb-3">
        <label for="jabatan_pengurus" class="text-white" style="font-weight: bold;">Pemilik pengurus</label>
        <select name="jabatan_pengurus" id="jabatan_pengurus" class="form-control text-white" required>
            <option value="">Jabatan Pengurus</option>
            @foreach ($jabatans as $jabatan)
                <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan pengurus</button>
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