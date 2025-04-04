<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat usaha Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='<?php echo e(route('usaha.index')); ?>'" class="btn btn-primary">
                    ← Kembali ke Daftar usaha
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
                <form action="<?php echo e(route('usaha.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="nama_usaha" class="text-white" style="font-weight: bold;">Nama Usaha</label>
        <input type="text" class="form-control text-white" name="nama_usaha" id="nama_usaha" required>
    </div>

    <div class="form-group">
        <label for="waktu_operational" class="text-white" style="font-weight: bold;">Waktu</label>
        <input type="time" class="form-control text-white" name="waktu_operational" id="waktu_operational" required>
    </div>

    <div class="form-group">
        <label for="lokasi_usaha" class="text-white" style="font-weight: bold;">Lokasi</label>
        <input type="text" class="form-control text-white" name="lokasi_usaha" id="lokasi_usaha" required>
    </div>

    <div class="form-group">
        <label for="nomor_usaha" class="text-white" style="font-weight: bold;">Nomor Usaha</label>
        <input type="number" class="form-control text-white" name="nomor_usaha" id="nomor_usaha" required>
    </div>

    <div class="form-group">
        <label for="deskripsi" class="text-white" style="font-weight: bold;">Deskripsi</label>
        <input type="text" class="form-control text-white" name="deskripsi" id="deskripsi" required>
    </div>

    <div class="form-group pb-3">
        <label for="user_id" class="text-white" style="font-weight: bold;">Pemilik Usaha</label>
        <select name="user_id" id="user_id" class="form-control text-white" required>
            <option value="">Pilih Anggota Pemilik</option>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->full_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan usaha</button>
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
<?php echo $__env->make( 'components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/digikom.xyz/laravel/resources/views/pages/usaha/create.blade.php ENDPATH**/ ?>