@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Laporan Iuran:</h3>
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
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('iuran.tagihan') }}" method="GET" class="d-flex">

                                <div class="p-2">
                                    <select name="year" class="form-control text-white">
                                        <option value="" style>-- Select Year --</option>
                                        @foreach (['2025', '2026'] as $year)
                                            <option value="{{ $year }}"
                                                {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                            </option>
                                        @endforeach
                                        </option>
                                    </select>
                                </div>
                                <div class="p-2">
                                    <select name="month" class="form-control ml-2 text-white">
                                        <option value="">-- Select Month --</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                {{ request('month') == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="p-2">
                                    <select name="user_id" class="form-control ml-2 text-white">
                                        <option value="">-- Select User --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="p-2 d-flex align-items-center justify-content-center">
                                    <button type="submit" class="btn btn-sm btn-primary">Lihat Iuran</button>
                                </div>
                                <div class="p-2 d-flex align-items-center justify-content-end flex-grow-1">
                                    <a href="{{ route('iuran.print') }}" class="btn btn-sm btn-primary float-right">
                                        <span class="menu-icon">
                                            <i class="mdi mdi-printer"></i>
                                        </span>
                                        Print Iuran
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Hanya tampilkan tabel jika ada pencarian -->
                    @if (request()->has('year') || request()->has('month') || request()->has('user_id'))
                        @if ($iuran->count())
                            <table class="table table-hover text-white">
                                <thead>
                                    <tr style="background-color: #D1D1D1;">
                                        <th style="color: black;">No</th>
                                        <th style="color: black;">No Anggota</th>
                                        <th style="color: black;">Nama Anggota</th>
                                        <th style="color: black;">Jumlah</th>
                                        <th style="color: black;">Keterangan</th>
                                        <th style="color: black;">Tahun</th>
                                        <th style="color: black;">Status</th>
                                        <th style="color: black;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($iuran as $item)
                                        <tr onclick="location.href='{{ route('tagihan.show', $item->id) }}'"
                                            style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->users->phone_number }}</td>
                                            <td>{{ $item->users->full_name }}</td>
                                            <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->iuran->tahun }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <a href="{{ route('tagihan.show', $item->id) }}"
                                                    class="btn btn-sm btn-warning">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-muted mt-3">Tidak ada iuran yang sesuai dengan pencarian.</p>
                        @endif
                    @else
                        <p class="text-center text-muted mt-3">Silakan pilih filter untuk menampilkan data.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if (request()->has('year') || request()->has('month') || request()->has('user_id'))
            <div class="d-flex justify-content-center mt-4">
                {{ $iuran->links('pagination::bootstrap-4') }}
            </div>
        @endif
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
