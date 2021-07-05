<?php $__env->startSection('title', '- grafik'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card mt-3">
        <div class="card-header">
            Wybierz sklep
        </div>
        <div class="card-body mx-auto">
            <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="btn btn-primary mb-2" href="<?php echo e(route('scheduler_shop', ['id' => $shop->id])); ?>"><?php echo e($shop->name); ?></a><br/>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/calendar/scheduler/scheduler_admin.blade.php ENDPATH**/ ?>