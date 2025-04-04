

@include('components.header')
@include('components.sidebar')
@include('components.navbar')

    
    <!-- partial -->
    <div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='{{ route('jabatan.index') }}'" class="btn btn-primary">
                ← Kembali ke Daftar jabatan
            </button>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info jabatan -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Detail jabatan</h5>
                        <p class="text-white"><strong>Nama Jabatan:</strong> {{ $jabatan->nama_jabatan }}</p>
                    </div>
                    <!-- Deskripsi -->
                    <div class="col-md-8">
                        <h5 class="text-muted fw-bold">Deskripsi</h5>
                        <div class="text-white">
                            {!! $jabatan->deskripsi !!}
                        </div>
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
