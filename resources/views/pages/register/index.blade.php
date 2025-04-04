@include('components.header')
@include('components.sidebar')
@include('components.navbar')

    
<!-- partial -->
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Pendaftar:</h3>
        </div>
      	@if(session('success'))
      	<div class="col stretch-card">
          <div class="alert alert-success" role="alert">
            {{session('success')}}
          </div>
      	</div>
      	@endif
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <form action="{{ route('anggota.index') }}" method="GET" class="">
                                <select name="per_page" onchange="this.form.submit()" class="form-control text-white">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>Show 10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>Show 25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>Show 50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>Show 100</option>
                                </select>
                            </form>

                            <form action="{{ route('anggota.index') }}" method="GET" class="d-flex align-items-center">
                                <input type="text" name="search" class="form-control" placeholder="Cari pendaftar..." value="{{ request('search') }}" onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';">
                                <button type="submit" class="btn btn-primary ml-2">Search</button>
                            </form>
                        </div>

                        <!-- Wrap table with a div to make it horizontally scrollable if needed -->
                        <div class="table-responsive">
                            <table class="table table-hover text-white">
                                <thead>
                                    <tr style="background-color: #D1D1D1;">
                                        <th style="color: black;">No</th>
                                        <th style="color: black;">Profile</th>
                                        <th style="color: black;">Nama Lengkap</th>
                                        <th style="color: black;">Email</th>
                                        <th style="color: black;">Nomor Telpon</th>
                                        <th style="color: black;">Jabatan</th>
                                        <th style="color: black;">Status</th>
                                        <th style="color: black;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->profile_picture) }}" alt="" style="width: 50px; height: 50px;">
                                        </td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ $item->creator->nama_jabatan ?? 'Tidak Ada Jabatan' }}</td>
                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('update_pendaftar', ['id' => $item->id, 'status' => 'approve']) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                              	@method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Apakah Anda yakin ingin approve pendaftar ini?')">
                                                    	Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('update_pendaftar', ['id' => $item->id, 'status' => 'reject']) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($user->isEmpty())
                        <p class="text-center text-muted mt-3">Tidak ada user yang tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $user->links('pagination::bootstrap-4') }}
    </div>
    
    <!-- Footer -->
    <footer class="footer" style="background-color: #2A2A2A; padding: 10px 0;">
        <div class="container text-center">
            <span class="text-muted d-block text-white">Copyright © digikom.com {{ date('Y') }}</span>
            <span class="text-muted d-block text-white">All Rights Reserved</span>
        </div>
    </footer>
</div>


