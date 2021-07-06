<?php $__env->startSection('title', '- święta'); ?>

<?php $__env->startSection('content'); ?>
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Święta</h1>

    <div class='input-group col-md-5' style="justify-content: flex-end;">
        <a href="<?php echo e(route('new_holiday')); ?>" class='btn btn-success mb-2'>Dodaj święto</a>
    </div>
</div>

<div class="calendar mx-auto">
        <div class="calendar-header">
            <button class="calendar-header__arrow mr-4" onclick="previous(<?php echo e($month); ?>-1, <?php echo e($year); ?>, 'holidays')"><i class="fa fa-chevron-left"></i></button> 
            <?php echo e($miesiace[$month-1]); ?> <?php echo e($year); ?> 
            <button class="calendar-header__arrow ml-4" onclick="next(<?php echo e($month); ?>+1, <?php echo e($year); ?>, 'holidays')"><i class="fa fa-chevron-right"></i></button>
        </div>

        <div class="calendar-days d-none d-md-flex d-lg-flex">
            <span class="calendar-days">Poniedziałek</span>
            <span class="calendar-days">Wtorek</span>
            <span class="calendar-days">Środa</span>
            <span class="calendar-days">Czwartek</span>
            <span class="calendar-days">Piątek</span>
            <span class="calendar-days">Sobota</span>
            <span class="calendar-days">Niedziela</span>
        </div>
        <div class="calendar-days d-md-none">
            <span class="calendar-days">Pn</span>
            <span class="calendar-days">Wt</span>
            <span class="calendar-days">Śr</span>
            <span class="calendar-days">Czw</span>
            <span class="calendar-days">Pt</span>
            <span class="calendar-days">Sob</span>
            <span class="calendar-days">Nd</span>
        </div>
        <div class="calendar-week">
            <?php for($i=0; $i < ceil((cal_days_in_month(CAL_GREGORIAN, $month, $year) + date('N', strtotime($year."-".$month."-1")))/7)*7; $i++): ?>
                <?php if($i % 7 == 0 && $i > 0): ?>
                    </div>
                    <div class="calendar-week">
                <?php endif; ?>
                <?php $z = str_pad($i-(date('N', strtotime($year."-".$month."-1"))-1)+1, 2, 0, STR_PAD_LEFT);?>

                <?php if(date("N", strtotime($year."-".$month."-".$z)) == 7): ?>
                    <div class='calendar-day calendar-day__sunday'>
                <?php else: ?>
                    <div class='calendar-day'>
                <?php endif; ?>
                    
                    <?php if($z > 0 && $z <= cal_days_in_month(CAL_GREGORIAN, $month, $year)): ?>
                        <span class="calendar-day__num"><?php echo e($z); ?></span>
                        
                        <?php $__currentLoopData = $holidays->where('date', '=', $year."-".$month."-$z"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('holiday', ['id' => $holiday->id])); ?>" class="calendar-event calendar-event__conf" id="e_<?php echo e($holiday->id); ?>" onmouseover="hoverEvent(this.id)" onmouseout="hoverEvent(this.id)">
                                <span class="d-none d-sm-flex"><?php echo e($holiday->name); ?></span>
                                <i class="fa fa-times d-flex d-sm-none"></i>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/calendar/holidays/holidays.blade.php ENDPATH**/ ?>