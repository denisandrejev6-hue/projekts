<?php $__env->startSection('content'); ?>
    <h1>Rediģēt lietotāju</h1>

    <?php if($errors->any()): ?>
        <div class="flash flash-error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('lietotaji.update', $data->ID)); ?>" method="POST" style="max-width:500px;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Vārds:</label>
            <input type="text" name="vards" value="<?php echo e(old('vards', $data->vards)); ?>" style="width:90%; padding:10px; border-radius:6px;">
        </div>

            <div class="form-control" style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Uzvārds:</label>
                <input type="text" name="uzvards" value="<?php echo e(old('uzvards', $data->uzvards)); ?>" style="width:90%; padding:10px; border-radius:6px;">
            </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">E-pasts:</label>
            <input type="email" name="epasts" value="<?php echo e(old('epasts', $data->epasts)); ?>" style="width:90%; padding:10px; border-radius:6px;">
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Parole (atstāt tukšu, lai nemainīt):</label>
            <input type="password" name="parole" style="width:90%; padding:10px; border-radius:6px;">
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Loma:</label>
            <select name="loma" style="width:90%; padding:10px; border-radius:6px;">
                <option value="">-- izvēlēties --</option>
                <?php if(auth()->user()->loma === 'Admin'): ?>
                    <option value="Admin" <?php echo e(old('loma', $data->loma)=='Admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="Darbinieks" <?php echo e(old('loma', $data->loma)=='Darbinieks' ? 'selected' : ''); ?>>Darbinieks</option>
                <?php endif; ?>
                <option value="Lietotajs" <?php echo e(old('loma', $data->loma)=='Lietotajs' ? 'selected' : ''); ?>>Lietotājs</option>
            </select>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn">Saglabāt</button>
            <a href="<?php echo e(route('lietotaji.index')); ?>" class="btn secondary">Atcelt</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/lietotaji/edit.blade.php ENDPATH**/ ?>