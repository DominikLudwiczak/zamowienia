<?php $__env->startSection('title', '- urlopy'); ?>

<?php $__env->startSection('content'); ?>
    <form method='post'>
    <?php echo csrf_field(); ?>
        <div class="col-md-8 mx-auto mt-3">
            <div class="card">
                <div class="card-header">
                    Wniosek o urlop
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <?php if(Gate::allows('admin')): ?>
                        <select name='user' class="custom-select mb-2">
                            <option value="0" default>Pracownik...</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($user->id != old('user')): ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e($user->id); ?>" selected><?php echo e($user->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php endif; ?>

                    <?php 
                        $min = date('Y-m-d', strtotime('+1 day'));
                    ?>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start">Początek:</label>
                            <input type='date' id='start' name='start' class='form-control' value="<?php echo e(old('start')); ?>" <?php if(!Gate::allows('admin')){ echo "min=$min";}?> required/>
                        </div>
                        <div class="col-md-6">
                            <label for="end">Koniec:</label>
                            <input type='date' id='end' name='end' class='form-control' value="<?php echo e(old('end')); ?>" <?php if(!Gate::allows('admin')){ echo "min=$min";}?> required/>
                        </div>
                    </div>
                    
                    <div class="row col float-right">
                        <a href="<?php echo e(route('vacations')); ?>" class='btn btn-primary ml-auto'>Cofnij</a>
                        <button class='btn btn-success ml-2'>Wyślij</button>
                    </div>
                </div>
            </div>
        </div>
        <?php if(session('double')): ?>
            <div class="modal" tabindex="-1" role="dialog" id='alert'>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alert!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if(session('double') === 'proposal' || session('double') === 'vacation'): ?>
                            <div class='alert alert-primary'>Istnieje wniosek o urlop lub urlop, który się pokrywa z twoim wnioskiem, czy pomimo tego wysłać wniosek?</div>
                        <?php elseif(session('double') === 'double'): ?>
                            <div class='alert alert-danger'>Masz już złożony wniosek o urlop w tym terminie, popraw swój wniosek!</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Popraw</button>
                        <?php if(session('double') === 'proposal' || session('double') === 'vacation'): ?>
                            <button class='btn btn-success' name='double' value='true'>Wyślij</button>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/calendar/vacations/add.blade.php ENDPATH**/ ?>