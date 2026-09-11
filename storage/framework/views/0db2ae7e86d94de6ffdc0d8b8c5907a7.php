<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Dashboard | Admin & Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(asset('backends/assets/images/favicon.ico')); ?>">
     <!-- <?php echo e(asset('backends/')); ?> -->
        <!-- jquery.vectormap css -->
        <link href="<?php echo e(asset('backends/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')); ?>" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="<?php echo e(asset('backends/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="<?php echo e(asset('backends/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="<?php echo e(asset('backends/assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo e(asset('backends/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo e(asset('backends/assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
<div id="layout-wrapper">


<header id="page-topbar">
<div class="navbar-header">
<div class="d-flex">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(asset('backends/assets/images/logo-sm.png')); ?>" alt="logo-sm" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('backends/assets/images/logo-dark.png')); ?>" alt="logo-dark" height="20">
            </span>
        </a>

    <a href="index.html" class="logo logo-light">
        <span class="logo-sm">
            <img src="<?php echo e(asset('backends/assets/images/logo-sm.png')); ?>" alt="logo-sm-light" height="22">
        </span>
        <span class="logo-lg">
            <img src="<?php echo e(asset('backends/assets/images/logo-light.png')); ?>" alt="logo-light" height="20">
        </span>
    </a>
</div>

        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
            <i class="ri-menu-2-line align-middle"></i>
        </button>

        <!-- App Search-->
<div class="dropdown d-inline-block user-dropdown">
<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img class="rounded-circle header-profile-user" src="<?php echo e(asset('backends/assets/images/users/avatar-1.jpg')); ?>"
        alt="Header Avatar">
    <span class="d-none d-xl-inline-block ms-1">Admin</span>
    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
</button>
<div class="dropdown-menu dropdown-menu-end">
    <!-- item-->
    <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
    <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a>
    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
    <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-danger" href="<?php echo e(route('admin.logout')); ?>"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
</div>
</div>

</div>
</div>

</div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

<div data-simplebar class="h-100">

<!-- User details -->


<!--- Sidemenu -->

<?php echo $__env->make('admin.body.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->



<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
<h4 class="mb-sm-0">Dashboard</h4>

<div class="page-title-right">
<ol class="breadcrumb m-0">

<li class="breadcrumb-item active">Dashboard</li>
</ol>
</div>

</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-body">
<div class="d-flex">
<div class="flex-grow-1">
<p class="text-truncate font-size-14 mb-2">Region</p>
<h4 class="mb-2">1452</h4>
<p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>view all</span></p>
</div>
<div class="avatar-sm">
<span class="avatar-title bg-light text-primary rounded-3">
<i class="ri-shopping-cart-2-line font-size-24"></i>  
</span>
</div>
</div>                                            
</div><!-- end cardbody -->
</div><!-- end card -->
</div><!-- end col -->
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-body">
<div class="d-flex">
<div class="flex-grow-1">
            <p class="text-truncate font-size-14 mb-2">Warehouse</p>
            <h4 class="mb-2">938</h4>
            <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>view all</span></p>
</div>
<div class="avatar-sm">
<span class="avatar-title bg-light text-success rounded-3">
<i class="mdi mdi-currency-usd font-size-24"></i>  
</span>
</div>
</div>                                              
</div><!-- end cardbody -->
</div><!-- end card -->
</div><!-- end col -->
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-body">
<div class="d-flex">
<div class="flex-grow-1">
<p class="text-truncate font-size-14 mb-2">New Users</p>
<h4 class="mb-2">8246</h4>
<p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p>
</div>
<div class="avatar-sm">
<span class="avatar-title bg-light text-primary rounded-3">
<i class="ri-user-3-line font-size-24"></i>  
</span>
</div>
</div>                                              
</div><!-- end cardbody -->
</div><!-- end card -->
</div><!-- end col -->
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-body">
<div class="d-flex">
<div class="flex-grow-1">
<p class="text-truncate font-size-14 mb-2">Unique Visitors</p>
<h4 class="mb-2">29670</h4>
<p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p>
</div>
<div class="avatar-sm">
<span class="avatar-title bg-light text-success rounded-3">
<i class="mdi mdi-currency-btc font-size-24"></i>  
</span>
</div>
</div>                                              
</div><!-- end cardbody -->
</div><!-- end card -->
</div><!-- end col -->
</div><!-- end row -->



<!-- end col -->

<!-- End Page-content -->

<footer class="footer">
<div class="container-fluid">
<div class="row">
<div class="col-sm-6">
<script>document.write(new Date().getFullYear())</script> © Upcube.
</div>
<div class="col-sm-6">

</div>
</div>
</div>
</footer>

</div>
<!-- end main content-->


<!-- END layout-wrapper -->

<!-- Right Sidebar -->


<!-- Settings -->
<!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="<?php echo e(asset('backends/assets/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/metismenu/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/node-waves/waves.min.js')); ?>"></script>


<!-- apexcharts -->
<script src="<?php echo e(asset('backends/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>

<!-- jquery.vectormap map -->
<script src="<?php echo e(asset('backends/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')); ?>"></script>

<!-- Required datatable js -->
<script src="<?php echo e(asset('backends/assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>

<!-- Responsive examples -->
<script src="<?php echo e(asset('backends/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('backends/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>"></script>

<script src="<?php echo e(asset('backends/assets/js/pages/dashboard.init.js')); ?>"></script>

<!-- App js -->
<script src="<?php echo e(asset('backends/assets/js/app.js')); ?>"></script>
</body>

</html><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\admin_master.blade.php ENDPATH**/ ?>