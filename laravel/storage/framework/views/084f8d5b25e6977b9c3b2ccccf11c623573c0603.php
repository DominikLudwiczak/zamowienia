<?php $__env->startSection('title', '- święta'); ?>

<?php $__env->startSection('content'); ?>
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-10'>Święta w <?php echo e($year); ?> roku</h1>
    <select class="form-control col" onchange="yearChange(this.value)">
        <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($row == $year): ?>
                <option value='<?php echo e($row); ?>' selected><?php echo e($row); ?></option>
            <?php else: ?>
                <option value='<?php echo e($row); ?>'><?php echo e($row); ?></option>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<form action="<?php echo e(route('new_holiday')); ?>" class='pt-3'>
    <button class='btn btn-success float-right'>Dodaj święto</button>
</form>

<table class="table table-striped table-responsive-sm text-center table-hover">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(isset($_REQUEST['page']))
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        <?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $x++; ?>
            <tr class='table-row' data-href="<?php echo e(route('holiday',['id' => $holiday->id])); ?>" style="cursor: pointer;">
                <th scope="row"><?php echo e($x); ?></th>
                <td><?php echo e($holiday->name); ?></td>
                <td><?php echo e($holiday->date); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<div class='pagination'><?php echo e($holidays->render()); ?></div>
<?php $__env->stopSection(); ?>
<script>
    function yearChange(year)
    {
        location.replace(`/holidays/all/${year}`)
    }
</script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/holidays/holidays.blade.php ENDPATH**/ ?>