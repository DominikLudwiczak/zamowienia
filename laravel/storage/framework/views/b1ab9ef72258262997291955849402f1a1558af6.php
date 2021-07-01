<?php $__env->startSection('title', '- zamówienia'); ?>

<?php $__env->startSection('content'); ?>
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Zamówienia</h1>
    <div class='input-group col-md-5'>
        <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj" autofocus>
    </div>
</div>
<form action="<?php echo e(route('new_order', ['supplier_name' => session('supplier')->name ?? ''])); ?>" class='pt-3'>
    <button class='btn btn-success float-right'>Stwórz nowe</button>
</form>

<table class="table table-striped table-responsive-sm text-center table-hover">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Dostawca</th>
            <th scope="col">Składający</th>
            <th scope="col">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($_REQUEST)
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $x++; ?>
            <tr class='table-row' data-href="<?php echo e(route('order_details',['order_id' => $order->order_id])); ?>">
                <th scope="row"><?php echo e($x); ?></th>
                <td><?php echo e($order->supplier); ?></td>
                <td><?php echo e($order->user); ?></td>
                <td><?php echo e(Carbon\Carbon::parse($order->created_at)->diffForHumans()); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<div class='pagination'><?php echo e($orders->render()); ?></div>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        function fetch_search(query = '')
        {
            $.ajax({
                url:"<?php echo e(route('orders_search')); ?>",
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
                window.location.replace("<?php echo e(route('orders')); ?>");
            var query = $(this).val();
            fetch_search(query);
        });

        $(document).on('click', '.table-row', function(){
            window.document.location = $(this).data("href");
        });
    });
</script>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/orders/orders.blade.php ENDPATH**/ ?>