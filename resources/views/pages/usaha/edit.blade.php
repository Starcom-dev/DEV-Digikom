@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Edit usaha "{{ $usaha->nama_usaha }}"</h3>
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
                    <form action="{{ route('usaha.update', $usaha->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_usaha" class="text-white" style="font-weight: bold;">Bidang usaha</label>
                            <select class="form-control text-white" name="bidang_usaha" id="bidang_usaha">
                                <option value="" selected disabled>Pilih Kategori Usaha</option>
                                @foreach ($bidangs as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $usaha->bidangUsaha->id == $value->id ? 'selected' : '' }}>
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_usaha" class="text-white" style="font-weight: bold;">Kategory usaha</label>
                            <select class="form-control text-white" name="kategori_usaha" id="kategori_usaha">
                                <option value="" selected disabled>Pilih Kategori Usaha</option>
                                @foreach ($categories as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $usaha->categoryUsaha->id == $value->id ? 'selected' : '' }}>
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_usaha" class="text-white" style="font-weight: bold;">Nama usaha</label>
                            <input type="text" class="form-control" name="nama_usaha" id="nama_usaha"
                                value="{{ $usaha->nama_usaha }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>

                        <div class="form-group">
                            <label for="waktu_operational" class="text-white" style="font-weight: bold;">Waktu
                                Operational</label>
                            <input type="time" class="form-control" name="waktu_operational" id="waktu_operational"
                                value="{{ $usaha->waktu_operational }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>

                        <div class="form-group">
                            <label for="lokasi_usaha" class="text-white" style="font-weight: bold;">Lokasi Usaha</label>
                            <input type="text" class="form-control" name="lokasi_usaha" id="lokasi_usaha"
                                value="{{ $usaha->lokasi_usaha }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>

                        <div class="form-group">
                            <label for="nomor_usaha" class="text-white" style="font-weight: bold;">Nomor Usaha</label>
                            <input type="number" class="form-control" name="nomor_usaha" id="nomor_usaha"
                                value="{{ $usaha->nomor_usaha }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi"
                                value="{{ $usaha->deskripsi }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>

                        <!-- <div class="form-group pb-3">
                            <label for="user_id" class="text-white" style="font-weight: bold;">Pemilik Usaha</label>
                            <select name="user_id" id="user_id" class="form-control text-white" required>
                                <option value="">Pilih Anggota Pemilik</option>
                                @foreach ($users as $User)
<option value="{{ $User->id }}"
                                        @if ($User->id == $usaha->full_name) selected @endif>
                                        {{ $User->full_name }}
                                    </option>
@endforeach
                            </select>
                        </div> -->


                        <button type="submit" class="btn btn-primary">Update usaha</button>
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
