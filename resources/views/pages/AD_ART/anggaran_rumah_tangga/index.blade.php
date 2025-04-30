@include('components.header')
@include('components.sidebar')
@include('components.navbar')


<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Anggaran Rumah Tangga:</h3>
            <a href="{{ route('anggaran-rumah-tangga.create') }}" class="btn btn-primary">Create New </a>
        </div>
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <form action="{{ route('anggaran-rumah-tangga.index') }}" method="GET" class="">
                                <select name="per_page" onchange="this.form.submit()" class="form-control text-white">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>Show 10
                                    </option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>Show 25
                                    </option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>Show 50
                                    </option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>Show 100
                                    </option>
                                </select>
                            </form>

                            <form action="{{ route('anggaran-rumah-tangga.index') }}" method="GET"
                                class="d-flex align-items-center">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari Anggaran Rumah Tangga..." value="{{ request('search') }}"
                                    onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';">
                                <button type="submit" class="btn btn-primary ml-2">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover text-white">
                                <thead>
                                    <tr style="background-color: #D1D1D1;">
                                        <th style="color: black;">No</th>
                                        <th style="color: black;">Judul</th>
                                        <th style="color: black;">Deskripsi</th>
                                        <th style="color: black;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggaran_rumah_tangga as $item)
                                        <tr onclick="location.href='{{ route('anggaran-rumah-tangga.show', $item->id) }}'"
                                            style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->judul_utama }}</td>
                                            <td>{{ \Str::words($item->deskripsi, 15) }}</td>
                                            <td>
                                                <a href="{{ route('anggaran-rumah-tangga.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('anggaran-rumah-tangga.destroy', $item->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus Anggaran Rumah Tangga ini?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($anggaran_rumah_tangga->isEmpty())
                            <p class="text-center text-muted mt-3">Tidak ada Anggaran Rumah Tangga yang tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $anggaran_rumah_tangga->links('pagination::bootstrap-4') }}
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
