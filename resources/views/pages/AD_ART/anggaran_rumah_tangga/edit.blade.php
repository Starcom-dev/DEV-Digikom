@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Edit Anggaran Dasar "{{ $anggaran_rumah_tangga->judul_utama }}"</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('anggaran-rumah-tangga.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar Anggaran Rumah Tangga
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
                    <form action="{{ route('anggaran-rumah-tangga.update', $anggaran_rumah_tangga->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="judul_utama" class="text-white" style="font-weight: bold;">Judul</label>
                            <input  type="text"
                            class="form-control"
                            name="judul_utama"
                            id="judul_utama"
                            value="{{ $anggaran_rumah_tangga->judul_utama }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="sub_judul" class="text-white" style="font-weight: bold;">Sub Judul</label>
                            <input  type="text" 
                            class="form-control" 
                            name="sub_judul" 
                            id="sub_judul" 
                            value="{{ $anggaran_rumah_tangga->sub_judul }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" 
                            value="{{ $anggaran_rumah_tangga->deskripsi }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>{{ $anggaran_rumah_tangga->deskripsi }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Anggaran Rumah Tangga</button>
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