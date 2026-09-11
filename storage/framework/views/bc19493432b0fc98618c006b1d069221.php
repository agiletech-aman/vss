<?php $__env->startSection('title', 'Fire Alerts'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

<style>
:root {
    --alert-bg: #f8fafc;
    --alert-card: #ffffff;
    --alert-text: #0f172a;
    --alert-muted: #64748b;
    --alert-border: #e2e8f0;
    --alert-fire: #dc2626;
    --alert-fire-bg: #fef2f2;
    --alert-fire-light: #fee2e2;
    --alert-radius: 12px;
    --alert-shadow: 0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.06);
    --alert-shadow-lg: 0 4px 6px rgba(0,0,0,.05), 0 10px 15px rgba(0,0,0,.08);
}
* { font-family: 'DM Sans', -apple-system, sans-serif; }
body { background: var(--alert-bg); }
.alert-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
.alert-back-btn { display: inline-flex; align-items: center; gap: 8px; background: var(--alert-card); color: var(--alert-text); font-size: 14px; font-weight: 600; padding: 10px 18px; border-radius: 10px; border: 1px solid var(--alert-border); text-decoration: none; transition: all 0.2s ease; box-shadow: var(--alert-shadow); }
.alert-back-btn:hover { background: #f8fafc; color: var(--alert-text); text-decoration: none; transform: translateY(-1px); box-shadow: var(--alert-shadow-lg); }
.alert-back-btn i { font-size: 16px; }
.alert-title { display: flex; align-items: center; gap: 12px; margin: 0; }
.alert-icon { width: 44px; height: 44px; background: linear-gradient(135deg, #dc2626, #ef4444); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; box-shadow: 0 4px 12px rgba(220,38,38,0.3); }
.alert-title h4 { font-size: 24px; font-weight: 800; color: var(--alert-text); margin: 0; letter-spacing: -0.5px; }
.alert-title .subtitle { font-size: 13px; color: var(--alert-muted); font-weight: 500; margin-top: 2px; }
.filter-card { background: var(--alert-card); border: 1px solid var(--alert-border); border-radius: var(--alert-radius); padding: 24px; margin-bottom: 20px; box-shadow: var(--alert-shadow); }
.filter-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--alert-muted); margin-bottom: 8px; display: block; }
.filter-card .form-select, .filter-card .form-control { height: 48px; border: 1.5px solid var(--alert-border); border-radius: 10px; font-size: 14px; font-weight: 500; color: var(--alert-text); background: #f8fafc; transition: all 0.2s ease; }
.filter-card .form-select:focus, .filter-card .form-control:focus { border-color: var(--alert-fire); background: #fff; box-shadow: 0 0 0 3px rgba(220,38,38,0.08); outline: none; }
.filter-actions { display: flex; gap: 10px; }
.btn-filter { height: 48px; background: linear-gradient(135deg, #dc2626, #b91c1c); color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; padding: 0 24px; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(220,38,38,0.25); cursor: pointer; }
.btn-filter:hover { background: linear-gradient(135deg, #b91c1c, #991b1b); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(220,38,38,0.35); }
.btn-reset { height: 48px; background: var(--alert-card); color: var(--alert-muted); border: 1.5px solid var(--alert-border); border-radius: 10px; font-size: 14px; font-weight: 600; padding: 0 24px; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
.btn-reset:hover { background: #f8fafc; border-color: #cbd5e1; color: var(--alert-text); }
.location-loading-indicator { display: none; font-size: 12px; color: var(--alert-muted); margin-top: 6px; align-items: center; gap: 6px; }
.location-loading-indicator.active { display: flex; }
.spinner-xs { width: 14px; height: 14px; border: 2px solid var(--alert-border); border-top-color: var(--alert-fire); border-radius: 50%; animation: spin 0.6s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }
.info-banner { background: var(--alert-fire-bg); border: 1px solid var(--alert-fire-light); border-left: 4px solid var(--alert-fire); border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; font-size: 13px; color: #7f1d1d; font-weight: 600; }
.info-banner i { font-size: 18px; color: var(--alert-fire); }
.table-card { background: var(--alert-card); border: 1px solid var(--alert-border); border-radius: var(--alert-radius); overflow: hidden; box-shadow: var(--alert-shadow-lg); margin-bottom: 16px; }
.table-card-header { padding: 18px 24px; border-bottom: 1px solid var(--alert-border); background: #f9fafb; display: flex; align-items: center; justify-content: space-between; }
.table-card-title { font-size: 16px; font-weight: 700; color: var(--alert-text); margin: 0; display: flex; align-items: center; gap: 8px; }
.table-card-title i { color: var(--alert-fire); }
#fireTable { width: 100%; margin: 0; border-collapse: collapse; }
#fireTable thead th { background: #f9fafb; color: var(--alert-muted); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 16px 20px; border-bottom: 1px solid var(--alert-border); white-space: nowrap; text-align: left; cursor: pointer; user-select: none; position: relative; }
#fireTable thead th:after { content: ' ⇅'; font-size: 10px; opacity: 0.4; }
#fireTable thead th.sort-asc:after  { content: ' ↑'; opacity: 1; }
#fireTable thead th.sort-desc:after { content: ' ↓'; opacity: 1; }
#fireTable thead th.no-sort:after   { content: ''; }
#fireTable tbody td { padding: 16px 20px; color: var(--alert-text); font-size: 14px; font-weight: 500; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
#fireTable tbody tr { transition: background 0.15s ease; }
#fireTable tbody tr:hover { background: #f9fafb; }
#fireTable tbody tr:last-child td { border-bottom: none; }
.empty-state { text-align: center; padding: 60px 20px; color: var(--alert-muted); }
.empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: 0.4; }
.empty-state p { margin: 0; font-size: 14px; font-weight: 500; }
.datetime-cell { font-family: 'IBM Plex Mono', monospace; font-size: 13px; color: var(--alert-muted); font-weight: 600; }
.camera-name { font-weight: 600; color: var(--alert-text); }
.location-cell { color: var(--alert-muted); font-size: 13px; }
.alert-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: var(--alert-fire-bg); color: var(--alert-fire); border: 1px solid var(--alert-fire-light); border-radius: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.preview-img { width: 70px; height: 70px; object-fit: cover; border-radius: 10px; cursor: pointer; transition: all 0.2s ease; border: 2px solid var(--alert-border); }
.preview-img:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-color: var(--alert-fire); }
.pagination-wrapper { background: var(--alert-card); border: 1px solid var(--alert-border); border-radius: var(--alert-radius); padding: 16px 24px; margin-top: 16px; box-shadow: var(--alert-shadow); }
.pagination { margin: 0; gap: 6px; display: flex; justify-content: center; align-items: center; }
.pagination .page-item { list-style: none; }
.pagination .page-link { border: 1.5px solid var(--alert-border); border-radius: 8px; color: var(--alert-text); font-weight: 600; font-size: 14px; padding: 10px 16px; transition: all 0.2s ease; text-decoration: none; background: var(--alert-card); display: flex; align-items: center; gap: 6px; }
.pagination .page-link:hover { background: var(--alert-fire); color: #fff; border-color: var(--alert-fire); transform: translateY(-1px); }
.pagination .page-item.active .page-link { background: var(--alert-fire); border-color: var(--alert-fire); color: #fff; }
.pagination .page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; pointer-events: none; }
.modal-content { border-radius: var(--alert-radius); border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
.modal-body { padding: 24px; }
#previewImage { border-radius: var(--alert-radius); max-width: 100%; height: auto; }
@media (max-width: 768px) { .alert-header { flex-direction: column; align-items: flex-start; } .filter-actions { width: 100%; } }
</style>

<div style="padding: 0;">

    
    <div class="alert-header">
        <div class="alert-title">
            <div class="alert-icon"><i class="ri-fire-fill"></i></div>
            <div>
                <h4>Fire Detection Alerts</h4>
                <div class="subtitle">Camera Logs &amp; Activity</div>
            </div>
        </div>
        <a href="<?php echo e(route('dashboard')); ?>" class="alert-back-btn">
            <i class="ri-arrow-left-line"></i> Back to Dashboard
        </a>
    </div>

    
    <div class="filter-card">
        <form method="GET" id="filterForm" class="row g-3">
            <div class="col-md-3">
                <label class="filter-label">Location</label>
                <select name="location" id="locationSelect" class="form-select">
                    <option value="">All Locations</option>
                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($loc); ?>" <?php echo e(request('location') == $loc ? 'selected' : ''); ?>><?php echo e($loc); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div class="location-loading-indicator" id="locationLoader">
                    <div class="spinner-xs"></div><span>Loading locations...</span>
                </div>
            </div>
            <div class="col-md-2">
                <label class="filter-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
            </div>
            <div class="col-md-2">
                <label class="filter-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
            </div>
            <div class="col-md-2">
                <label class="filter-label" style="opacity:0;">Actions</label>
                <div class="filter-actions">
                    <button type="submit" class="btn-filter flex-fill"><i class="ri-search-line"></i></button>
                    <a href="<?php echo e(route('alerts.fire')); ?>" class="btn-reset"><i class="ri-refresh-line"></i></a>
                </div>
            </div>
        </form>
    </div>

    
    <?php if(request('from_date') && request('to_date')): ?>
    <div class="info-banner">
        <i class="ri-calendar-line"></i>
        <div>Showing records from <strong><?php echo e(\Carbon\Carbon::parse(request('from_date'))->format('d M Y')); ?></strong> to <strong><?php echo e(\Carbon\Carbon::parse(request('to_date'))->format('d M Y')); ?></strong></div>
    </div>
    <?php endif; ?>

    
    <div class="table-card">
        <div class="table-card-header">
            <h5 class="table-card-title"><i class="ri-fire-line"></i> Fire Alert Logs</h5>
            <div style="display:flex;align-items:center;gap:10px;">
                <?php if($total > 0): ?>
                <span style="font-size:13px;color:var(--alert-muted);font-weight:600;"><?php echo e(number_format($total)); ?> total records</span>
                <?php endif; ?>
                <?php if($alerts->count() > 0): ?>
                <a href="<?php echo e(route('alerts.fire.export')); ?>?<?php echo e(http_build_query(request()->query())); ?>"
                   style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#dc2626,#b91c1c);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;height:34px;padding:0 14px;cursor:pointer;box-shadow:0 4px 10px rgba(220,38,38,.25);transition:all .2s;text-decoration:none;">
                    <i class="ri-file-excel-line"></i> Export All
                </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if($alerts->count() > 0): ?>
        <div class="table-responsive">
            <table id="fireTable" class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th data-col="0">Date &amp; Time</th>
                        <th data-col="1">Camera Name</th>
                        <th data-col="2">Location</th>
                        <th data-col="3">Alert Type</th>
                        <th class="no-sort" style="cursor:default;">Image</th>
                    </tr>
                </thead>
                <tbody id="fireTableBody">
                    <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="datetime-cell"><?php echo e(\Carbon\Carbon::parse($row['alertDateTime'])->format('d-m-Y H:i:s')); ?></td>
                            <td class="camera-name"><?php echo e($row['cameraName'] ?? '-'); ?></td>
                            <td class="location-cell"><?php echo e($row['locationName'] ?? '-'); ?></td>
                            <td><span class="alert-badge"><i class="ri-fire-fill"></i> Fire</span></td>
                            <td class="text-center">
                                <?php if(!empty($row['imagePath'])): ?>
                                    <?php $imageUrl = 'https://co2ph3master.ajeevi.in' . $row['imagePath']; ?>
                                    <img src="<?php echo e($imageUrl); ?>" class="preview-img" data-full="<?php echo e($imageUrl); ?>" loading="lazy" onerror="this.style.display='none'" alt="Fire Alert">
                                <?php else: ?>
                                    <span style="color:var(--alert-muted);font-size:12px;">No Image</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="ri-fire-line"></i>
            <p>No fire alerts found.</p>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($alerts->hasPages()): ?>
    <div class="pagination-wrapper mb-4">
        <?php echo e($alerts->appends(request()->query())->links('pagination::bootstrap-5')); ?>

    </div>
    <?php endif; ?>

</div>


<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="previewImage" class="img-fluid rounded" alt="Alert Preview">
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('fireTable');
    let sortCol = 0, sortDir = -1;
    if (table) {
        const headers = table.querySelectorAll('thead th[data-col]');
        const tbody   = table.querySelector('tbody');
        function sortTable(colIndex, dir) {
            const rows = Array.from(tbody.querySelectorAll('tr'));
            rows.sort((a, b) => (a.cells[colIndex]?.innerText || '').trim().localeCompare((b.cells[colIndex]?.innerText || '').trim(), undefined, { numeric: true }) * dir);
            rows.forEach(r => tbody.appendChild(r));
            headers.forEach(h => { h.classList.remove('sort-asc','sort-desc'); if (parseInt(h.dataset.col) === colIndex) h.classList.add(dir === 1 ? 'sort-asc' : 'sort-desc'); });
        }
        sortTable(0, -1);
        headers.forEach(th => th.addEventListener('click', function () { const col = parseInt(this.dataset.col); if (col === sortCol) sortDir *= -1; else { sortCol = col; sortDir = 1; } sortTable(sortCol, sortDir); }));
    }

    const stateSelect    = document.getElementById('stateSelect');
    const locationSelect = document.getElementById('locationSelect');
    const loader         = document.getElementById('locationLoader');
    const preselectedLocation = <?php echo json_encode(request('location'), 15, 512) ?>;
    const preselectedState    = <?php echo json_encode(request('state'), 15, 512) ?>;

    if (stateSelect) {
        stateSelect.addEventListener('change', function () {
            const state = this.value;
            locationSelect.innerHTML = '<option value="">All Locations</option>';
            locationSelect.disabled = true; loader.classList.add('active');
            if (!state) { locationSelect.disabled = false; loader.classList.remove('active'); return; }
            fetch('<?php echo e(route("alerts.locations-by-state")); ?>?state=' + encodeURIComponent(state), { headers: {'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} })
                .then(r => r.json()).then(locs => { locationSelect.innerHTML = '<option value="">All Locations</option>'; locs.forEach(loc => { const o = document.createElement('option'); o.value = loc; o.textContent = loc; if (loc === preselectedLocation && state === preselectedState) o.selected = true; locationSelect.appendChild(o); }); })
                .catch(() => { locationSelect.innerHTML = '<option value="">All Locations</option>'; })
                .finally(() => { locationSelect.disabled = false; loader.classList.remove('active'); });
        });
        if (preselectedState) stateSelect.dispatchEvent(new Event('change'));
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('preview-img')) {
            document.getElementById('previewImage').src = e.target.dataset.full;
            new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
        }
    });
});


</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\alerts\fire.blade.php ENDPATH**/ ?>