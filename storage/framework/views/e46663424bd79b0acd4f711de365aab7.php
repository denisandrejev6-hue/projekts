<?php $__env->startSection('content'); ?>
    <h1>Lietotāja detaļas</h1>

    <p><strong>ID:</strong> <?php echo e($data->ID); ?></p>
    <p><strong>Vārds:</strong> <?php echo e($data->vards); ?></p>
    <p><strong>Uzvārds:</strong> <?php echo e($data->uzvards); ?></p>
    <p><strong>E-pasts:</strong> <?php echo e($data->epasts); ?></p>
    <p><strong>Loma:</strong> <?php echo e($data->loma); ?></p>

    <div style="display:flex; gap:12px; margin-top:24px;">
        <a href="<?php echo e(route('lietotaji.edit', $data->ID)); ?>" class="btn">Rediģēt</a>
        <form action="<?php echo e(route('lietotaji.destroy', $data->ID)); ?>" method="POST" onsubmit="return confirm('Vai tiešām dzēst?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn secondary">Dzēst</button>
        </form>
        <a href="<?php echo e(route('lietotaji.index')); ?>" class="btn secondary">Atpakaļ</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/lietotaji/details.blade.php ENDPATH**/ ?>