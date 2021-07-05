<?php $__env->startSection('title', '- dodaj święto'); ?>

<?php $__env->startSection('content'); ?>
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Dodaj święto</h1>
    <div class="col-md-8 mx-auto">
        <form method="post">
        <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-header">święto</div>
                <div class="card-body">
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa święta</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa święta" name="name" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Data</span>
                        </div>
                        <input type="date" class="form-control" placeholder="Data" name="date" required>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="<?php echo e(route('holidays')); ?>" class="btn btn-primary">Cofnij</a>
                <button type="submit" class="btn btn-success">Dodaj</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/calendar/holidays/new.blade.php ENDPATH**/ ?>