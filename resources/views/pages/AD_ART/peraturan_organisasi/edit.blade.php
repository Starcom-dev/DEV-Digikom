@include('components.header')
@include('components.sidebar')
@include('components.navbar')

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Edit Peraturan Organisasi</h3>
            <div class="mb-3">
                <button onclick="window.location.href='{{ route('peraturan-organisasi.index') }}'"
                    class="btn btn-primary">
                    ← Kembali ke Daftar Peraturan Organisasi
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
                    <form action="{{ route('peraturan-organisasi.update', $peraturan_organisasi->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- <div class="form-group">
                            <label for="judul" class="text-white" style="font-weight: bold;">Judul</label>
                            <input  type="text"
                            class="form-control"
                            name="judul"
                            id="judul"
                            value="{{ $peraturan_organisasi->judul }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" 
                            value="{{ $peraturan_organisasi->deskripsi }}" 
                            onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';"
                            required>{{ $peraturan_organisasi->deskripsi }}</textarea>
                        </div> --}}
                        <textarea id="myeditorinstance" name="peraturan">{{{$peraturan_organisasi->text_editor}}}</textarea>
                        <div class="m-2 float-right">
                            <button type="submit" class="btn btn-primary">Update Peraturan Organisasi</button>
                        </div>
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

<script src="https://cdn.tiny.cloud/1/bda6brhfhkwcbjx1mnf8x7m4ipjdrg7ryrkbfu4b5sdcecfr/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({

        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE

        // plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion markdown math importword exportword exportpdf',

        toolbar: 'undo redo | accordion accordionremove | importword exportword exportpdf | math | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | pagebreak anchor codesample | ltr rtl',

        menubar: 'file edit view insert format tools table help'

    });
</script>

@include('components.footer')
