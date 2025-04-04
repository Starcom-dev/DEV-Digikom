

<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <!-- partial -->
    <div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='<?php echo e(route('iuran.tagihan')); ?>'" class="btn btn-primary">
                ← Kembali ke Daftar tagihan
            </button>
        </div>

        <!-- Header  -->
        <div class="card mb-4" style="background-image: url('<?php echo e(asset('storage/' . $tagihan->banner)); ?>'); background-size: cover; background-position: center;border: none; border-radius: 10px;">
            <div class="card-body d-flex flex-column justify-content-end" 
                style="background: rgba(0, 0, 0, 0.6); height: 100%; border-radius: 10px; 
                background-color: <?php echo e($tagihan->status == 'Belum Lunas' ? '#ff4d4d' : '#28a745'); ?>;">
                <p class="text-white"><strong>Status Tagihan:</strong> <?php echo e($tagihan->status); ?></p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Info tagihan -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Detail Tagihan</h5>
                        <p class="text-white"><strong>No Anggota:</strong> <?php echo e($tagihan->users->phone_number); ?></p>
                        <p class="text-white"><strong>Nama Anggota:</strong> <?php echo e($tagihan->users->full_name); ?></p>
                        <p class="text-white"><strong>Jumlah:</strong> Rp. <?php echo e(number_format($tagihan->nominal, 0, ',', '.')); ?></p>
                        <p class="text-white"><strong>Keterangan:</strong> <?php echo e($tagihan->keterangan); ?></p>
                        <p class="text-white"><strong>Tahun Iuran:</strong> <?php echo e($tagihan->iuran->tahun); ?></p>
                    </div>

                    <!-- Info Iuran -->
                    <div class="col-md-8">
                        <h5 class="text-muted fw-bold">Info Iuran Terkait</h5>
                        <p class="text-white"><strong>Keterangan Iuran:</strong> <?php echo e($tagihan->iuran->keterangan); ?></p>
                        <p class="text-white"><strong>Tanggal Dibuat:</strong> <?php echo e($tagihan->iuran->created_at->format('d-m-Y')); ?></p>
                        <p class="text-white"><strong>Tempo:</strong> <?php echo e($tagihan->iuran->tempo ? $tagihan->iuran->tempo->format('d-m-Y') : 'Belum Ditentukan'); ?></p>
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
<?php /**PATH /home/digikom/laravel/resources/views/pages/iuran/laporanDetail.blade.php ENDPATH**/ ?>