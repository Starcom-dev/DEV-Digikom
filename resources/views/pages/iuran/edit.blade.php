@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Edit iuran "{{ $iuran->nama_iuran }}"</h3>
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
                    <form action="{{ route('iuran.update', $iuran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="masa_aktif" class="text-white" style="font-weight: bold;">Masa Aktif</label>
                            <input type="text" class="form-control" name="masa_aktif" id="masa_aktif"
                                value="{{ $iuran->masa_aktif }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah" class="text-white" style="font-weight: bold;">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah"
                                value="{{ $iuran->jumlah }}"
                                onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update iuran</button>
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
