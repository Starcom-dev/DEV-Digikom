

@include('components.header')
@include('components.sidebar')
@include('components.navbar')

    
    <!-- partial -->
    <div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='{{ route('usaha.index') }}'" class="btn btn-primary">
                ← Kembali ke Daftar usaha
            </button>
        </div>

        <!-- Konten Utama -->
        <div class="card shadow-lg" style="background-color: #2A2A2A; border-radius: 15px; overflow: hidden;">
    <div class="card-header text-center" style="background-color: #1F1F1F; padding: 15px;">
        <h4 class="text-white fw-bold">Informasi Usaha</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Info Usaha -->
            <div class="col-md-4">
                <h5 class="text-muted fw-bold">Detail Usaha</h5>
                <p class="text-white mb-2">
                    <i class="mdi mdi-storefront-outline text-primary me-2"></i>
                    <strong>Nama Usaha:</strong> {{ $usaha->nama_usaha }}
                </p>
                <p class="text-white mb-2">
                    <i class="mdi mdi-map-marker-outline text-danger me-2"></i>
                    <strong>Lokasi:</strong> {{ $usaha->lokasi_usaha }}
                </p>
            </div>
            <!-- Deskripsi -->
            <div class="col-md-8">
                <h5 class="text-muted fw-bold">Detail Lainnya</h5>
                <p class="text-white mb-2">
                    <i class="mdi mdi-phone-outline text-success me-2"></i>
                    <strong>Nomor Usaha:</strong> {{ $usaha->nomor_usaha }}
                </p>
                <p class="text-white mb-2">
                    <i class="mdi mdi-clock-outline text-warning me-2"></i>
                    <strong>Waktu Operasional:</strong> {{ $usaha->waktu_operational }}
                </p>
                <p class="text-white mb-2">
                    <i class="mdi mdi-information-outline text-info me-2"></i>
                    <strong>Deskripsi:</strong> {!! $usaha->deskripsi !!}
                </p>
            </div>
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
