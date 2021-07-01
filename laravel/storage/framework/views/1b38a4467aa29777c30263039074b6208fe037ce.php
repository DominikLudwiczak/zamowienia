<?php $__env->startSection('title', '- podumowanie'); ?>

<?php $__env->startSection('content'); ?>
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Podsumowania</h1>
        <div class='input-group col-md-5'>
            <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj" autofocus>
        </div>
    </div>
    <table class="table table-responsive-sm table-striped table-hover text-center mx-auto mt-3">
        <thead class="thead-dark">
            <tr>
                <th scope="row">Nazwa</th>
                <th scope="row">Czas pracy (w tym miesiącu)</th>
                <th scope="row">Wykorzystany urlop (w tym miesiącu)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class='table-row' data-href="<?php echo e(route('summary',['id' => $user[3]])); ?>" style="cursor: pointer;">
                    <td><?php echo e($user[0]); ?></td>
                    <td><?php echo e(floor($user[1]/60)); ?> godzin <?php echo e($user[1] - (floor($user[1]/60)*60)); ?> minut</td>
                    <td><?php echo e($user[2]); ?> dni</td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function(){
            function fetch_search(query = '')
            {
                $.ajax({
                    url:"<?php echo e(route('summaries_search')); ?>",
                    method:'GET',
                    data:{query:query},
                    dataType: 'json',
                    success:function(data)
                    {
                        $('tbody').html(data.table_data);
                    }
                });
            }

            $(document).on('input', '#search', function(){
                if($(this).val() == '')
                    window.location.replace("<?php echo e(route('summaries')); ?>");
                var query = $(this).val();
                fetch_search(query);
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/summary/summaries.blade.php ENDPATH**/ ?>