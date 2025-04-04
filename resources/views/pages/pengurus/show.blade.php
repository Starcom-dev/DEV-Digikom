

@include('components.header')
@include('components.sidebar')
@include('components.navbar')

    
    <!-- partial -->
    <div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='{{ route('pengurus.index') }}'" class="btn btn-primary">
                ← Kembali ke Daftar pengurus
            </button>
        </div>

        <!-- Konten Utama -->
        <div class="card shadow-lg" style="background-color: #2A2A2A; border-radius: 15px; overflow: hidden;">
    <div class="card-header text-center" style="background-color: #1F1F1F; padding: 15px;">
        <h4 class="text-white fw-bold">Informasi pengurus</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Info pengurus -->
            <div class="col-md-4">
                <h5 class="text-muted fw-bold">Detail pengurus</h5>
                <p class="text-white mb-2">
                    <i class="mdi mdi-storefront-outline text-primary me-2"></i>
                    <strong>Nama pengurus:</strong> {{ $pengurus->user->full_name }}
                </p>
            </div>
            <!-- Deskripsi -->
            <div class="col-md-8">
                <h5 class="text-muted fw-bold">Detail Jabatan</h5>
                <p class="text-white mb-2">
                    <strong>Nama Jabatan:</strong> {{ $pengurus->jabatan->nama_jabatan }}
                </p>
                <p class="text-white mb-2">
                    <strong>Deskripsi Jabatan:</strong> {{ $pengurus->jabatan->deskripsi }}
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
