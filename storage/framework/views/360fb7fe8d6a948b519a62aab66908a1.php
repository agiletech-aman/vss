<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="CWC Admin Dashboard" name="description" />
    <meta content="Ayush Vahane" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="shortcut icon" href="<?php echo e(asset('backends/assets/images/cwc-log.jpg')); ?>">

    <!-- Upcube Core Styles -->
    <link href="<?php echo e(asset('backends/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('backends/assets/css/icons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('backends/assets/css/app.min.css')); ?>" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* Small visual tweaks */
        .page-title-box h4 {
            font-weight: 600;
        }
        .main-content {
            min-height: 100vh;
        }
        .form-select{
            text-transform: uppercase;
        }
    </style>
</head>

<body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        
        <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php echo $__env->make('layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!--  Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            
            <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- End Main Content -->

    </div>
    <!-- END layout-wrapper -->

    <!-- JS -->
    <script src="<?php echo e(asset('backends/assets/libs/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backends/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backends/assets/libs/metismenu/metisMenu.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backends/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backends/assets/libs/node-waves/waves.min.js')); ?>"></script>

    <!-- Page specific scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script src="<?php echo e(asset('backends/assets/js/app.js')); ?>"></script>
<?php echo $__env->make('partials.chatbot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>


<?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views/layout/master.blade.php ENDPATH**/ ?>