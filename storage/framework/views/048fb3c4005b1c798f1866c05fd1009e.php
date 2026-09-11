<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex w-100 align-items-center">

            <!-- LEFT: Logo & Menu Toggle -->
            <div class="d-flex align-items-center">
                <div class="navbar-brand-box">
                    <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('backends/assets/images/cwc.jpg')); ?>" alt="logo-sm" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('backends/assets/images/cwclogo.png')); ?>" alt="logo-dark">
                        </span>
                    </a>

                    <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('backends/assets/images/cwc.jpg')); ?>" alt="logo-sm-light" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('backends/assets/images/cwclogo.png')); ?>" alt="logo-light">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>
            </div>

            <!-- CENTER: Title & Breadcrumb -->
            <div class="flex-grow-1 text-left px-3">
                <h4 class="mb-0 fw-bold text-white d-flex align-items-center justify-content-center gap-2">
                    <i class="ri-dashboard-3-line"></i>
                    Smart Warehouse - Unified Dashboard
                </h4>
                <?php
                    $user = Auth::user();
                ?>
                <?php if($user->hasRole('region_officer') && $user->region): ?>
                    <small class="text-white-50 d-block mt-1">
                        <i class="ri-map-pin-line"></i> <?php echo e($user->region->name); ?> Region
                    </small>
                <?php elseif($user->hasRole('warehouse_officer') && $user->warehouse): ?>
                    <small class="text-white-50 d-block mt-1">
                        <i class="ri-building-line"></i> <?php echo e($user->warehouse->warehouse); ?>

                    </small>
                <?php endif; ?>
            </div>

            <!-- RIGHT: Role Badge + User Profile -->
            <div class="d-flex align-items-center gap-3">

                <?php
                    $roleInfo = [
                        'superadmin' => ['label' => 'Super Admin', 'color' => 'primary', 'icon' => 'ri-shield-star-line'],
                        'admin' => ['label' => 'Admin', 'color' => 'primary', 'icon' => 'ri-admin-line'],
                        'region_officer' => ['label' => 'Region Officer', 'color' => 'primary', 'icon' => 'ri-map-pin-user-line'],
                        'warehouse_officer' => ['label' => 'Warehouse Officer', 'color' => 'primary', 'icon' => 'ri-building-4-line'],
                    ];

                    $currentRole = null;
                    foreach ($roleInfo as $role => $info) {
                        if ($user->hasRole($role)) {
                            $currentRole = $info;
                            break;
                        }
                    }

                    if (!$currentRole) {
                        $currentRole = ['label' => 'User', 'color' => 'secondary', 'icon' => 'ri-user-line'];
                    }
                ?>

                <div class="d-none d-lg-block">
                    <span class="badge badge-soft-<?php echo e($currentRole['color']); ?> px-3 py-2">
                        <i class="<?php echo e($currentRole['icon']); ?> me-1"></i>
                        <?php echo e($currentRole['label']); ?>

                    </span>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item bg-soft-light waves-effect"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                             src="<?php echo e(asset('backends/assets/images/users/user.png')); ?>"
                             alt="Avatar">
                        <span class="d-none d-xl-inline-block ms-2 me-1">
                            <?php echo e(Str::limit(Auth::user()->name, 20)); ?>

                        </span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end" style="min-width: 280px;">
                        <div class="p-3 bg-soft-<?php echo e($currentRole['color']); ?> border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle me-3"
                                     src="<?php echo e(asset('backends/assets/images/users/user.png')); ?>"
                                     alt="Avatar" width="48" height="48">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold"><?php echo e(Auth::user()->name); ?></h6>
                                    <p class="text-muted mb-0 small"><?php echo e(Auth::user()->email); ?></p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-<?php echo e($currentRole['color']); ?> px-2 py-1">
                                    <i class="<?php echo e($currentRole['icon']); ?> me-1"></i>
                                    <?php echo e($currentRole['label']); ?>

                                </span>
                            </div>
                            <?php if($user->hasRole('region_officer') && $user->region): ?>
                                <div class="mt-2 pt-2 border-top border-white">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="ri-map-pin-line me-2"></i>
                                        <strong>Region:</strong>&nbsp;<?php echo e($user->region->name); ?>

                                    </small>
                                    <small class="text-muted d-flex align-items-center mt-1">
                                        <i class="ri-building-line me-2"></i>
                                        <strong>Warehouses:</strong>&nbsp;<?php echo e($user->getAccessibleWarehouses()->count()); ?>

                                    </small>
                                </div>
                            <?php elseif($user->hasRole('warehouse_officer') && $user->warehouse): ?>
                                <div class="mt-2 pt-2 border-top border-white">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="ri-building-line me-2"></i>
                                        <strong>Warehouse:</strong>&nbsp;<?php echo e($user->warehouse->warehouse); ?>

                                    </small>
                                    <small class="text-muted d-flex align-items-center mt-1">
                                        <i class="ri-map-pin-line me-2"></i>
                                        <strong>Region:</strong>&nbsp;<?php echo e($user->warehouse->region->name); ?>

                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?php echo e(route('admin.logout')); ?>">
                            <i class="ri-shut-down-line align-middle me-2"></i>
                            <span class="align-middle">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
#page-topbar {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 50%, #1e3a8a 100%);
    box-shadow: 0 4px 20px rgba(30, 64, 175, 0.3);
    border-bottom: 3px solid rgba(255, 255, 255, 0.3);
}

.navbar-header { padding: 0; }

/* Logo Box */
.navbar-brand-box {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    width: 250px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    padding: 0 16px;
}

.navbar-brand-box::after {
    content: '';
    position: absolute;
    right: 0;
    top: 10px;
    bottom: 10px;
    width: 2px;
    background: linear-gradient(180deg, transparent 0%, rgba(30, 64, 175, 0.2) 50%, transparent 100%);
}

.navbar-brand-box .logo {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

/* KEY FIX: logo-lg img fills the box properly */
.navbar-brand-box .logo-lg img {
    max-height: 52px;
    max-width: 210px;
    width: auto;
    height: auto;
    object-fit: contain;
    display: block;
}

.navbar-brand-box .logo-sm img {
    max-height: 40px;
    width: auto;
    object-fit: contain;
}

/* Collapsed sidebar */
body.vertical-collpsed .navbar-brand-box,
.vertical-collpsed .navbar-brand-box {
    width: 70px;
    padding: 0 8px;
}

.vertical-collpsed .navbar-brand-box .logo-lg { display: none !important; }
.vertical-collpsed .navbar-brand-box .logo-sm { display: block !important; }

/* Menu Toggle */
#vertical-menu-btn {
    margin-left: 0;
    padding: 1rem 1.5rem;
    color: white !important;
    transition: all 0.3s ease;
}
#vertical-menu-btn:hover {
    background: rgba(255,255,255,0.15) !important;
}

/* Header items */
.header-item { color: white !important; transition: all 0.3s ease; padding: 0.75rem 1rem; }
.header-item:hover { background: rgba(255,255,255,0.15) !important; transform: translateY(-1px); }
.bg-soft-light {
    background: rgba(255,255,255,0.15) !important;
    border: 1px solid rgba(255,255,255,0.25);
}

.header-profile-user {
    width: 36px;
    height: 36px;
    border: 2px solid rgba(255,255,255,0.7);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* Dropdown */
.user-dropdown .dropdown-menu {
    margin-top: 0.5rem;
    border: none;
    box-shadow: 0 10px 40px rgba(30, 64, 175, 0.2);
    border-radius: 8px;
    overflow: hidden;
}
.dropdown-item { padding: 0.65rem 1.25rem; transition: all 0.2s ease; }
.dropdown-item:hover { background: #f1f5f9; padding-left: 1.5rem; }
.dropdown-item i { font-size: 16px; }

/* Role badges */
.badge-soft-primary {
    background: rgba(30, 64, 175, 0.25);
    color: #ffffff;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.2);
}
.badge-soft-secondary {
    background: rgba(108, 117, 125, 0.25);
    color: #ffffff;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.2);
}

.bg-soft-primary  { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important; }
.bg-soft-warning  { background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%) !important; }
.bg-soft-info     { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; }
.bg-soft-secondary{ background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important; }

/* Responsive */
@media (max-width: 991px) {
    .navbar-brand-box { width: 70px; padding: 0 8px; }
    .navbar-brand-box .logo-lg { display: none !important; }
    .navbar-brand-box .logo-sm { display: block !important; }
}
@media (max-width: 768px) {
    #page-topbar h4 { font-size: 1rem; }
    .navbar-brand-box { width: 70px; height: 60px; }
}
</style>
<?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\layout\header.blade.php ENDPATH**/ ?>