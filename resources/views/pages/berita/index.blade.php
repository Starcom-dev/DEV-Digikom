@include('components.header')
@include('components.sidebar')
@include('components.navbar')

    
    <!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Berita:</h3>
            <a href="{{ route('berita.create') }}" class="btn btn-primary">Create New Berita</a>
        </div>
        <div class="col grid-margin stretch-card">
    <div class="card" style="background-color: #2A2A2A;">
        <div class="card-body">
            <!-- Filter dan Pencarian -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <!-- Dropdown Show Entries -->
                <form action="{{ route('berita.index') }}" method="GET" class="">
                    <select name="per_page" onchange="this.form.submit()" class="form-control text-white" style="background-color: #2A2A2A; border: 1px solid #8C8D90;">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>Show 10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>Show 25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>Show 50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>Show 100</option>
                    </select>
                </form>

                <!-- Form Pencarian -->
                <form action="{{ route('berita.index') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" name="search" class="form-control text-white" placeholder="Cari berita..."
                        value="{{ request('search') }}" 
                        style="background-color: #2A3038; border: 1px solid #8C8D90;"
                        onfocus="this.style.backgroundColor='#2A2A2A'; this.style.color='#ffffff';">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
            </div>

            <!-- Daftar Berita -->
            <div class="row">
                <div class="col-12">
                    <div class="preview-list">
                        @foreach ($berita as $item)
                        <div class="preview-item border-bottom" 
                            style="border-bottom-width: 3px; border-color: #8C8D90!important; cursor: pointer;"
                            onclick="window.location.href='{{ route('berita.show', $item->id) }}'">
                            <div class="preview-thumbnail">
                                <img src="{{ asset('storage/' . $item->banner) }}" alt="banner" class="img-fluid" style="max-width: 100px; border-radius: 5px;">
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                                <div class="flex-grow d-flex flex-column justify-content-between" style="height: 100%;">
                                    <h6 class="preview-subject text-white">{{ $item->tittle }}</h6>
                                    <p class="text-muted mb-0">By: {{ Str::limit(strip_tags($item->creator->full_name), 100) }}</p>
                                </div>
                                <div class="text-sm-right pt-2 pt-sm-0 ml-auto">
                                    <p class="text-muted mb-2">{{ $item->created_at->timezone('Asia/Jakarta')->diffForHumans() }}
                                    </p>
                                    <p class="text-muted mb-0">Date: {{ $item->created_at->format('d M Y, H:i') ?? 'Tidak diketahui' }}</p>
                                    <!-- Tombol Edit dan Delete -->
                                    <div class="mt-2">
                                        <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('berita.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        {{ $berita->links() }}
    </nav>
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
        <!-- main-panel ends -->

@include( 'components.footer')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        padding: 10px;
    }

    .pagination .page-item .page-link {
        color: #ffffff;
        background-color: #2A2A2A;
        border: 1px solid #D1D1D1;
        border-radius: 5px;
        margin: 0 5px;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }

    .pagination .page-item .page-link:hover {
        background-color: #ffffff;
        color: #2A2A2A;
        border-color: #2A2A2A;
    }

    .pagination .page-item.active .page-link {
        background-color: #D1D1D1;
        color: #2A2A2A;
        border-color: #2A2A2A;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #E5E5E5;
        color: #A0A0A0;
    }
</style>
