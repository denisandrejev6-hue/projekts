<?php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="jumbotron bg-light p-5 rounded">
        <h1 class="display-4">Sākumlapa</h1>
        <p class="lead">Jaunākie jaunumi un pasākumi – viss vienuviet.</p>
        <hr class="my-4">
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>3 pēdējie jaunumi</h2>
            <?php $__empty_1 = true; $__currentLoopData = $jaunumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($item->virsraksts); ?></h5>
                        <p class="card-text"><small><?php echo e(\Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d')); ?></small></p>
                        <p class="card-text"><?php echo e($item->apraksts); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>Nav pieejamu jaunumu.</p>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h2>3 pēdējie pasākumi</h2>
            <?php $__empty_1 = true; $__currentLoopData = $pasakumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card mb-3">
                    <?php if($item->images->count() > 0): ?>
                        <img src="<?php echo e(Storage::url($item->images->first()->image_path)); ?>" class="card-img-top" style="max-height:220px; object-fit:cover;" alt="<?php echo e($item->nosaukums); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($item->nosaukums); ?></h5>
                        <p class="card-text"><strong>Datums:</strong> <?php echo e($item->datums_no); ?> - <?php echo e($item->datums_lidz); ?></p>
                        <p class="card-text"><?php echo e(Str::limit($item->apraksts, 180, '...')); ?></p>
                        <a href="<?php echo e(route('pasakumi.show', $item->ID)); ?>" class="btn btn-sm btn-primary">Skatīt detaļas</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>Nav pieejamu pasākumu.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/Home.blade.php ENDPATH**/ ?>