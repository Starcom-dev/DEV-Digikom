@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Edit Anggota "{{ $user->full_name }}"</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('anggota.index') }}'" class="btn btn-primary">
                    ← Kembali ke Daftar Anggota
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
                    <form action="{{ route('anggota.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="full_name" class="text-white" style="font-weight: bold;">Nama Anggota</label>
                            <input  type="text"
                            class="form-control"
                            name="full_name"
                            id="full_name"
                            value="{{ $user->full_name }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="text-white" style="font-weight: bold;">Email</label>
                            <input  type="email"
                            class="form-control"
                            name="email"
                            id="email"
                            value="{{ $user->email }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="text-white" style="font-weight: bold;">Password</label>
                            <input  type="password"
                            class="form-control"
                            name="password"
                            id="password"
                            value="{{ $user->password }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="profile_picture" class="text-white" style="font-weight: bold;">Profile</label>
                            <input  type="file"
                            class="form-control"
                            name="profile_picture"
                            id="profile_picture"
                            value="{{ $user->profile_picture }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number" class="text-white" style="font-weight: bold;">Phone</label>
                            <input  type="number"
                            class="form-control"
                            name="phone_number"
                            id="phone_number"
                            value="{{ $user->phone_number }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>
                        
                        <div class="form-group pb-3">
                            <label for="jabatan_id" class="text-white" style="font-weight: bold;">Jabatan</label>
                            <select name="jabatan_id" id="jabatan_id" class="form-control text-white" required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}" 
                                        @if($jabatan->id == $user->jabatan_id) selected @endif>
                                        {{ $jabatan->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Update Anggota</button>
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