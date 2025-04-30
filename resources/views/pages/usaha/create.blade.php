@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat usaha Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('usaha.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar usaha
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
                    <form action="{{ route('usaha.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="bidang_usaha" class="text-white" style="font-weight: bold;">Bidang Usaha</label>
                            <select class="form-control text-white" name="bidang_usaha" id="bidang_usaha">
                                <option value="" selected disabled>Pilih Bidang Usaha</option>
                                @foreach ($bidangs as $value)
                                    <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori_usaha" class="text-white" style="font-weight: bold;">Kategory
                                Usaha</label>
                            <select class="form-control text-white" name="kategori_usaha" id="kategori_usaha">
                                <option value="" selected disabled>Pilih Kategori Usaha</option>
                                @foreach ($categories as $value)
                                    <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_usaha" class="text-white" style="font-weight: bold;">Nama Usaha</label>
                            <input type="text" class="form-control text-white" name="nama_usaha" id="nama_usaha"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="waktu_operational" class="text-white" style="font-weight: bold;">Waktu</label>
                            <input type="time" class="form-control text-white" name="waktu_operational"
                                id="waktu_operational" required>
                        </div>

                        <div class="form-group">
                            <label for="lokasi_usaha" class="text-white" style="font-weight: bold;">Lokasi</label>
                            <input type="text" class="form-control text-white" name="lokasi_usaha" id="lokasi_usaha"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="nomor_usaha" class="text-white" style="font-weight: bold;">Nomor Usaha</label>
                            <input type="number" class="form-control text-white" name="nomor_usaha" id="nomor_usaha"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
                            <input type="text" class="form-control text-white" name="deskripsi" id="deskripsi"
                                required>
                        </div>

                        <div class="form-group pb-3">
                            <label for="user_id" class="text-white" style="font-weight: bold;">Pemilik Usaha</label>
                            <select name="user_id" id="user_id" class="form-control text-white" required>
                                <option value="">Pilih Anggota Pemilik</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan usaha</button>
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
