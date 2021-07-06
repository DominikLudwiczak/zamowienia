<?php $__env->startSection('title', '- pracownicy'); ?>

<?php $__env->startSection('content'); ?>
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Edycja pracownika</h1>
    <div class='col-md-8 offset-md-2'>
        <div class='card'>
            <div class='card-header'>
                Edycja pracownika
            </div>
            <div class='card-body'>
                <form method="post" class='col-md-6 offset-md-3'>
                <?php echo csrf_field(); ?>
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa pracownika" name="nazwa" value="<?php echo e($user->name); ?>" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">E-mail</span>
                        </div>
                        <input type="email" class="form-control" placeholder="E-mail pracownika" name="email" value="<?php echo e($user->email); ?>" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Stawka podstawowa</span>
                        </div>
                        <input type="number" class="form-control" name="base_sallary" placeholder="stawka" min="0" step="0.01" value="<?php echo e($user->base_sallary); ?>" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Stawka dodatkowa</span>
                        </div>
                        <input type="number" class="form-control" name="extended_sallary" placeholder="stawka" min="0" step="0.01" value="<?php echo e($user->extended_sallary); ?>" required>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="vaction_active" name="vacation_active" <?php if($user->vacation_active == 1){ echo "checked";} ?>>
                        <label class="form-check-label" for="vacation_active">Urlopy</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active" <?php if($user->active == 1){ echo "checked";} ?>>
                        <label class="form-check-label" for="active">Aktywny</label>
                    </div>

                    <!-- <?php if($user->email_verified_at == null): ?>
                        <hr/>
                            <div class="text-center">
                                <p class="text-danger">Ten użytkownik nie ma potwierdzonego adresu email! Czy wysłać jeszcze raz email z linkiem 
                                do aktywacji konta?</p>
                                <button class='btn btn-primary' form="" data-target="#danger" data-toggle="modal">Wyślij</button>
                            </div>
                        <hr/>
                    <?php endif; ?> -->
                    
                    <button class='btn btn-success float-right ml-2'>Zapisz</button>
                    <a href="<?php echo e(route('employees_admin')); ?>" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>

    <!-- modal danger -->
        <!-- <form method="post" action="<?php echo e(route('employee_resend', ['id' => $user->id])); ?>">
        <?php echo csrf_field(); ?>
            <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="danger" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UWAGA!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        Ta wiadomość email wyśle się tylko wtedy, gdy czas na aktywację konta upłynął!
                    </div>
                    <div class="modal-footer">
                        <button href="#" class='btn btn-success'>Wyślij</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
                    </div>
                    </div>
                </div>
            </div>
        </form> -->
    <!-- end modal -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/employees/edit.blade.php ENDPATH**/ ?>