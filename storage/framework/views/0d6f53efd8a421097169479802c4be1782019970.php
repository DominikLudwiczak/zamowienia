
<?php if(count($errors) > 0): ?>
    <div class='mt-2' style="position: absolute; right: 10%; z-index:9999;">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px; margin:0;">
            <div style="position: absolute; top: 0; right: 0; z-index:2;">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" type='info' data-delay="3000" style="min-width:15rem;">
                    <div class="toast-header text-white" style='background-color: #d30303;'>
                        <strong class="mr-auto">Błąd!</strong>
                    </div>
                    <div class="toast-body">
                        <?php echo e($error); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div aria-live="polite" aria-atomic="true" style="position: absolute; min-height: 200px; right: 10%; z-index:9999;" class="mt-2">
        <div style="position: absolute; top: 0; right: 0; z-index:2;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" type='info' data-delay="3000" style="min-width:15rem;">
                <div class="toast-header text-white" style='background-color: #00991e;'>
                    <strong class="mr-auto">Gratulacje!</strong>
                </div>
                <div class="toast-body">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(session('failed')): ?>
    <div aria-live="polite" aria-atomic="true" style="position: absolute; min-height: 200px; right: 10%; z-index:9999;" class="mt-2">
        <div style="position: absolute; top: 0; right: 0; z-index:2;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" type='info' data-delay="3000" style="min-width:15rem;">
                <div class="toast-header text-white" style='background-color: #d30303;'>
                    <strong class="mr-auto">Błąd!</strong>
                </div>
                <div class="toast-body">
                    <?php echo e(session('failed')); ?>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/includes/messages.blade.php ENDPATH**/ ?>