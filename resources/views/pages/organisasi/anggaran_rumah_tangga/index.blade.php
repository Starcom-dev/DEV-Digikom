@include('components.header')
@include('components.sidebar')
@include('components.navbar')


<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Anggaran Rumah Tangga:</h3>
        </div>
        @session('success')
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endsession
        @if(!$anggaranRumahTangga == '' || !$anggaranRumahTangga == null)
            <div class="col-12 text-right mb-4">
                <a href="{{ route('edit-anggaran-rumah-tangga', ['id' => $idOrganisasi]) }}" class="btn btn-sm btn-primary ">Ubah Anggaran Rumah Tangga</a>
            </div>
        @endif
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        @if ($anggaranRumahTangga == '' || $anggaranRumahTangga == null)
                            <p class="text-muted mt-3">Anggaran Rumah Tangga belum di buat.</p>
                            <a href="{{ route('edit-anggaran-rumah-tangga') }}" class="btn btn-sm btn-primary ">Buat
                                Sekarang</a>
                        @else
                            <textarea id="myeditorinstance">{{{ $anggaranRumahTangga }}}</textarea>
                        @endif
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
