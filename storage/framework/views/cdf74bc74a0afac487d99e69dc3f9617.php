<?php $__env->startSection('title', $deviceTypeId == 30001 ? 'PH₃ Alerts' : 'CO₂ Alerts'); ?>

<?php $__env->startSection('content'); ?>

<?php $gasLabel = $deviceTypeId == 30001 ? 'PH₃' : 'CO₂'; ?>

<style>
.page-content { background: #f0f2f7 !important; }
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; }
.page-header-left { display:flex; align-items:center; gap:14px; }
.page-back-btn { display:inline-flex; align-items:center; gap:8px; background:#fff; color:#1e293b; font-size:13px; font-weight:600; padding:10px 16px; border-radius:10px; border:1px solid #e2e8f0; text-decoration:none; transition:all .2s; box-shadow:0 2px 8px rgba(0,0,0,.04); }
.page-back-btn:hover { background:#f8fafc; color:#1e293b; text-decoration:none; transform:translateY(-1px); }
.page-header-icon { width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg, <?php echo e($deviceTypeId == 30001 ? '#7c3aed 0%, #a855f7' : '#0891b2 0%, #06b6d4'); ?> 100%); display:flex; align-items:center; justify-content:center; font-size:22px; color:#fff; box-shadow:0 6px 16px <?php echo e($deviceTypeId == 30001 ? 'rgba(124,58,237,0.30)' : 'rgba(8,145,178,0.30)'); ?>; }
.page-header-text h4 { font-size:20px; font-weight:800; color:#1e293b; margin:0; }
.page-header-text span { font-size:12px; color:#94a3b8; font-weight:500; }
.gas-toggle-buttons { display:flex; gap:10px; }
.gas-toggle-buttons .btn { border-radius:10px; font-size:13px; font-weight:600; padding:8px 20px; transition:all .2s; text-decoration:none; }
.gas-toggle-buttons .btn-success { background:linear-gradient(135deg,#065f46,#10b981); border:none; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,.30); }
.gas-toggle-buttons .btn-outline-success { border:2px solid #10b981; color:#10b981; background:transparent; }
.gas-toggle-buttons .btn-outline-success:hover { background:linear-gradient(135deg,#065f46,#10b981); color:#fff; }
.gas-toggle-buttons .btn-primary { background:linear-gradient(135deg,#7c3aed,#a855f7); border:none; color:#fff; box-shadow:0 4px 12px rgba(124,58,237,.30); }
.gas-toggle-buttons .btn-outline-primary { border:2px solid #a855f7; color:#a855f7; background:transparent; }
.gas-toggle-buttons .btn-outline-primary:hover { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; }
.kpi-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:20px; }
.kpi-card { border-radius:14px; padding:20px 24px; background:#fff; box-shadow:0 4px 16px rgba(0,0,0,.08); display:flex; align-items:center; gap:16px; position:relative; overflow:hidden; transition:transform .25s,box-shadow .25s,border .25s; animation:cardIn .4s ease both; cursor:pointer; text-decoration:none; color:inherit; border:3px solid transparent; }
.kpi-card:hover { transform:translateY(-3px); box-shadow:0 10px 30px rgba(0,0,0,.14); text-decoration:none; color:inherit; }
.kpi-card.active { border:3px solid; transform:translateY(-2px); box-shadow:0 12px 35px rgba(0,0,0,.18); }
.kpi-card.kpi-green.active { border-color:#10b981; background:linear-gradient(135deg,#f0fdf4,#dcfce7); }
.kpi-card.kpi-orange.active { border-color:#f59e0b; background:linear-gradient(135deg,#fffbeb,#fef3c7); }
.kpi-card.kpi-red.active { border-color:#ef4444; background:linear-gradient(135deg,#fef2f2,#fee2e2); }
.kpi-card.kpi-blue.active { border-color:#3b82f6; background:linear-gradient(135deg,#eff6ff,#dbeafe); }
.kpi-icon { width:56px; height:56px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0; color:#fff; }
.kpi-green .kpi-icon { background:linear-gradient(135deg,#065f46,#10b981); }
.kpi-orange .kpi-icon { background:linear-gradient(135deg,#92400e,#f59e0b); }
.kpi-red .kpi-icon { background:linear-gradient(135deg,#991b1b,#ef4444); }
.kpi-blue .kpi-icon { background:linear-gradient(135deg,#1d4ed8,#3b82f6); }
.kpi-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#64748b; margin-bottom:6px; }
.kpi-value { font-size:32px; font-weight:900; letter-spacing:-1px; line-height:1; }
.kpi-green .kpi-value { color:#065f46; }
.kpi-orange .kpi-value { color:#b45309; }
.kpi-red .kpi-value { color:#991b1b; }
.kpi-blue .kpi-value { color:#1d4ed8; }
.kpi-blue { animation-delay:.03s; } .kpi-green { animation-delay:.06s; } .kpi-orange { animation-delay:.09s; } .kpi-red { animation-delay:.12s; }
.filter-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:20px 24px; margin-bottom:20px; }
.filter-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; margin-bottom:6px; display:block; }
.filter-card .form-select, .filter-card .form-control { border:1px solid #e2e8f0; border-radius:10px; font-size:13px; color:#1e293b; height:40px; background-color:#f8fafc; transition:border-color .2s,box-shadow .2s; }
.filter-card .form-select:focus, .filter-card .form-control:focus { border-color:<?php echo e($deviceTypeId == 30001 ? '#a855f7' : '#06b6d4'); ?>; box-shadow:0 0 0 3px <?php echo e($deviceTypeId == 30001 ? 'rgba(168,85,247,0.12)' : 'rgba(6,182,212,0.12)'); ?>; background:#fff; }
.filter-card .btn-primary { background:linear-gradient(135deg,<?php echo e($deviceTypeId == 30001 ? '#7c3aed 0%, #a855f7' : '#0891b2 0%, #06b6d4'); ?> 100%); border:none; border-radius:10px; font-size:13px; font-weight:600; height:40px; }
.filter-card .btn-outline-secondary { border:1px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; height:40px; color:#64748b; background:#f8fafc; }
.filter-card .btn-outline-secondary:hover { background:#f1f5f9; border-color:#cbd5e1; color:#1e293b; }
.btn-export-excel { display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg,#065f46,#10b981); color:#fff !important; border:none; border-radius:10px; font-size:13px; font-weight:600; height:40px; padding:0 16px; cursor:pointer; text-decoration:none; transition:all .2s; box-shadow:0 4px 12px rgba(16,185,129,.25); }
.btn-export-excel:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(16,185,129,.40); color:#fff; text-decoration:none; }
.table-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; animation:cardIn .4s .2s ease both; }
.table-card-header { padding:18px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.table-card-title { font-size:14px; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:8px; }
.table-card-title i { color:<?php echo e($deviceTypeId == 30001 ? '#a855f7' : '#06b6d4'); ?>; font-size:16px; }
.table-card-body { padding:0; }
#gasTable { table-layout:auto; width:100%; margin:0; }
#gasTable thead th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0; border-top:none; padding:14px 12px; white-space:nowrap; }
#gasTable tbody td { font-size:13px; color:#334155; padding:12px; border-color:#f1f5f9; vertical-align:middle; }
#gasTable tbody tr:hover { background:#f8fafc; }
.badge { font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px; }
.badge-critical { background:linear-gradient(135deg,#fee2e2,#fecaca) !important; color:#991b1b !important; border:1px solid #fca5a5; }
.badge-severe   { background:linear-gradient(135deg,#ffedd5,#fed7aa) !important; color:#92400e !important; border:1px solid #fdba74; }
.badge-normal   { background:linear-gradient(135deg,#dcfce7,#bbf7d0) !important; color:#166534 !important; border:1px solid #86efac; }
.badge-unknown  { background:#e5e7eb !important; color:#4b5563 !important; border:1px solid #cbd5e1; }
.badge-online   { background:linear-gradient(135deg,#dcfce7,#bbf7d0) !important; color:#166534 !important; border:1px solid #86efac; }
.badge-offline  { background:linear-gradient(135deg,#fee2e2,#fecaca) !important; color:#991b1b !important; border:1px solid #fca5a5; }
.dataTables_wrapper { padding:20px 24px 12px; }
.dataTables_wrapper .dataTables_length { display:none; }
.dataTables_wrapper .dataTables_filter { margin-bottom:20px; }
.dataTables_wrapper .dataTables_filter input { height:40px; border:1px solid #e2e8f0; border-radius:8px; padding:0 14px; font-size:13px; margin-left:8px; font-weight:500; background:#f8fafc; }
.dataTables_wrapper .dataTables_filter input:focus { border-color:<?php echo e($deviceTypeId == 30001 ? '#a855f7' : '#06b6d4'); ?>; outline:none; }
.dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { display:none; }
.pagination-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:16px 24px; margin-top:16px; margin-bottom:0; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; animation:cardIn .4s .25s ease both; }
.pagination-info { font-size:14px; font-weight:600; color:#1e293b; }
.pagination-info strong { color:<?php echo e($deviceTypeId == 30001 ? '#a855f7' : '#06b6d4'); ?>; }
.pagination { display:flex; gap:4px; margin:0; padding:0; list-style:none; }
.pagination .page-link { padding:8px 14px; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600; font-size:13px; background:#fff; transition:all .2s; text-decoration:none; display:flex; align-items:center; gap:4px; }
.pagination .page-link:hover { background:<?php echo e($deviceTypeId == 30001 ? 'linear-gradient(135deg,#7c3aed,#a855f7)' : 'linear-gradient(135deg,#0891b2,#06b6d4)'); ?>; color:#fff; border-color:<?php echo e($deviceTypeId == 30001 ? '#a855f7' : '#06b6d4'); ?>; transform:translateY(-1px); text-decoration:none; }
.pagination .page-item.active .page-link { background:<?php echo e($deviceTypeId == 30001 ? 'linear-gradient(135deg,#7c3aed,#a855f7)' : 'linear-gradient(135deg,#0891b2,#06b6d4)'); ?>; border-color:<?php echo e($deviceTypeId == 30001 ? '#a855f7' : '#06b6d4'); ?>; color:#fff; }
.pagination .page-item.disabled .page-link { opacity:.5; cursor:not-allowed; pointer-events:none; }
@keyframes cardIn { from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);} }
@media(max-width:1200px){ .kpi-row{grid-template-columns:repeat(2,1fr);} }
@media(max-width:768px){ .kpi-row{grid-template-columns:1fr;} .page-header{flex-direction:column;align-items:flex-start;gap:12px;} .pagination-card{flex-direction:column;align-items:flex-start;} .pagination{width:100%;justify-content:center;flex-wrap:wrap;} }
</style>


<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-icon"><i class="ri-flask-line"></i></div>
        <div class="page-header-text">
            <h4><?php echo e($gasLabel); ?> Gas Alerts</h4>
            <span>Monitor <?php echo e($gasLabel); ?> sensor alerts across warehouses</span>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <div class="gas-toggle-buttons">
            <a href="<?php echo e(route('gas.alerts.index', array_merge(request()->except(['deviceTypeId','page']), ['deviceTypeId' => 30000]))); ?>"
               class="btn <?php echo e($deviceTypeId == 30000 ? 'btn-success' : 'btn-outline-success'); ?>">
                <i class="ri-cloud-line me-1"></i> CO₂
            </a>
            <a href="<?php echo e(route('gas.alerts.index', array_merge(request()->except(['deviceTypeId','page']), ['deviceTypeId' => 30001]))); ?>"
               class="btn <?php echo e($deviceTypeId == 30001 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                <i class="ri-test-tube-line me-1"></i> PH₃
            </a>
        </div>
        <a href="<?php echo e(route('dashboard')); ?>" class="page-back-btn">
            <i class="ri-arrow-left-line"></i> Back to Dashboard
        </a>
    </div>
</div>


<div class="kpi-row">
    <a href="<?php echo e(route('gas.alerts.index', array_merge(request()->except(['alertType','page']), ['deviceTypeId'=>$deviceTypeId]))); ?>"
       class="kpi-card kpi-blue <?php echo e(empty($selectedAlertType) ? 'active' : ''); ?>">
        <div class="kpi-icon"><i class="ri-bar-chart-box-line"></i></div>
        <div><div class="kpi-label">Total Alerts</div><div class="kpi-value"><?php echo e(number_format($kpis['total'])); ?></div></div>
    </a>
    <a href="<?php echo e(route('gas.alerts.index', array_merge(request()->except(['alertType','page']), ['deviceTypeId'=>$deviceTypeId,'alertType'=>'NORMAL']))); ?>"
       class="kpi-card kpi-green <?php echo e($selectedAlertType=='NORMAL' ? 'active' : ''); ?>">
        <div class="kpi-icon"><i class="ri-checkbox-circle-line"></i></div>
        <div><div class="kpi-label">Normal Alerts</div><div class="kpi-value"><?php echo e(number_format($kpis['normal'])); ?></div></div>
    </a>
    <a href="<?php echo e(route('gas.alerts.index', array_merge(request()->except(['alertType','page']), ['deviceTypeId'=>$deviceTypeId,'alertType'=>'SEVERE']))); ?>"
       class="kpi-card kpi-orange <?php echo e($selectedAlertType=='SEVERE' ? 'active' : ''); ?>">
        <div class="kpi-icon"><i class="ri-error-warning-line"></i></div>
        <div><div class="kpi-label">Severe Alerts</div><div class="kpi-value"><?php echo e(number_format($kpis['severe'])); ?></div></div>
    </a>
    <a href="<?php echo e(route('gas.alerts.index', array_merge(request()->except(['alertType','page']), ['deviceTypeId'=>$deviceTypeId,'alertType'=>'CRITICAL']))); ?>"
       class="kpi-card kpi-red <?php echo e($selectedAlertType=='CRITICAL' ? 'active' : ''); ?>">
        <div class="kpi-icon"><i class="ri-alarm-warning-line"></i></div>
        <div><div class="kpi-label">Critical Alerts</div><div class="kpi-value"><?php echo e(number_format($kpis['critical'])); ?></div></div>
    </a>
</div>


<div class="filter-card">
    <form method="GET" id="filterForm" class="row g-2 align-items-end">
        <input type="hidden" name="deviceTypeId" value="<?php echo e($deviceTypeId); ?>">
        <input type="hidden" name="showNormal"   value="<?php echo e($showNormal ? 1 : 0); ?>">
        <div class="col-md-2">
            <label class="filter-label">State</label>
            <select id="stateSelect" name="state" class="form-select">
                <option value="">All States</option>
                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $stateId   = is_array($s) ? ($s['base_id'] ?? $s['id'] ?? '') : '';
                        $stateName = is_array($s) ? ($s['name'] ?? $s['stateName'] ?? $s['state'] ?? '') : $s;
                    ?>
                    <option value="<?php echo e($stateId); ?>"
                            <?php echo e((string) $selectedState === (string) $stateId ? 'selected' : ''); ?>>
                        <?php echo e($stateName); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">Location</label>
            <select id="locationSelect" name="location" class="form-select">
                <option value="">All Locations</option>
                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $locationId   = is_array($loc) ? ($loc['base_id'] ?? $loc['id'] ?? '') : '';
                        $locationName = is_array($loc) ? ($loc['name'] ?? $loc['locationName'] ?? $loc['location'] ?? '') : $loc;
                    ?>
                    <option value="<?php echo e($locationId); ?>" <?php echo e((string) $selectedLocation === (string) $locationId ? 'selected' : ''); ?>>
                        <?php echo e($locationName); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">Alert Type</label>
            <select name="alertType" class="form-select">
                <option value="">All Types</option>
                <option value="CRITICAL" <?php echo e($selectedAlertType=='CRITICAL' ? 'selected' : ''); ?>>Critical</option>
                <option value="SEVERE"   <?php echo e($selectedAlertType=='SEVERE'   ? 'selected' : ''); ?>>Severe</option>
                <option value="NORMAL"   <?php echo e($selectedAlertType=='NORMAL'   ? 'selected' : ''); ?>>Normal</option>
                <option value="UNKNOWN"  <?php echo e($selectedAlertType=='UNKNOWN'  ? 'selected' : ''); ?>>Unknown</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">From Date</label>
            <input type="date" name="fromDate" class="form-control" value="<?php echo e($fromDate); ?>">
        </div>
        <div class="col-md-2">
            <label class="filter-label">To Date</label>
            <input type="date" name="toDate" class="form-control" value="<?php echo e($toDate); ?>">
        </div>
        <div class="col-md-2 d-flex gap-2 align-items-end">
            <button type="submit" class="btn btn-primary flex-grow-1" style="height:40px;">
                <i class="ri-search-line"></i>
            </button>
            <a href="<?php echo e(route('gas.alerts.index', ['deviceTypeId' => $deviceTypeId])); ?>"
               class="btn btn-outline-secondary" style="height:40px;display:inline-flex;align-items:center;padding:0 12px;">
                <i class="ri-refresh-line"></i>
            </a>
        </div>
    </form>
</div>


<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            <i class="ri-table-line"></i>
            <?php echo e($gasLabel); ?> Alert Records
            <?php if($selectedAlertType): ?>
                <span class="badge <?php echo e($selectedAlertType=='CRITICAL' ? 'badge-critical' : ($selectedAlertType=='SEVERE' ? 'badge-severe' : ($selectedAlertType=='UNKNOWN' ? 'badge-unknown' : 'badge-normal'))); ?>">
                    <?php echo e(ucfirst(strtolower($selectedAlertType))); ?> Only
                </span>
            <?php endif; ?>
        </div>
        <button onclick="exportToServer()" class="btn-export-excel">
            <i class="ri-file-excel-line"></i> Export All Records
        </button>
    </div>
    <div class="table-card-body">
        <div class="table-responsive">
            <table id="gasTable" class="table table-bordered align-middle w-100">
                <thead>
                    <tr>
                        <th style="min-width:140px;">Device</th>
                        <th style="min-width:150px;">Location</th>
                        <th style="min-width:120px;">IP Address</th>
                        <th style="min-width:100px;">Value</th>
                        <th style="min-width:100px;">Level</th>
                        <th style="min-width:100px;">Status</th>
                        <th style="min-width:160px;">Timestamp</th>
                    </tr>
                </thead>
                <tbody id="alertTableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $type       = strtoupper($alert['alertType'] ?: 'NORMAL');
                            $badgeClass = match($type) {
                                'CRITICAL' => 'badge-critical',
                                'SEVERE'   => 'badge-severe',
                                'NORMAL'   => 'badge-normal',
                                default    => 'badge-unknown'
                            };
                            $deviceStatus = trim((string) ($alert['deviceStatus'] ?? ''));
                            $statusClass  = match(strtolower($deviceStatus)) {
                                'online'  => 'badge-online',
                                'offline' => 'badge-offline',
                                default   => 'badge-unknown'
                            };
                        ?>
                        <tr>
                            <td><?php echo e($gasLabel); ?>-<?php echo e($alert['shadName'] ?? ''); ?><?php echo e($alert['columnName'] ?? ''); ?></td>
                            <td><?php echo e($alert['locationName'] ?? '-'); ?></td>
                            <td><?php echo e($alert['deviceIp']     ?? '-'); ?></td>
                            <td><?php echo e($alert['deviceValue']  ?? '-'); ?></td>
                            <td><span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst(strtolower($type))); ?></span></td>
                            <td><span class="badge <?php echo e($statusClass); ?>"><?php echo e($deviceStatus !== '' ? $deviceStatus : '-'); ?></span></td>
                            <td><?php echo e(isset($alert['regDate']) ? \Carbon\Carbon::parse($alert['regDate'])->format('d M Y h:i A') : '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="ri-inbox-line" style="font-size:32px;opacity:.3;"></i>
                                <div class="mt-2">No alerts found</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php if($totalPages > 1): ?>
<div class="pagination-card mb-5">
    <div class="pagination-info">
        Showing page <strong><?php echo e(number_format($page)); ?></strong> of <strong><?php echo e(number_format($totalPages)); ?></strong>
    </div>
    <nav>
        <ul class="pagination mb-0">
            <li class="page-item <?php echo e($page<=1 ? 'disabled' : ''); ?>">
                <a class="page-link" href="<?php echo e($page<=1 ? '#' : route('gas.alerts.index', array_merge(request()->except('page'),['page'=>1]))); ?>">
                    <i class="ri-skip-back-mini-line"></i> First
                </a>
            </li>
            <li class="page-item <?php echo e($page<=1 ? 'disabled' : ''); ?>">
                <a class="page-link" href="<?php echo e($page<=1 ? '#' : route('gas.alerts.index', array_merge(request()->except('page'),['page'=>max(1,$page-1)]))); ?>">
                    <i class="ri-arrow-left-s-line"></i> Prev
                </a>
            </li>
            <?php $start=max(1,$page-2); $end=min($totalPages,$page+2); ?>
            <?php for($i=$start; $i<=$end; $i++): ?>
                <li class="page-item <?php echo e($i==$page ? 'active' : ''); ?>">
                    <a class="page-link" href="<?php echo e(route('gas.alerts.index', array_merge(request()->except('page'),['page'=>$i]))); ?>"><?php echo e(number_format($i)); ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo e($page>=$totalPages ? 'disabled' : ''); ?>">
                <a class="page-link" href="<?php echo e($page>=$totalPages ? '#' : route('gas.alerts.index', array_merge(request()->except('page'),['page'=>min($totalPages,$page+1)]))); ?>">
                    Next <i class="ri-arrow-right-s-line"></i>
                </a>
            </li>
            <li class="page-item <?php echo e($page>=$totalPages ? 'disabled' : ''); ?>">
                <a class="page-link" href="<?php echo e($page>=$totalPages ? '#' : route('gas.alerts.index', array_merge(request()->except('page'),['page'=>$totalPages]))); ?>">
                    Last <i class="ri-skip-forward-mini-line"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>

/* ── State → Location chaining ── */
document.addEventListener('DOMContentLoaded', () => {
    const stateSelect    = document.getElementById('stateSelect');
    const locationSelect = document.getElementById('locationSelect');
    const selectedLoc    = <?php echo json_encode($selectedLocation, 15, 512) ?>;
    const selectedState  = <?php echo json_encode($selectedState, 15, 512) ?>;

    function loadLocations(stateId, preselectValue = null) {
        locationSelect.innerHTML = '<option value="">All Locations</option>';
        if (!stateId) { locationSelect.disabled = false; return; }
        locationSelect.disabled = true;
        fetch(`<?php echo e(route('gas.alerts.locations', ['state' => '__STATE__'])); ?>`.replace('__STATE__', encodeURIComponent(stateId)))
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) { locationSelect.disabled = false; return; }
                data.forEach(item => {
                    const locationId = typeof item === 'object' && item !== null
                        ? (item.base_id ?? item.id)
                        : null;
                    const locationName = typeof item === 'string'
                        ? item
                        : (item.name ?? item.locationName ?? item.location);
                    if (locationId === undefined || locationId === null || !locationName) return;
                    const opt = document.createElement('option');
                    opt.value = locationId;
                    opt.textContent = locationName;
                    if (String(locationId) === String(preselectValue)) opt.selected = true;
                    locationSelect.appendChild(opt);
                });
                locationSelect.disabled = false;
            })
            .catch(() => { locationSelect.disabled = false; });
    }

    if (selectedState) {
        loadLocations(selectedState, selectedLoc);
    }
    stateSelect.addEventListener('change', function () {
        loadLocations(this.value);
    });
});

/* ── DataTable ── */
$(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'none';
    const $gasTable = $('#gasTable');

    // DataTables does not support colspan cells inside tbody.
    // Keep the server-rendered empty-state row without initializing it.
    if ($gasTable.find('tbody td[colspan]').length) {
        return;
    }

    $gasTable.DataTable({
        paging: false, lengthMenu: false, info: false,
        searching: false, ordering: true, order: [[6, 'desc']],
        scrollX: false, autoWidth: false,
        columnDefs: [
            {width:"140px",targets:0},{width:"150px",targets:1},
            {width:"120px",targets:2},{width:"100px",targets:3},
            {width:"100px",targets:4},{width:"100px",targets:5},
            {width:"160px",targets:6}
        ],
        language: { emptyTable:'No alerts available', zeroRecords:'No alerts match your search.' }
    });
});

/* ── Export All Records (server-side CSV) ── */
function exportToServer() {
    const params = new URLSearchParams({
        deviceTypeId: "<?php echo e($deviceTypeId); ?>",
        state:        "<?php echo e($selectedState); ?>",
        location:     "<?php echo e($selectedLocation); ?>",
        alertType:    "<?php echo e($selectedAlertType); ?>",
        fromDate:     "<?php echo e($fromDate); ?>",
        toDate:       "<?php echo e($toDate); ?>",
        showNormal:   "<?php echo e($showNormal ? 1 : 0); ?>",
    });
    // Remove empty params
    for (const [k, v] of [...params.entries()]) {
        if (!v || v === '0') params.delete(k);
    }
    window.location.href = '<?php echo e(route("gas.alerts.export")); ?>?' + params.toString();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\alerts\gas.blade.php ENDPATH**/ ?>