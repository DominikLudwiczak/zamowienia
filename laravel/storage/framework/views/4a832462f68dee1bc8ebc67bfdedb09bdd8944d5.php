<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>zamówienia <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('/js/app.js')); ?>" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='/js/script.js' type='text/javascript'></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="<?php echo e(asset('/css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">Panel zarządzania</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>" onclick="change_sidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Zaloguj się')); ?></a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <hr id='linia' style='display:none;'/>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Wyloguj się')); ?>

                                    </a>

                                    <a class='dropdown-item' href="<?php echo e(route('password.change')); ?>">Zmień hasło</a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php if(auth()->guard()->check()): ?>
            <div class='container-fluid'>
                <div class="row" id='row'>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-left','data' => []]); ?>
<?php $component->withName('nav-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <div class='col' id='content'>
                        <div class="container">
                            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->yieldContent('content'); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <main class='py-4'>
                <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        <?php endif; ?>
    </div>
    
    <script>
        window.onload = changeContentWidth();
        window.onload = active();
        window.addEventListener('resize', changeContentWidth);

        function changeContentWidth()
        {
            var windowWidth = document.getElementById('row').offsetWidth;
            var sidebarWidth = document.getElementById('sidebar').offsetWidth;
            
            document.getElementById('content').style.marginLeft = sidebarWidth+'px';
            document.getElementById('content').style.width = (windowWidth - sidebarWidth)+'px';
        }

        function active()
        {
            var route = "<?php echo e(Route::getCurrentRoute()->getName()); ?>";
            if(route.includes('order'))
                route = 'orders';
            else if(route.includes('employee'))
                route = 'employees';
            else if(route.includes('supplier'))
                route = 'suppliers';
            else if(route.includes('product'))
                route = 'products';
            else if(route.includes('vacatio'))
                route = 'vacations';
            else if(route.includes('request'))
                route = 'requests'
            else if(route.includes('schedule'))
                route = 'scheduler';
            else if(route.includes('shop'))
                route = 'shops';
            else if(route.includes('summa'))
                route = 'summary';
            else
                route = 'dashboard';

            var item = document.getElementById(route);
            if(item)
                item.style.textDecoration = "underline";
        }

        $(document).ready(function(){
            $('.toast').toast('show');
            $('#alert').modal({
                backdrop: 'static', 
                keyboard: false
            });
        });
        
    </script>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/zamowienia/laravel/resources/views/layouts/app.blade.php ENDPATH**/ ?>