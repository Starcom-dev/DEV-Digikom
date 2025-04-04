

@include('components.header')
@include('components.sidebar')
@include('components.navbar')

    
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper" style="background-color: #D1D1D1;">
            <!-- Tombol Kembali -->
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('anggaran-rumah-tangga.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar Anggaran Rumah Tangga
                </button>
            </div>

                <!-- Header -->
                <div class="card mb-4" style="background-image: url('{{ asset('storage/' . $anggaran_rumah_tangga->banner) }}'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
                <div class="card-body d-flex flex-column justify-content-end" style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px;">
                    <h1 class="text-white fw-bold">{{ $anggaran_rumah_tangga->judul_utama }}</h1>
                    <p class="text-muted mb-0">By: {{ $anggaran_rumah_tangga->creator->full_name ?? 'Admin' }}</p>
                    <p class="text-muted">Published: {{ $anggaran_rumah_tangga->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
                <div class="card-body">
                    <div class="row">
                        <!-- Info anggaran_rumah_tangga -->
                        <div class="col-md-4">
                            <h5 class="text-muted fw-bold">Deskripsi:</h5>
                            <p class="text-white">{{ $anggaran_rumah_tangga->deskripsi }}</p>
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
