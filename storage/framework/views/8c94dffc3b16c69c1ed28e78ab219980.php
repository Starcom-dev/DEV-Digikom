<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <button onclick="window.location.href='<?php echo e(route('anggota.index')); ?>'" class="btn btn-primary">
                ← Kembali ke Daftar Anggota
            </button>
        </div>

        <!-- Konten Utama -->
        <div class="card" style="background-color: #2A2A2A; border-radius: 10px;">
            <div class="card-body">
                <div class="row">
                    <!-- Profile Picture -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Foto Profil</h5>
                        <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" alt="Profile Picture" class="img-fluid" style="max-width: 200px; border-radius: 8px;">
                    </div>
                    <!-- Info anggota -->
                    <div class="col-md-4">
                        <h5 class="text-muted fw-bold">Detail Anggota</h5>
                        <p class="text-white"><strong>Nama Anggota:</strong> <?php echo e($user->full_name); ?></p>
                        <p class="text-white"><strong>Email:</strong> <?php echo e($user->email); ?></p>
                        <p class="text-white"><strong>Nomor Telepon:</strong> <?php echo e($user->phone_number); ?></p>
                        <p class="text-white"><strong>Jabatan:</strong> <?php echo e($user->creator->nama_jabatan ?? 'Tidak Ada Jabatan'); ?></p>
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

<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/digikom/laravel/resources/views/pages/user/show.blade.php ENDPATH**/ ?>