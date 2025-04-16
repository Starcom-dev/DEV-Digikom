@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat iuran Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('iuran.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar iuran
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
                    <form action="{{ route('iuran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="masa_aktif" class="text-white" style="font-weight: bold;">Masa Aktif
                                (Bulan)</label>
                            <input type="number" class="form-control text-white" name="masa_aktif" id="masa_aktif"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="harga" class="text-white" style="font-weight: bold;">Harga (Rp)</label>
                            <input type="number" class="form-control text-white" name="harga" id="harga"
                                required>
                        </div>

                        {{-- <div class="form-group">
                            <label for="keterangan" class="text-white" style="font-weight: bold;">keterangan</label>
                            <input type="text" class="form-control text-white" name="keterangan" id="keterangan"
                                placeholder="Cth: 3 Bulan" required>
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Simpan iuran</button>
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
@include('components.footer')
