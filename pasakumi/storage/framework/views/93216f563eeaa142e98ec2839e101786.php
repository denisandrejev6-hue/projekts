


<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Jaunumi</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
            <a href="<?php echo e(route('jaunumi.create')); ?>" class="btn btn-primary">Pievienot jaunu ziņu</a>
        <?php endif; ?>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Virsraksts</th>
                    <th>Publicēts</th>
                    <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
                        <th>Darbības</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($item->virsraksts); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d')); ?></td>
                        <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
                            <td>
                                <a href="<?php echo e(route('jaunumi.edit', $item->id)); ?>" class="btn btn-sm btn-warning">Rediģēt</a>
                                <form action="<?php echo e(route('jaunumi.destroy', $item->id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Vai tiešām vēlaties dzēst šo ziņu?')">Dzēst</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center">Nav pievienotu jaunumu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/jaunumi/index.blade.php ENDPATH**/ ?>