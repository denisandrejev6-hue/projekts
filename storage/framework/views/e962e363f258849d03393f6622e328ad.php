

<?php
    use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('content'); ?>
    <h1>Rediģēt ziņu</h1>

    <?php if($errors->any()): ?>
        <div class="flash flash-error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('jaunumi.update', $item->id)); ?>" method="POST" enctype="multipart/form-data" style="max-width:600px;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Virsraksts:</label>
            <input type="text" name="virsraksts" value="<?php echo e(old('virsraksts', $item->virsraksts)); ?>" style="width:100%; padding:10px; border-radius:6px;">
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Saturs:</label>
            <textarea name="apraksts" style="width:100%; padding:10px; border-radius:6px; min-height:200px;"><?php echo e(old('apraksts', $item->apraksts)); ?></textarea>
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Publicēšanas datums:</label>
            <input type="date" name="publicets_datums" value="<?php echo e(old('publicets_datums', $item->publicets_datums)); ?>" style="width:100%; padding:10px; border-radius:6px;">
        </div>

        <!-- Esošie attēli -->
        <?php if($item->images->count() > 0): ?>
            <div style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Esošie attēli:</label>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <?php $__currentLoopData = $item->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="position:relative;">
                            <img src="<?php echo e(Storage::url($image->image_path)); ?>" alt="Attēls" style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                            <form action="<?php echo e(route('jaunumi.deleteImage', [$item->id, $image->id])); ?>" method="POST" style="position:absolute; top:0; right:0;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;" onclick="return confirm('Vai tiešām vēlaties dzēst šo attēlu?')">×</button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Jauni attēli -->
        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Pievienot jaunus attēlus (maksimums <?php echo e(10 - $item->images->count()); ?>):</label>
            <input type="file" name="images[]" multiple accept="image/*" style="width:100%; padding:10px; border-radius:6px;">
            <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color: red;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color: red;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn">Saglabāt</button>
            <a href="<?php echo e(route('jaunumi.index')); ?>" class="btn secondary">Atcelt</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/jaunumi/edit.blade.php ENDPATH**/ ?>