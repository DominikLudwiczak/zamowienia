<?php $__env->startSection('title', '- święto'); ?>

<?php $__env->startSection('content'); ?>
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Edycja święta</h1>
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
                        <input type="text" class="form-control" placeholder="Nazwa święta" name="name" value="<?php echo e($holiday->name); ?>" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Data</span>
                        </div>
                        <input type="date" class="form-control" placeholder="Data" name="date" value="<?php echo e($holiday->date); ?>" required>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="<?php echo e(route('holidays')); ?>" class="btn btn-primary">Cofnij</a>
                <button type="submit" class="btn btn-success">Zapisz</button>
                <button type="button" class="btn btn-danger" data-target="#delete" data-toggle="modal">Usuń</button>
            </div>
        </form>
    </div>


    <!-- modal -->
    <form method="post" action="<?php echo e(route('delete_holiday')); ?>">
    <?php echo csrf_field(); ?>
        <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Czy na pewno chcesz usunąć to święto?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    Usunięcie tego święta spowoduje zmienę dni pracujących!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button class="btn btn-danger" name='id' value="<?php echo e($holiday->id); ?>" id='delete_button'>Usuń</button>
                </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end modal -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/holidays/holiday.blade.php ENDPATH**/ ?>