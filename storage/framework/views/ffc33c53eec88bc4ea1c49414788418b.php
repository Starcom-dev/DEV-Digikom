

<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <!-- partial -->
    <div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='<?php echo e(route('iuran.index')); ?>'" class="btn btn-primary">
                ← Kembali ke Daftar iuran
            </button>
        </div>

        <!-- Header  -->
        <div class="card mb-4" style="background-image: url('<?php echo e(asset('storage/' . $iuran->banner)); ?>'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
            <div class="card-body d-flex flex-column justify-content-end" style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px;">
                <p class="text-muted mb-0">By: <?php echo e($iuran->creator->full_name ?? 'Admin'); ?></p>
                <p class="text-muted">Published: <?php echo e($iuran->created_at->diffForHumans()); ?></p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info iuran -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Detail iuran</h5>
                        <p class="text-white"><strong>Bulan:</strong> <?php echo e($iuran->bulan); ?></p>
                        <p class="text-white"><strong>Jumlah:</strong> <?php echo e($iuran->jumlah); ?></p>
                        <p class="text-white"><strong>Keterangan:</strong> <?php echo e($iuran->keterangan); ?></p>
                    </div>
                    <!-- Deskripsi -->
                    <!-- <div class="col-md-8">
                        <h5 class="text-muted fw-bold">Deskripsi</h5>
                        <div class="text-white">
                            <?php echo $iuran->deskripsi_iuran; ?>

                        </div>
                    </div> -->
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
<?php /**PATH /home/azrayaal/Downloads/digikom/be/resources/views/pages/iuran/show.blade.php ENDPATH**/ ?>