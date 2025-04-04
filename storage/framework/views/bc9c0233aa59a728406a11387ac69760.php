<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peraturan Organisasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .peraturan-container {
            margin: 0 auto;
            max-width: 800px;
        }
        .peraturan-item {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .peraturan-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .peraturan-desc {
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="peraturan-container">
        <?php $__empty_1 = true; $__currentLoopData = $peraturan_organisasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peraturan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="peraturan-item">
                <div class="peraturan-title"><?php echo e($peraturan->judul); ?></div>
                <div class="peraturan-desc"><?php echo e($peraturan->deskripsi); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Tidak ada data peraturan organisasi yang tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH /home/azrayaal/Desktop/codes/digikom/be/resources/views/pages/html/peraturan/index.blade.php ENDPATH**/ ?>