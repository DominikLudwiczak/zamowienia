<?php $__env->startSection('title', '- wnioski'); ?>

<?php $__env->startSection('content'); ?>
    <div class='row align-items-center pt-3 pb-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Wnioski urlopowe</h1>
        <div class='input-group col-md-5'>
            <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj" autofocus>
        </div>
    </div>

    <table class="table table-striped table-responsive-sm text-center table-hover">
        <thead class='thead-dark'>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Pracownik</th>
                <th scope="col">Początek</th>
                <th scope="col">Koniec</th>
                <th scope="col">Data złożenia</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(isset($_REQUEST['page']))
                    $x = $_REQUEST['page']*15-15; 
                else
                    $x=0;
            ?>
            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $x++; ?>
                <tr class='table-row table-row__hover' data-href="<?php echo e(route('request', ['id' => $request->id])); ?>">
                    <th scope="row"><?php echo e($x); ?></th>
                    <td><?php echo e($users->where('id', $request->user_id)->first()->name); ?></td>
                    <td><?php echo e($request->start); ?></td>
                    <td><?php echo e($request->end); ?></td>
                    <td><?php echo e(Carbon\Carbon::parse($request->created_at)->diffForHumans()); ?></td>
                    <?php if($request->confirmed == -1): ?>
                        <td style="background-color: red; color: white;">odrzucony</td>
                    <?php elseif($request->confirmed == 0): ?>
                        <td style="background-color: #209DFC; color: white;">do rozpatrzenia</td>
                    <?php else: ?>
                        <td style="background-color: #00DC60; color: white;">przyjęty</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class='pagination'><?php echo e($requests->render()); ?></div>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        function fetch_search(query = '')
        {
            $.ajax({
                url:"<?php echo e(route('requests_search')); ?>",
                method:'GET',
                data:{query:query},
                dataType: 'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    $('#pagination').hide();
                }
            });
        }
        $(document).on('input', '#search', function(){
            if($(this).val() == '')
                window.location.replace("<?php echo e(route('requests')); ?>");
            var query = $(this).val();
            fetch_search(query);
        });
    });
</script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/calendar/requests/requests.blade.php ENDPATH**/ ?>