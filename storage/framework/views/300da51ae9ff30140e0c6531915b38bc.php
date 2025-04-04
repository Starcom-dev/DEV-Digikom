

  <?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='<?php echo e(route('berita.index')); ?>'" class="btn btn-primary">
                ← Kembali ke Daftar Berita
            </button>
        </div>

        <!-- Header -->
        <div class="card mb-4" style="background-image: url('<?php echo e(asset('storage/' . $berita->banner)); ?>'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
            <div class="card-body d-flex flex-column justify-content-end" style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px;">
                <h1 class="text-white fw-bold"><?php echo e($berita->tittle); ?></h1>
                <p class="text-muted mb-0">By: <?php echo e($berita->creator->full_name ?? 'Admin'); ?></p>
                <p class="text-muted">Published: <?php echo e($berita->created_at->diffForHumans()); ?></p>
                <p class="text-muted">Published: <?php echo e($berita->created_at); ?> / <?php echo e($berita->created_at->diffForHumans()); ?></p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info berita -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Content:</h5>
                        <p class="text-white"><?php echo e($berita->content); ?></p>
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

<?php echo $__env->make( 'components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/digikom.xyz/laravel/resources/views/pages/berita/show.blade.php ENDPATH**/ ?>