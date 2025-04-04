@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Edit kegiatan "{{ $kegiatan->nama_kegiatan }}"</h3>
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
                    <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_kegiatan" class="text-white" style="font-weight: bold;">Nama Kegiatan</label>
                            <input  type="text" 
                            class="form-control" 
                            name="nama_kegiatan" 
                            id="nama_kegiatan" 
                            value="{{ $kegiatan->nama_kegiatan }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_kegiatan" class="text-white" style="font-weight: bold;">Tanggal Kegiatan</label>
                            <input  type="date" 
                            class="form-control" 
                            name="tanggal_kegiatan" 
                            id="tanggal_kegiatan" 
                            value="{{ $kegiatan->tanggal_kegiatan }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="waktu_kegiatan" class="text-white" style="font-weight: bold;">Waktu Kegiatan</label>
                            <input  type="time" 
                            class="form-control" 
                            name="waktu_kegiatan" 
                            id="waktu_kegiatan" 
                            value="{{ $kegiatan->waktu_kegiatan }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="lokasi_kegiatan" class="text-white" style="font-weight: bold;">Lokasi Kegiatan</label>
                            <input  type="text" 
                            class="form-control" 
                            name="lokasi_kegiatan" 
                            id="lokasi_kegiatan" 
                            value="{{ $kegiatan->lokasi_kegiatan }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_kegiatan" class="text-white" style="font-weight: bold;">Deskripsi kegiatan</label>
                            <textarea class="form-control" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="5" 
                            value="{{ $kegiatan->nama_kegiatan }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>{{ $kegiatan->deskripsi_kegiatan }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update kegiatan</button>
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