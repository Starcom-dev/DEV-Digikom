

<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <!-- partial -->
    <div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='<?php echo e(route('anggaran-dasar.index')); ?>'" class="btn btn-primary">
                ← Kembali ke Daftar Anggaran Dasar
            </button>
        </div>

       <!-- Header -->
       <div class="card mb-4" style="background-image: url('<?php echo e(asset('storage/' . $anggaran_dasar->banner)); ?>'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
            <div class="card-body d-flex flex-column justify-content-end" style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px;">
                <h1 class="text-white fw-bold"><?php echo e($anggaran_dasar->judul_utama); ?></h1>
                <p class="text-muted mb-0">By: <?php echo e($anggaran_dasar->creator->full_name ?? 'Admin'); ?></p>
                <p class="text-muted">Published: <?php echo e($anggaran_dasar->created_at->diffForHumans()); ?></p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info anggaran_dasar -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Deskripsi:</h5>
                        <p class="text-white"><?php echo e($anggaran_dasar->deskripsi); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" style="background-color: #2A2A2A; padding: 10px 0;">
        <div class="container text-center">
            <span class="text-muted d-block text-white">Copyright © digikom.com <?php echo e(date('Y')); ?></span>
            <span class="text-muted d-block text-white">All Rights Reserved</span>
        </div>
    </footer>
</div>


<?php echo $__env->make( 'components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/digikom.xyz/laravel/resources/views/pages/AD_ART/anggaran_dasar/show.blade.php ENDPATH**/ ?>