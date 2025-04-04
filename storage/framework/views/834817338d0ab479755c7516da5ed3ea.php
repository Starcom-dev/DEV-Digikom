<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" style="background-color: #D1D1D1;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="card-title text-black">Laporan Iuran:</h3>
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
                    <div class="mb-4">
                        <form action="<?php echo e(route('iuran.tagihan')); ?>" method="GET" class="d-flex justify-content-between">
                            <div class="d-flex">
                                <select name="year" class="form-control text-white" onchange="this.form.submit()">
                                    <option value="" style>-- Select Year --</option>
                                    <option value="2023" <?php echo e(request('year') == '2023' ? 'selected' : ''); ?>>2023</option>
                                    <option value="2024" <?php echo e(request('year') == '2024' ? 'selected' : ''); ?>>2024</option>
                                </select>

                                <select name="month" class="form-control ml-2 text-white" onchange="this.form.submit()">
                                    <option value="">-- Select Month --</option>
                                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($month); ?>" <?php echo e(request('month') == $month ? 'selected' : ''); ?>><?php echo e(\Carbon\Carbon::create()->month($month)->format('F')); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <select name="user_id" class="form-control ml-2 text-white" onchange="this.form.submit()">
                                    <option value="">-- Select User --</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>><?php echo e($user->full_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Hanya tampilkan tabel jika ada pencarian -->
                    <?php if(request()->has('year') || request()->has('month') || request()->has('user_id')): ?>
                        <?php if($iuran->count()): ?>
                            <table class="table table-hover text-white">
                                <thead>
                                    <tr style="background-color: #D1D1D1;">
                                        <th style="color: black;">No</th>
                                        <th style="color: black;">No Anggota</th>
                                        <th style="color: black;">Nama Anggota</th>
                                        <th style="color: black;">Jumlah</th>
                                        <th style="color: black;">Keterangan</th>
                                        <th style="color: black;">Tahun</th>
                                        <th style="color: black;">Status</th>
                                        <th style="color: black;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $iuran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr onclick="location.href='<?php echo e(route('tagihan.show', $item->id)); ?>'" style="cursor: pointer;">
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->users->phone_number); ?></td>
                                            <td><?php echo e($item->users->full_name); ?></td>
                                            <td>Rp. <?php echo e(number_format($item->nominal, 0, ',', '.')); ?></td>
                                            <td><?php echo e($item->keterangan); ?></td>
                                            <td><?php echo e($item->iuran->tahun); ?></td>
                                            <td><?php echo e($item->status); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('iuran.show', $item->id)); ?>" class="btn btn-sm btn-warning">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-center text-muted mt-3">Tidak ada iuran yang sesuai dengan pencarian.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-center text-muted mt-3">Silakan pilih filter untuk menampilkan data.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <?php if(request()->has('year') || request()->has('month') || request()->has('user_id')): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($iuran->links('pagination::bootstrap-4')); ?>

            </div>
        <?php endif; ?>
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
<?php /**PATH /home/azrayaal/Downloads/digikom/be/resources/views/pages/iuran/laporan.blade.php ENDPATH**/ ?>