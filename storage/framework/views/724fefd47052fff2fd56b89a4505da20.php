<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat Anggaran Dasar Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='<?php echo e(route('anggaran-dasar.index')); ?>'" class="btn btn-primary">
                    ← Kembali ke Daftar Anggaran Dasar
                </button>
            </div>
        </div>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="color: red;"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                <form action="<?php echo e(route('anggaran-dasar.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="judul_utama" class="text-white" style="font-weight: bold;">Judul</label>
                        <input type="text" class="form-control text-white" name="judul_utama" id="judul_utama" required>
                    </div>

                    <div class="form-group">
                        <label for="sub_judul" class="text-white" style="font-weight: bold;">Sub Judul</label>
                        <input type="text" class="form-control text-white" name="sub_judul" id="sub_judul" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
                        <textarea class="form-control text-white" name="deskripsi" id="deskripsi" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Anggaran Dasar</button>
                </form>
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
<?php echo $__env->make( 'components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/digikom.xyz/laravel/resources/views/pages/AD_ART/anggaran_dasar/create.blade.php ENDPATH**/ ?>