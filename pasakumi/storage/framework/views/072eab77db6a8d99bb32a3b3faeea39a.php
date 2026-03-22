


<?php $__env->startSection('content'); ?>
    <div class="container" style="max-width: 850px; margin-top: 20px;">
        <h1><?php echo e($item->virsraksts); ?></h1>
        <p><strong>Publicēts:</strong> <?php echo e(\Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d')); ?></p>
        <hr>
        <p style="white-space: pre-line;"><?php echo e($item->apraksts); ?></p>

        <div style="margin-top: 30px; display: flex; gap: 12px;">
            <a href="<?php echo e(route('jaunumi.index')); ?>" class="btn secondary">Atpakaļ uz jaunumiem</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/jaunumi/show.blade.php ENDPATH**/ ?>