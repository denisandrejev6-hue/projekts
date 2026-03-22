<?php $__env->startSection('content'); ?>
    <h1>Visi Pasakumi</h1>

    <?php if(session('success')): ?>
        <div class="flash flash-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(auth()->user()->loma !== 'Lietotajs'): ?>
        <a href="<?php echo e(route('pasakumi.create')); ?>" class="btn">Pievienot jaunu pasakumu</a>
    <?php endif; ?>

    <?php if(auth()->user()->loma === 'Lietotajs'): ?>
        <div class="client-container" style="margin-top: 16px;">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="client-card">
                    <h3><?php echo e($item->nosaukums); ?></h3>
                    <p><strong>Datums:</strong> <?php echo e($item->datums_no); ?> – <?php echo e($item->datums_lidz); ?></p>
                    <?php
                        $imgFiles = ['img1.jpg', 'img2.jpg', 'img3.jpg'];
                        $imgFile = $imgFiles[$index % count($imgFiles)];
                    ?>
                    <img src="<?php echo e(asset('img/' . $imgFile)); ?>" alt="Pasākuma attēls" style="width:100%;max-width:320px;border-radius:8px;margin-bottom:8px;" />
                    <?php if(!empty($item->apraksts)): ?>
                        <p><?php echo e(\Illuminate\Support\Str::limit($item->apraksts, 120)); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo e(route('pasakumi.show', $item->ID)); ?>" class="btn-detail">Detalizēti</a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <table border="1" cellpadding="12" cellspacing="0" style="margin-top:16px; width:100%; border-collapse:collapse; table-layout:auto;">
            <colgroup>
                <col style="width:40%;">
                <col style="width:25%;">
                <col style="width:20%;">
            </colgroup>
            <thead>
                <tr>
                    <th style="text-align:center;">Nosaukums</th>
                    <th style="text-align:center;">Sākuma datums</th>
                    <th style="text-align:center;">Beigu datums</th>
                    <th style="text-align:center;">Sākuma laiks</th>
                    <th style="text-align:center;">Beigu laiks</th>
                    <th style="text-align:center;">Apraksts</th>
                    <th style="text-align:center;">Atbildīga persona</th>
                    <th style="text-align:center;">Telpa </th>
                    <th style="text-align:center;">Darbības</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="text-align:center;"><?php echo e($item->nosaukums); ?></td>
                        <td style="text-align:center;"><?php echo e($item->datums_no); ?></td>
                        <td style="text-align:center;"><?php echo e($item->datums_lidz); ?></td>
                        <td style="text-align:center;"><?php echo e($item->sakuma_laiks); ?></td>
                        <td style="text-align:center;"><?php echo e($item->beigu_laiks); ?></td>
                        <td style="text-align:center;"><?php echo e($item->apraksts); ?></td>
                        <td style="text-align:center;"><?php echo e($item->darbinieks->vards ?? 'Nav norādīts'); ?></td>
                        <td style="text-align:center;"><?php echo e($item->telpa->nosaukums ?? 'Nav norādīta'); ?></td>
                        <td style="text-align:center;">
                            <div style="display:flex; gap:8px; justify-content:center; align-items:center;">
                                <a href="<?php echo e(route('pasakumi.edit', $item->ID)); ?>" class="btn edit">Rediģēt</a>
                                <form action="<?php echo e(route('pasakumi.destroy', $item->ID)); ?>" method="POST" style="margin:0;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn delete" onclick="return confirm('Vai tiešām dzēst šo pasakumu?')">Dzēst</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/alldata.blade.php ENDPATH**/ ?>