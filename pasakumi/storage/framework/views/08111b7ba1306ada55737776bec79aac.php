<?php
    use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('content'); ?>
    <h1>Labot pasakumu datus</h1>

    <?php if($errors->any()): ?>
        <div class="flash flash-error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('pasakumi.update', $item->ID)); ?>" method="POST" enctype="multipart/form-data" style="max-width:800px;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Nosaukums:</label>
                <input type="text" name="nosaukums" value="<?php echo e(old('nosaukums', $item->nosaukums)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Kategorija:</label>
                <input type="text" name="kategorija" value="<?php echo e(old('kategorija', $item->kategorija)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
        </div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Datums no:</label>
                <input type="date" name="datums_no" value="<?php echo e(old('datums_no', $item->datums_no)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Datums līdz:</label>
                <input type="date" name="datums_lidz" value="<?php echo e(old('datums_lidz', $item->datums_lidz)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
        </div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Sākuma laiks:</label>
                <input type="time" name="laiks_no" value="<?php echo e(old('laiks_no', $item->laiks_no)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Beigu laiks:</label>
                <input type="time" name="laiks_lidz" value="<?php echo e(old('laiks_lidz', $item->laiks_lidz)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
        </div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Reģistrācijas beigu datums:</label>
                <input type="date" name="registracijas_beigu_datums" value="<?php echo e(old('registracijas_beigu_datums', $item->registracijas_beigu_datums)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Reģistrācijas beigu laiks:</label>
                <input type="time" name="registracijas_beigu_laiks" value="<?php echo e(old('registracijas_beigu_laiks', $item->registracijas_beigu_laiks)); ?>" style="width:90%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>
        </div>
        
        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Apraksts:</label>
            <textarea name="apraksts" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; min-height:80px;"><?php echo e(old('apraksts', $item->apraksts)); ?></textarea>
        </div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Darbinieks:</label>
                <select name="darbinieks_id" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:white;">
                    <option value="">-- izvēlieties darbinieku --</option>
                    <?php $__currentLoopData = $darbinieki; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d->ID); ?>" <?php echo e(old('darbinieks_id', $item->darbinieks_id) == $d->ID ? 'selected' : ''); ?>><?php echo e($d->vards); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-control">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Telpa:</label>
                <select name="telpa_id" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:white;">
                    <option value="">-- izvēlieties telpu --</option>
                    <?php $__currentLoopData = $telpas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->ID); ?>" <?php echo e(old('telpa_id', $item->telpa_id) == $t->ID ? 'selected' : ''); ?>><?php echo e($t->nosaukums); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        
        <!-- Esošie attēli -->
        <?php if($item->images->count() > 0): ?>
            <div style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Esošie attēli:</label>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <?php $__currentLoopData = $item->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="position:relative;">
                            <img src="<?php echo e(Storage::url($image->image_path)); ?>" alt="Attēls" style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                            <form action="<?php echo e(route('pasakumi.deleteImage', [$item->ID, $image->id])); ?>" method="POST" style="position:absolute; top:0; right:0;">
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
        <div style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Pievienot jaunus attēlus (maksimums <?php echo e(10 - $item->images->count()); ?>):</label>
            <input type="file" name="images[]" multiple accept="image/*" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
        </div>
        
        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn" style="background:#4CAF50; color:white; padding:12px 24px; border:none; border-radius:6px; cursor:pointer; font-weight:600;">Atjaunināt</button>
            <a href="<?php echo e(url()->previous()); ?>" class="btn secondary" style="background:#f44336; color:white; padding:12px 24px; border-radius:6px; text-decoration:none; font-weight:600;">Atcelt</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\HERD\pasakumi\resources\views/edit.blade.php ENDPATH**/ ?>