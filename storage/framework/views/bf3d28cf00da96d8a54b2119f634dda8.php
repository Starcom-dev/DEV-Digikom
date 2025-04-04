   <!-- partial:partials/_sidebar.html -->
  <!-- Sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <div class="">
            <a class="sidebar-brand brand-logo" href="/">
                <img src="<?php echo e(asset('assets/digikomLogo.png')); ?>" alt="logo" style="width: 50px; height: 50px;" />
            </a>
        </div>  
        <div class="">
            <a class="sidebar-brand brand-logo-mini" href="/">
                <img src="<?php echo e(asset('assets/digikomLogo.png')); ?>" alt="logo" style="width: 50px; height: 50px" />
            </a>
        </div>
    </div>
    <ul class="nav">
        <!-- Sidebar Profile -->
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="<?php echo e(asset('templateViews/template/assets/images/faces/face15.jpg')); ?>" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal"><?php echo e(Auth::guard('admin')->user()->full_name); ?></h5>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
            </div>
        </li>

        <!-- Navigation -->
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        
        <!-- Dashboard -->
        <li class="nav-item menu-items">
            <a class="nav-link <?php echo e(request()->is('dashboard*') ? 'active' : ''); ?>" href="/">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Anggota (Dropdown) -->
        <li class="nav-item menu-items">
            <a class="nav-link <?php echo e(request()->is('anggota*') || request()->is('pengurus*') || request()->is('jabatan*') || request()->is('usaha*') ? 'active' : ''); ?>" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-icon">
                    <i class="mdi mdi-contacts"></i>
                </span>
                <span class="menu-title">Anggota</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php echo e(request()->is('anggota*') || request()->is('pengurus*') || request()->is('jabatan*') || request()->is('usaha*') ? 'show' : ''); ?>" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('anggota.index')); ?>">Daftar Anggota</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('pengurus.index')); ?>">Pengurus</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('jabatan.index')); ?>">Jabatan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('usaha.index')); ?>">Usaha Anggota</a></li>
                </ul>
            </div>
        </li>

        <!-- Iuran -->
        <li class="nav-item menu-items">
            <a class="nav-link <?php echo e(request()->is('iuran*') || request()->is('tagihan*') || request()->is('laporan-iuran*') ? 'active' : ''); ?>" data-toggle="collapse" href="#iuran" aria-expanded="false" aria-controls="iuran">
                <span class="menu-icon">
                    <i class="mdi mdi-cash-multiple"></i>
                </span>
                <span class="menu-title">Iuran</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php echo e(request()->is('iuran*') || request()->is('tagihan*') || request()->is('laporan-iuran*') ? 'show' : ''); ?>" id="iuran">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('iuran.index')); ?>">Setup Iuran</a></li>
                </ul>
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('iuran.tagihan')); ?>">Laporan Iuran</a></li>
                </ul>
            </div>
        </li>

        <!-- Kegiatan -->
        <li class="nav-item menu-items">
            <a class="nav-link <?php echo e(request()->is('kegiatan*') ? 'active' : ''); ?>" href="<?php echo e(route('kegiatan.index')); ?>">
                <span class="menu-icon">
                    <i class="mdi mdi-table-large"></i>
                </span>
                <span class="menu-title">Kegiatan</span>
            </a>
        </li>

        <!-- Berita -->
        <li class="nav-item menu-items">
            <a class="nav-link <?php echo e(request()->is('berita*') ? 'active' : ''); ?>" href="<?php echo e(route('berita.index')); ?>">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">Berita</span>
            </a>
        </li>

        <!-- AD ART (Dropdown) -->
        <li class="nav-item menu-items">
            <a class="nav-link <?php echo e(request()->is('anggaran-dasar*') || request()->is('anggaran-rumah-tangga*') || request()->is('peraturan-organisasi*') ? 'active' : ''); ?>" data-toggle="collapse" href="#ad_art" aria-expanded="false" aria-controls="ad_art">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">AD ART</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php echo e(request()->is('anggaran-dasar*') || request()->is('anggaran-rumah-tangga*') || request()->is('peraturan-organisasi*') ? 'show' : ''); ?>" id="ad_art">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('anggaran-dasar.index')); ?>">Anggaran Dasar</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('anggaran-rumah-tangga.index')); ?>">Anggaran Rumah Tangga</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('peraturan-organisasi.index')); ?>">Peraturan Organisasi</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>



      <script>
      $(document).ready(function() {
          // Cek apakah collapse sudah terbuka
          if(localStorage.getItem('ad_art_open') === 'true') {
              $('#ad_art').addClass('show');
          }

          // Simpan status collapse di localStorage saat menu diklik
          $('#auth').on('show.bs.collapse', function() {
              localStorage.setItem('ad_art_open', 'true');
          });

          $('#auth').on('hide.bs.collapse', function() {
              localStorage.setItem('ad_art_open', 'false');
          });
      });
      </script>
      <script>
          $(document).ready(function() {
              if(window.location.href.indexOf("anggaran-dasar") !== -1) {
                  $('#ad_art').addClass('show');
              }
          });
      </script>
<?php /**PATH /home/azrayaal/Downloads/digikom/be/resources/views/components/sidebar.blade.php ENDPATH**/ ?>