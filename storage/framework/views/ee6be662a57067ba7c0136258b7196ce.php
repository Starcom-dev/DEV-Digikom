<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
<!-- partial -->
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Pendaftar:</h3>
        </div>
      	<?php if(session('success')): ?>
      	<div class="col stretch-card">
          <div class="alert alert-success" role="alert">
            <?php echo e(session('success')); ?>

          </div>
      	</div>
      	<?php endif; ?>
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <form action="<?php echo e(route('anggota.index')); ?>" method="GET" class="">
                                <select name="per_page" onchange="this.form.submit()" class="form-control text-white">
                                    <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>Show 10</option>
                                    <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>Show 25</option>
                                    <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>Show 50</option>
                                    <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>Show 100</option>
                                </select>
                            </form>

                            <form action="<?php echo e(route('anggota.index')); ?>" method="GET" class="d-flex align-items-center">
                                <input type="text" name="search" class="form-control" placeholder="Cari pendaftar..." value="<?php echo e(request('search')); ?>" onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';">
                                <button type="submit" class="btn btn-primary ml-2">Search</button>
                            </form>
                        </div>

                        <!-- Wrap table with a div to make it horizontally scrollable if needed -->
                        <div class="table-responsive">
                            <table class="table table-hover text-white">
                                <thead>
                                    <tr style="background-color: #D1D1D1;">
                                        <th style="color: black;">No</th>
                                        <th style="color: black;">Profile</th>
                                        <th style="color: black;">Nama Lengkap</th>
                                        <th style="color: black;">Email</th>
                                        <th style="color: black;">Nomor Telpon</th>
                                        <th style="color: black;">Jabatan</th>
                                        <th style="color: black;">Status</th>
                                        <th style="color: black;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr onclick="location.href='<?php echo e(route('pendaftar.show', ['user' => $item->id])); ?>'" style="cursor: pointer;">
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td>
                                            <img src="<?php echo e(asset('storage/' . $item->profile_picture)); ?>" alt="" style="width: 50px; height: 50px;">
                                        </td>
                                        <td><?php echo e($item->full_name); ?></td>
                                        <td><?php echo e($item->email); ?></td>
                                        <td><?php echo e($item->phone_number); ?></td>
                                        <td><?php echo e($item->creator->nama_jabatan ?? 'Tidak Ada Jabatan'); ?></td>
                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>
                                        <td>
                                            <form action="<?php echo e(route('update_pendaftar', ['id' => $item->id, 'status' => 'approve'])); ?>" method="POST" style="display: inline-block;">
                                                <?php echo csrf_field(); ?>
                                              	<?php echo method_field('PUT'); ?>
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Apakah Anda yakin ingin approve pendaftar ini?')">
                                                    	Approve
                                                </button>
                                            </form>

                                            <form action="<?php echo e(route('update_pendaftar', ['id' => $item->id, 'status' => 'reject'])); ?>" method="POST" style="display: inline-block;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if($user->isEmpty()): ?>
                        <p class="text-center text-muted mt-3">Tidak ada user yang tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($user->links('pagination::bootstrap-4')); ?>

    </div>
    
    <!-- Footer -->
    <footer class="footer" style="background-color: #2A2A2A; padding: 10px 0;">
        <div class="container text-center">
            <span class="text-muted d-block text-white">Copyright © digikom.com <?php echo e(date('Y')); ?></span>
            <span class="text-muted d-block text-white">All Rights Reserved</span>
        </div>
    </footer>
</div>


<?php /**PATH /home/digikom.xyz/laravel/resources/views/pages/register/index.blade.php ENDPATH**/ ?>