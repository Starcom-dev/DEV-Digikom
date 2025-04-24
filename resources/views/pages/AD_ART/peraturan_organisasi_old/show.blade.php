@include('components.header')
@include('components.sidebar')
@include('components.navbar')


<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='{{ route('peraturan-organisasi.index') }}'" class="btn btn-primary">
                ← Kembali ke Daftar Peraturan Organisasi
            </button>
        </div>

        <!-- Header -->
        <div class="card mb-4"
            style="background-image: url('{{ asset('storage/' . $peraturan_organisasi->banner) }}'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
            <div class="card-body d-flex flex-column justify-content-end"
                style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px;">
                <h1 class="text-white fw-bold">{{ $peraturan_organisasi->judul }}</h1>
                <p class="text-muted mb-0">By: {{ $peraturan_organisasi->creator->full_name ?? 'Admin' }}</p>
                <p class="text-muted">Published: {{ $peraturan_organisasi->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info peraturan_organisasi -->
                    <div class="col-md-12">
                        <textarea id="myeditorinstance" name="peraturan">{{{$peraturan_organisasi->text_editor}}}</textarea>
                    </div>
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
        readonly: true,
        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE

        // plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion markdown math importword exportword exportpdf',

        toolbar: 'undo redo | accordion accordionremove | importword exportword exportpdf | math | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | pagebreak anchor codesample | ltr rtl',

        menubar: 'file edit view insert format tools table help'

    });
</script>

@include('components.footer')
