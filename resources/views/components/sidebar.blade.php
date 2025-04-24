   <!-- partial:partials/_sidebar.html -->
   <!-- Sidebar -->
   <nav class="sidebar sidebar-offcanvas" id="sidebar">
       <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
           <div class="">
               <a class="sidebar-brand brand-logo" href="/">
                   <img src="{{ asset('assets/digikomLogo.png') }}" alt="logo" style="width: 50px; height: 50px;" />
               </a>
           </div>
           <div class="">
               <a class="sidebar-brand brand-logo-mini" href="/">
                   <img src="{{ asset('assets/digikomLogo.png') }}" alt="logo" style="width: 50px; height: 50px" />
               </a>
           </div>
       </div>
       <ul class="nav">
           <!-- Sidebar Profile -->
           <li class="nav-item profile">
               <div class="profile-desc">
                   <div class="profile-pic">
                       <div class="count-indicator">
                           <img class="img-xs rounded-circle"
                               src="{{ asset('templateViews/template/assets/images/faces/face15.jpg') }}"
                               alt="">
                           <span class="count bg-success"></span>
                       </div>
                       <div class="profile-name">
                           <h5 class="mb-0 font-weight-normal">{{ Auth::guard('admin')->user()->full_name }}</h5>
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
               <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="/">
                   <span class="menu-icon">
                       <i class="mdi mdi-speedometer"></i>
                   </span>
                   <span class="menu-title">Dashboard</span>
               </a>
           </li>

           <!-- Anggota (Dropdown) -->
           <li class="nav-item menu-items">
               <a class="nav-link {{ request()->is('anggota*') || request()->is('pengurus*') || request()->is('jabatan*') || request()->is('usaha*') ? 'active' : '' }}"
                   data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                   <span class="menu-icon">
                       <i class="mdi mdi-contacts"></i>
                   </span>
                   <span class="menu-title">Anggota</span>
                   <i class="menu-arrow"></i>
               </a>
               <div class="collapse {{ request()->is('anggota*') || request()->is('pengurus*') || request()->is('jabatan*') || request()->is('usaha*') || request()->is('pendaftar*') ? 'show' : '' }}"
                   id="auth">
                   <ul class="nav flex-column sub-menu">
                       <li class="nav-item"><a class="nav-link" href="{{ route('anggota.index') }}">Daftar Anggota</a>
                       </li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.index') }}">Pengurus</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('jabatan.index') }}">Jabatan</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('usaha.index') }}">Usaha Anggota</a>
                       </li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('pendaftar') }}">Pendaftar</a></li>
                   </ul>
               </div>
           </li>
           <!-- Iuran (Dropdown) -->
           <li class="nav-item menu-items">
               <a class="nav-link {{ request()->is('iuran*') || request()->is('tagihan*') || request()->is('laporan-iuran*') ? 'active' : '' }}"
                   data-toggle="collapse" href="#iuran" aria-expanded="false" aria-controls="iuran">
                   <span class="menu-icon">
                       <i class="mdi mdi-contacts"></i>
                   </span>
                   <span class="menu-title">Iuran</span>
                   <i class="menu-arrow"></i>
               </a>
               <div class="collapse {{ request()->is('iuran*') || request()->is('tagihan*') || request()->is('laporan-iuran*') ? 'show' : '' }}"
                   id="iuran">
                   <ul class="nav flex-column sub-menu">
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('iuran.index') }}">Setup Iuran</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('iuran.tagihan') }}">LaporanIuran</a>
                       </li>
                   </ul>
               </div>
           </li>

           <!-- Kegiatan -->
           <li class="nav-item menu-items">
               <a class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}"
                   href="{{ route('kegiatan.index') }}">
                   <span class="menu-icon">
                       <i class="mdi mdi-table-large"></i>
                   </span>
                   <span class="menu-title">Kegiatan</span>
               </a>
           </li>

           <!-- Berita -->
           <li class="nav-item menu-items">
               <a class="nav-link {{ request()->is('berita*') ? 'active' : '' }}" href="{{ route('berita.index') }}">
                   <span class="menu-icon">
                       <i class="mdi mdi-file-document-box"></i>
                   </span>
                   <span class="menu-title">Berita</span>
               </a>
           </li>

           <!-- Banner -->
           <li class="nav-item menu-items">
               <a class="nav-link {{ request()->is('banner*') ? 'active' : '' }}" href="{{ route('banner.index') }}">
                   <span class="menu-icon">
                       <i class="mdi mdi-file-document-box"></i>
                   </span>
                   <span class="menu-title">Banner</span>
               </a>
           </li>

           <!-- AD ART (Dropdown) -->
           <li class="nav-item menu-items">
               <a class="nav-link {{ request()->is('anggaran-dasar*') || request()->is('anggaran-rumah-tangga*') || request()->is('peraturan-organisasi*') ? 'active' : '' }}"
                   data-toggle="collapse" href="#ad_art" aria-expanded="false" aria-controls="ad_art">
                   <span class="menu-icon">
                       <i class="mdi mdi-playlist-play"></i>
                   </span>
                   <span class="menu-title">AD ART</span>
                   <i class="menu-arrow"></i>
               </a>
               <div class="collapse {{ request()->is('anggaran-dasar*') || request()->is('anggaran-rumah-tangga*') || request()->is('peraturan-organisasi*') ? 'show' : '' }}"
                   id="ad_art">
                   <ul class="nav flex-column sub-menu">
                       <li class="nav-item"><a class="nav-link" href="{{ route('anggaran-dasar.index') }}">Anggaran
                               Dasar</a></li>
                       <li class="nav-item"><a class="nav-link"
                               href="{{ route('anggaran-rumah-tangga.index') }}">Anggaran Rumah Tangga</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('peraturan-organisasi') }}">Peraturan
                               Organisasi</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('tentang-organisasi') }}">Tentang
                               Organisasi</a></li>
                   </ul>
               </div>
           </li>
       </ul>
   </nav>



   <script>
       $(document).ready(function() {
           // Cek apakah collapse sudah terbuka
           if (localStorage.getItem('ad_art_open') === 'true') {
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
           if (window.location.href.indexOf("anggaran-dasar") !== -1) {
               $('#ad_art').addClass('show');
           }
       });
   </script>
