

<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='<?php echo e(route('kegiatan.index')); ?>'" class="btn btn-primary">
                ← Kembali ke Daftar Kegiatan
            </button>
        </div>

        <!-- Header -->
        <div class="card mb-4" style="background-image: url('<?php echo e(asset('storage/' . $kegiatan->banner)); ?>'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
            <div class="card-body d-flex flex-column justify-content-end" style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px;">
                <h1 class="text-white fw-bold"><?php echo e($kegiatan->nama_kegiatan); ?></h1>
                <p class="text-muted mb-0">By: <?php echo e($kegiatan->creator->full_name ?? 'Admin'); ?></p>
                <p class="text-muted">Published: <?php echo e($kegiatan->created_at->diffForHumans()); ?></p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info Kegiatan -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Detail Kegiatan</h5>
                        <p class="text-white"><strong>Waktu:</strong> <?php echo e($kegiatan->waktu_kegiatan); ?></p>
                        <p class="text-white"><strong>Tanggal:</strong> <?php echo e($kegiatan->tanggal_kegiatan); ?></p>
                        <p class="text-white"><strong>Lokasi:</strong> <?php echo e($kegiatan->lokasi_kegiatan); ?></p>
                    </div>
                    <!-- Deskripsi -->
                    <div class="col-md-8">
                        <h5 class="text-muted fw-bold">Deskripsi</h5>
                        <div class="text-white">
                            <?php echo $kegiatan->deskripsi_kegiatan; ?>

                        </div>
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
<?php /**PATH /home/digikom.xyz/laravel/resources/views/pages/kegiatan/show.blade.php ENDPATH**/ ?>