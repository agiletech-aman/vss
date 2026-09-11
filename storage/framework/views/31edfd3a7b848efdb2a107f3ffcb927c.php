<?php
    $user = auth()->user();

    $canViewDashboard     = $user->can('view_dashboard');
    $canViewRegions       = $user->can('view_regions');
    $canManageRegions     = $user->can('manage_regions');
    $canViewWarehouses    = $user->can('view_warehouses');
    $canManageWarehouses  = $user->can('manage_warehouses');
    $canViewReports       = $user->can('view_reports');
    $isSuperAdmin         = $user->hasRole('superadmin');

    $currentRoute = request()->route()->getName() ?? '';
    $nmsActive    = str_starts_with($currentRoute, 'nms.pages.');
?>

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Main Menu</li>

                
                <?php if($canViewDashboard): ?>
                <li>
                    <a href="<?php echo e(route('dashboard')); ?>" class="waves-effect">
                        <i class="ri-dashboard-line text-primary"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php endif; ?>

                
                <li class="<?php echo e($nmsActive ? 'mm-active' : ''); ?>">
                    <a href="javascript:void(0);" class="has-arrow waves-effect <?php echo e($nmsActive ? 'active' : ''); ?>">
                        <i class="ri-router-line text-danger"></i>
                        <span>NMS</span>
                    </a>
                    <ul class="sub-menu <?php echo e($nmsActive ? 'mm-show' : ''); ?>">
                        <li class="<?php echo e($currentRoute === 'nms.pages.dashboard' ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('nms.pages.dashboard')); ?>" class="<?php echo e($currentRoute === 'nms.pages.dashboard' ? 'active' : ''); ?>">
                                <i class="ri-dashboard-3-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="<?php echo e(str_starts_with($currentRoute, 'nms.pages.warehouse') || str_starts_with($currentRoute, 'nms.pages.region') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('nms.pages.warehouses')); ?>" class="<?php echo e(str_starts_with($currentRoute, 'nms.pages.warehouse') || str_starts_with($currentRoute, 'nms.pages.region') ? 'active' : ''); ?>">
                                <i class="ri-building-2-line"></i> Warehouses
                            </a>
                        </li>
                        <li class="<?php echo e($currentRoute === 'nms.pages.map' ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('nms.pages.map')); ?>" class="<?php echo e($currentRoute === 'nms.pages.map' ? 'active' : ''); ?>">
                                <i class="ri-map-pin-2-line"></i> Live Map
                            </a>
                        </li>
                        <li class="<?php echo e($currentRoute === 'nms.pages.poll-history' ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('nms.pages.poll-history')); ?>" class="<?php echo e($currentRoute === 'nms.pages.poll-history' ? 'active' : ''); ?>">
                                <i class="ri-history-line"></i> Poll History
                            </a>
                        </li>
                    </ul>
                </li>

                
                <?php if($canViewReports): ?>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-fire-line text-danger"></i>
                        <span>Fire & Smoke</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo e(route('alerts.fire')); ?>">Fire</a></li>
                        <li><a href="<?php echo e(route('alerts.smoke')); ?>">Smoke</a></li>
                        <li><a href="<?php echo e(route('alerts.rodent')); ?>">Rodent</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                
                <?php if($canViewReports): ?>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-search-line"></i>
                        <span>FRS & Bag Counting</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo e(route('frs.logs')); ?>">FRS</a></li>
                        <li><a href="<?php echo e(route('sack.count')); ?>">Bag Counting</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-cpu-line text-info"></i>
                        <span>IOT</span>
                    </a>
                    <ul class="sub-menu">
                        <!-- <li><a href="<?php echo e(route('alerts.index', ['deviceTypeId' => 30000])); ?>">CO₂ Alerts</a></li>
                        <li><a href="<?php echo e(route('alerts.index', ['deviceTypeId' => 30001])); ?>">Phosphine Alerts</a></li> -->
                        <li><a href="<?php echo e(route('gas.alerts.index', ['deviceTypeId' => 30000])); ?>">CO₂ Alerts</a></li>
                        <li><a href="<?php echo e(route('gas.alerts.index', ['deviceTypeId' => 30001])); ?>">Phosphine Alerts</a></li>
                    </ul>
                </li>


                
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-live-line text-danger"></i>
                        <span>Live Streaming</span>
                    </a>
                    <ul class="sub-menu">
                       <li><a href="<?php echo e(route('sso.redirect', 'new')); ?>" target="_blank">New CCTV</a></li>
                       <li><a href="<?php echo e(route('sso.redirect', 'analog')); ?>" target="_blank">Existing CCTV</a></li>
                    </ul>
                </li>

                
                <?php if($isSuperAdmin): ?>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-settings-line text-purple"></i>
                        <span>User Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo e(route('users.index')); ?>">All Users</a></li>
                        <li><a href="<?php echo e(route('users.create')); ?>">Create User</a></li>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>