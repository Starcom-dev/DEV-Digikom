<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Buat Anggota Baru</h3>
            <div class="mb-3">
                <button onclick="window.location.href='<?php echo e(route('anggota.index')); ?>'" class="btn btn-primary">
                    ← Kembali ke Daftar Anggota
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
                <form action="<?php echo e(route('anggota.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="full_name" class="text-white" style="font-weight: bold;">Nama Lengkap</label>
        <input type="text" class="form-control text-white" name="full_name" id="full_name" required>
    </div>

    <div class="form-group">
        <label for="email" class="text-white" style="font-weight: bold;">Email</label>
        <input type="email" class="form-control text-white" name="email" id="email" required>
    </div>

    <div class="form-group">
        <label for="password" class="text-white" style="font-weight: bold;">Password</label>
        <input type="password" class="form-control text-white" name="password" id="password" required>
    </div>

    <div class="form-group">
        <label for="profile_picture" class="text-white" style="font-weight: bold;">Profile Picture</label>
        <input type="file" class="form-control text-white" name="profile_picture" id="profile_picture" required>
    </div>

    <div class="form-group">
        <label for="phone_number" class="text-white" style="font-weight: bold;">Nomor Telepon</label>
        <input type="number" class="form-control text-white" name="phone_number" id="phone_number" required>
    </div>

    <div class="form-group pb-3">
        <label for="jabatan_id" class="text-white" style="font-weight: bold;">Jabatan</label>
        <select name="jabatan_id" id="jabatan_id" class="form-control text-white" required>
            <option value="">Pilih Jabatan</option>
            <?php $__currentLoopData = $jabatans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jabatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($jabatan->id); ?>"><?php echo e($jabatan->nama_jabatan); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Anggota</button>
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
<?php echo $__env->make( 'components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/digikom/laravel/resources/views/pages/user/create.blade.php ENDPATH**/ ?>