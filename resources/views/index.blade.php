@include('components.header')
@include('components.sidebar')
@include('components.navbar')
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card" onclick="redirectToAnggota()" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="text-success mb-0">Anggota</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-account-outline icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">{{ $totalAnggota }}</h6>
                </div>
            </div>
        </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card" onclick="redirectToPengurus()" style="cursor: pointer;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0 text-warning">Pengurus</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-warning">
                          <span class="mdi mdi-account-multiple-outline icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"></h6> -->
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card" onclick="redirectUsahaAnggota()" style="cursor: pointer;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="text-primary mb-0">Usaha</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-primary">
                          <span class="mdi mdi-store icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">{{ $totalUsahaAnggota }}</h6>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card" onclick="redirectToKegiatan()" style="cursor: pointer;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0 text-danger">Kegiatan</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-run icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">{{ $totalKegiatan }}</h6>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card" onclick="redirectToBerita()" style="cursor: pointer;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0 text-primary">Berita</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-primary ">
                          <span class="mdi mdi-newspaper icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">{{ $totalBerita }}</h6>
                  </div>
                </div>
              </div>
      
      		<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card" onclick="redirectToPendaftar()" style="cursor: pointer;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0 text-success">Pendaftar</h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-account-plus icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">{{ $totalPendaftar }}</h6>
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
@include( 'components.footer')


<script>
    function redirectToAnggota() {
        window.location.href = "{{ route('anggota.index') }}";
    }
    function redirectToPengurus() {
        window.location.href = "{{ route('pengurus.index') }}";
    }
    function redirectUsahaAnggota() {
        window.location.href = "{{ route('usaha.index') }}";
    }
    function redirectToKegiatan() {
        window.location.href = "{{ route('kegiatan.index') }}";
    }
    function redirectToBerita() {
        window.location.href = "{{ route('berita.index') }}";
    }
  	function redirectToPendaftar() {
    	window.location.href = "{{ route('pendaftar') }}"
    }
</script>
