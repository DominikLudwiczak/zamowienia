<?php $__env->startSection('title', '- podumowanie'); ?>

<?php $__env->startSection('content'); ?>
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Podsumowanie - <?php echo e($user->name); ?></h1>
    </div>
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">Praca</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <select id="job_year" class="form-control">
                            <?php $__currentLoopData = $jobYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($year == date('Y', strtotime($job))): ?>
                                    <option selected><?php echo e($year); ?></option>
                                <?php else: ?>
                                    <option><?php echo e($year); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                        <?php
                            $months = ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'];
                        ?>
                    <div class="col-md-5">
                        <select id="job_month" class="form-control">
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(sprintf("%02d", $key+1) == date('m', strtotime($job))): ?>
                                    <option value="<?php echo e(sprintf('%02d', $key+1)); ?>" selected><?php echo e($month); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e(sprintf('%02d', $key+1)); ?>"><?php echo e($month); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col">
                        <button type="button" class="btn btn-success" onclick="change('<?php echo e($user->id); ?>')">Zmień</button>
                    </div>
                </div>

                <input type="text" class="form-control text-center mt-3" value="<?php echo e(floor($jobTime/60)); ?> godzin <?php echo e($jobTime - (floor($jobTime/60)*60)); ?> minut" readonly/> 
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Urlopy</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <select id="vacation_year" class="form-control">
                            <?php $__currentLoopData = $vacationYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($year == date('Y', strtotime($vacation))): ?>
                                    <option selected><?php echo e($year); ?></option>
                                <?php else: ?>
                                    <option><?php echo e($year); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php
                        $months = ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'];
                    ?>
                    <div class="col-md-5">
                        <select id="vacation_month" class="form-control">
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(sprintf("%02d", $key+1) == date('m', strtotime($vacation))): ?>
                                    <option value="<?php echo e(sprintf('%02d', $key+1)); ?>" selected><?php echo e($month); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e(sprintf('%02d', $key+1)); ?>"><?php echo e($month); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col">
                        <button type="button" class="btn btn-success" onclick="change('<?php echo e($user->id); ?>')">Zmień</button>
                    </div>
                </div>
                <input type="text" class="form-control text-center mt-3" value="<?php echo e($vacationTime); ?> dni" readonly/>
            </div>
        </div>

        <?php if(Gate::allows('admin')): ?>
            <a href="<?php echo e(route('summaries')); ?>" class="btn btn-primary mt-3">Cofnij</a>
        <?php endif; ?>
    </div>

    <script>
        function change(user)
        {
            let year = document.getElementById('job_year').value;
            let month = document.getElementById('job_month').value;

            let vacation_year = document.getElementById('vacation_year').value;
            let vacation_month = document.getElementById('vacation_month').value;

            location.href = `/summary/${user}/${year}-${month}/${vacation_year}-${vacation_month}`;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/summary/summary.blade.php ENDPATH**/ ?>