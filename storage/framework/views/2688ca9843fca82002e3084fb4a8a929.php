<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">usaha:</h3>
            <a href="<?php echo e(route('usaha.create')); ?>" class="btn btn-primary">Create New usaha</a>
        </div>
        <div class="col grid-margin stretch-card">
            <div class="card" style="background-color: #2A2A2A;">
                <div class="card-body">
                <div class="mb-4">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                    <form action="<?php echo e(route('usaha.index')); ?>" method="GET" class="">
                        <select name="per_page" onchange="this.form.submit()" class="form-control text-white">
                            <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>Show 10</option>
                            <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>Show 25</option>
                            <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>Show 50</option>
                            <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>Show 100</option>
                        </select>
                    </form>

                    <form action="<?php echo e(route('usaha.index')); ?>" method="GET" class="d-flex align-items-center">
                        <input type="text" name="search" class="form-control" placeholder="Cari usaha..." value="<?php echo e(request('search')); ?>" onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';">
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </form>
                </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-white">
                            <thead>
                                <tr style="background-color: #D1D1D1;">
                                    <th style="color: black;">No</th>
                                    <th style="color: black;">Nama Usaha</th>
                                    <th style="color: black;">Waktu Operational</th>
                                    <th style="color: black;">Lokasi Usaha</th>
                                    <th style="color: black;">Nomor Usaha</th>
                                    <th style="color: black;">Pemilik</th>
                                    <th style="color: black;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $usaha; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr onclick="location.href='<?php echo e(route('usaha.show', $item->id)); ?>'" style="cursor: pointer;">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($item->nama_usaha); ?></td>
                                    <td><?php echo e($item->waktu_operational); ?></td>
                                    <td><?php echo e($item->lokasi_usaha); ?></td>
                                    <td><?php echo e($item->nomor_usaha); ?></td>
                                    <td><?php echo e($item->creator->full_name ?? 'Tidak Ada Jabatan'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('usaha.edit', $item->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="<?php echo e(route('usaha.destroy', $item->id)); ?>" method="POST" style="display: inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus usaha ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                
                <?php if($usaha->isEmpty()): ?>
                <p class="text-center text-muted mt-3">Tidak ada usaha yang tersedia.</p>
                <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($usaha->links('pagination::bootstrap-4')); ?>

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

<?php /**PATH /home/digikom/laravel/resources/views/pages/usaha/index.blade.php ENDPATH**/ ?>