<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Kategoriju saraksts</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
            <a href="<?php echo e(route('kategorijas.create')); ?>" class="btn btn-primary">Pievienot jaunu kategoriju</a>
        <?php endif; ?>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nosaukums</th>
                    <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
                        <th>Darbības</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($item->nosaukums); ?></td>
                        <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
                            <td>
                                <a href="<?php echo e(route('kategorijas.edit', $item->ID)); ?>" class="btn btn-sm btn-warning">Rediģēt</a>
                                <form action="<?php echo e(route('kategorijas.destroy', $item->ID)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Vai tiešām vēlaties dzēst šo kategoriju?')">Dzēst</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" class="text-center">Nav pievienotu kategoriju</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/kategorijas/index.blade.php ENDPATH**/ ?>