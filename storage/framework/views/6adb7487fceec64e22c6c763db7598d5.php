<?php $__env->startSection('title', 'Poll History'); ?>
<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
.page-content { background: #f0f2f7 !important; }
.page-header { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:24px; flex-wrap:wrap; }
.page-header-left { display:flex; align-items:center; gap:14px; }
.page-back-btn { display:inline-flex; align-items:center; gap:8px; background:#fff; color:#1e293b; font-size:13px; font-weight:600; padding:10px 16px; border-radius:10px; border:1px solid #e2e8f0; text-decoration:none; transition:all .2s; box-shadow:0 2px 8px rgba(0,0,0,.04); }
.page-back-btn:hover { background:#f8fafc; text-decoration:none; transform:translateY(-1px); }
.page-header-icon { width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg,#1e3a8a,#3b82f6); display:flex; align-items:center; justify-content:center; font-size:22px; color:#fff; box-shadow:0 6px 16px rgba(30,58,138,.30); }
.page-header-text h4 { font-size:20px; font-weight:800; color:#1e293b; margin:0; }
.page-header-text span { font-size:12px; color:#94a3b8; font-weight:500; }

/* Filter */
.filter-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:20px 24px; margin-bottom:20px; }
.filter-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; margin-bottom:6px; display:block; }
.filter-card .form-select, .filter-card .form-control { border:1px solid #e2e8f0; border-radius:10px; font-size:13px; color:#1e293b; height:40px; background:#f8fafc; }
.filter-card .form-select:focus, .filter-card .form-control:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.12); background:#fff; }
.btn-search { background:linear-gradient(135deg,#1e3a8a,#3b82f6); border:none; border-radius:10px; font-size:13px; font-weight:600; height:40px; color:#fff; padding:0 20px; cursor:pointer; transition:all .2s; }
.btn-search:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(59,130,246,.3); }
.btn-reset { border:1px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; height:40px; color:#64748b; background:#f8fafc; display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:0 16px; }
.btn-reset:hover { background:#f1f5f9; color:#1e293b; }
.btn-export { display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg,#065f46,#10b981); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:600; height:40px; padding:0 16px; cursor:pointer; transition:all .2s; }
.btn-export:hover { transform:translateY(-1px); color:#fff; }

/* Table */
.table-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.table-card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.table-card-title { font-size:14px; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:8px; }
.table-card-title i { color:#3b82f6; }
.badge-count { font-size:11px; font-weight:600; color:#64748b; background:#f1f5f9; padding:4px 10px; border-radius:20px; }

#pollTable { width:100%; border-collapse:collapse; }
#pollTable thead th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0; padding:12px 16px; white-space:nowrap; text-align:left; }
#pollTable tbody td { font-size:13px; color:#334155; padding:11px 16px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
#pollTable tbody tr:hover { background:#f8fafc; }
#pollTable tbody tr:last-child td { border-bottom:none; }

.status-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.status-online  { background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; }
.status-offline { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
.device-type-badge { font-size:10px; font-weight:700; padding:2px 8px; border-radius:6px; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
.mono { font-family:'IBM Plex Mono',monospace; font-size:12px; }

/* Pagination */
.pagination-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid #f1f5f9; flex-wrap:wrap; gap:10px; }
.pagination-info { font-size:12px; color:#94a3b8; font-weight:600; }
.pagination-btns { display:flex; gap:4px; }
.page-btn { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#fff; color:#64748b; font-size:12px; font-weight:600; cursor:pointer; transition:all .15s; text-decoration:none; }
.page-btn:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
.page-btn.active { background:linear-gradient(135deg,#1e3a8a,#3b82f6); color:#fff; border-color:transparent; }
.page-btn.disabled { opacity:.4; pointer-events:none; }

/* Loading */
.loading-row td { text-align:center; padding:40px; color:#94a3b8; font-size:13px; }
.spinner { display:inline-block; width:18px; height:18px; border:2.5px solid #e2e8f0; border-top-color:#3b82f6; border-radius:50%; animation:spin .7s linear infinite; vertical-align:middle; margin-right:8px; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>


<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-icon"><i class="ri-history-line"></i></div>
        <div class="page-header-text">
            <h4>Poll History</h4>
            <span>Device polling logs — online/offline status over time</span>
        </div>
    </div>
    <a href="<?php echo e(route('nms.pages.dashboard')); ?>" class="page-back-btn">
        <i class="ri-arrow-left-line"></i> Back to NMS
    </a>
</div>


<div class="filter-card">
    <div class="row g-2 align-items-end">
        <div class="col-md-2">
            <label class="filter-label">Region</label>
            <select id="filterRegion" class="form-select">
                <option value="">All Regions</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">Warehouse</label>
            <select id="filterWarehouse" class="form-select" disabled>
                <option value="">All Warehouses</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">Device Type</label>
            <select id="filterType" class="form-select">
                <option value="">All Types</option>
                <option value="NVR">NVR</option>
                <option value="BTS">BTS</option>
                <option value="Workstation">Workstation</option>
                <option value="Embedded PC">Embedded PC</option>

            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">Status</label>
            <select id="filterStatus" class="form-select">
                <option value="">All</option>
                <option value="Online">Online</option>
                <option value="Offline">Offline</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">From Date</label>
            <input type="date" id="filterFrom" class="form-control" value="<?php echo e(date('Y-m-d', strtotime('-7 days'))); ?>">
        </div>
        <div class="col-md-2">
            <label class="filter-label">To Date</label>
            <input type="date" id="filterTo" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
        </div>
        <div class="col-md-auto mt-2">
            <button class="btn-search" onclick="applyFilter()"><i class="ri-search-line"></i> Search</button>
        </div>
        <div class="col-md-auto mt-2">
            <a href="#" class="btn-reset" onclick="resetFilter();return false;"><i class="ri-refresh-line"></i> Reset</a>
        </div>
        <div class="col-md-auto mt-2">
            <button class="btn-export" onclick="exportCSV()"><i class="ri-file-excel-line"></i> Export CSV</button>
        </div>
    </div>
</div>


<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title"><i class="ri-pulse-line"></i> Device Poll Logs</div>
        <span class="badge-count" id="pollCount">Loading…</span>
    </div>
    <div style="overflow-x:auto">
        <table id="pollTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date & Time</th>
                    <th>Device</th>
                    <th>Type</th>
                    <th>IP Address</th>
                    <th>Region</th>
                    <th>Warehouse</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="pollBody">
                <tr class="loading-row"><td colspan="8"><span class="spinner"></span>Loading poll history…</td></tr>
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap" id="paginationWrap" style="display:none">
        <div class="pagination-info" id="paginationInfo"></div>
        <div class="pagination-btns" id="paginationBtns"></div>
    </div>
</div>

<script>
const NMS_BASE   = '<?php echo e(config("external-apis.nms_base", "https://nms.cwcnewcctv.in/api/nms/v1")); ?>';
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
const fmtDt = ts => { if(!ts)return'—'; const d=new Date(ts); const p=n=>String(n).padStart(2,'0'); return `${p(d.getDate())}-${p(d.getMonth()+1)}-${d.getFullYear()} ${p(d.getHours())}:${p(d.getMinutes())}:${p(d.getSeconds())}`; };

let currentPage = 1, lastMeta = {}, allWarehouses = [];

/* ── Load region/warehouse dropdowns ── */
async function loadDropdowns() {
    try {
        const [rR, wR] = await Promise.all([
            fetch(`${NMS_BASE}/regions`).then(r=>r.json()),
            fetch(`${NMS_BASE}/warehouses`).then(r=>r.json()),
        ]);
        const regions    = rR.data || [];
        allWarehouses    = wR.data || [];

        const rSel = document.getElementById('filterRegion');
        regions.forEach(r => rSel.innerHTML += `<option value="${r.region_id||r.id}">${r.region_name||r.name}</option>`);

        rSel.addEventListener('change', function() {
            const wSel = document.getElementById('filterWarehouse');
            wSel.innerHTML = '<option value="">All Warehouses</option>';
            const filtered = allWarehouses.filter(w => w.region_id == this.value);
            filtered.forEach(w => wSel.innerHTML += `<option value="${w.warehouse_id}">${w.warehouse_name}</option>`);
            wSel.disabled = filtered.length === 0;
        });
    } catch(e) { console.error('Dropdown load error:', e); }
}

/* ── Fetch poll history ── */
async function loadPollHistory(page = 1) {
    document.getElementById('pollBody').innerHTML = '<tr class="loading-row"><td colspan="8"><span class="spinner"></span>Loading…</td></tr>';
    document.getElementById('paginationWrap').style.display = 'none';

    const params = new URLSearchParams({ page, per_page: 50 });
    const rid   = document.getElementById('filterRegion').value;
    const wid   = document.getElementById('filterWarehouse').value;
    const type  = document.getElementById('filterType').value;
    const status= document.getElementById('filterStatus').value;
    const from  = document.getElementById('filterFrom').value;
    const to    = document.getElementById('filterTo').value;

    if (rid)    params.set('region_id', rid);
    if (wid)    params.set('warehouse_id', wid);
    if (type)   params.set('device_type', type);
    if (status) params.set('status', status);
    if (from)   params.set('from_date', from);
    if (to)     params.set('to_date', to);

    try {
        const resp = await fetch(`${NMS_BASE}/poll-history?${params}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
        });
        const json = await resp.json();
        const data = json.data || [];
        lastMeta   = json.meta || {};
        currentPage = page;

        document.getElementById('pollCount').textContent =
            lastMeta.total ? `${lastMeta.total.toLocaleString('en-IN')} records` : `${data.length} records`;

        if (!data.length) {
            document.getElementById('pollBody').innerHTML = '<tr class="loading-row"><td colspan="8" style="color:#94a3b8">No records found</td></tr>';
            return;
        }

        const offset = ((page - 1) * (lastMeta.per_page || 50));
        document.getElementById('pollBody').innerHTML = data.map((r, i) => `
            <tr>
                <td class="mono" style="color:#94a3b8">${offset + i + 1}</td>
                <td class="mono" style="white-space:nowrap">${fmtDt(r.time)}</td>
                <td style="font-weight:600">${r.device_name || '—'}</td>
                <td><span class="device-type-badge">${r.device_type || '—'}</span></td>
                <td class="mono" style="color:#64748b">${r.ip_address || '—'}</td>
                <td>${r.region_name || '—'}</td>
                <td style="font-weight:600">${r.warehouse_name || '—'}</td>
                <td><span class="status-badge ${r.status === 'Online' ? 'status-online' : 'status-offline'}">
                    <i class="ri-circle-fill" style="font-size:6px"></i> ${r.status || '—'}
                </span></td>
            </tr>`).join('');

        renderPagination();
    } catch(e) {
        console.error(e);
        document.getElementById('pollBody').innerHTML = `<tr class="loading-row"><td colspan="8" style="color:#ef4444">Error: ${e.message}</td></tr>`;
    }
}

/* ── Pagination ── */
function renderPagination() {
    const { total, per_page, current_page, last_page, from_date, to_date } = lastMeta;
    if (!last_page || last_page <= 1) { document.getElementById('paginationWrap').style.display = 'none'; return; }
    document.getElementById('paginationWrap').style.display = 'flex';

    const from = ((current_page - 1) * per_page) + 1;
    const to   = Math.min(current_page * per_page, total);
    document.getElementById('paginationInfo').textContent = `Showing ${from.toLocaleString('en-IN')} – ${to.toLocaleString('en-IN')} of ${total.toLocaleString('en-IN')} records`;

    const btns = document.getElementById('paginationBtns');
    btns.innerHTML = '';
    const addBtn = (label, page, active=false, disabled=false) => {
        const b = document.createElement('a');
        b.href = '#'; b.className = 'page-btn'+(active?' active':'')+(disabled?' disabled':'');
        b.innerHTML = label;
        if (!disabled && !active) b.onclick = e => { e.preventDefault(); loadPollHistory(page); };
        btns.appendChild(b);
    };

    addBtn('<i class="ri-arrow-left-s-line"></i>', current_page - 1, false, current_page === 1);

    let start = Math.max(1, current_page - 2), end = Math.min(last_page, current_page + 2);
    if (start > 1) { addBtn('1', 1); if (start > 2) btns.innerHTML += '<span style="padding:0 4px;color:#94a3b8;align-self:center">…</span>'; }
    for (let p = start; p <= end; p++) addBtn(p, p, p === current_page);
    if (end < last_page) { btns.innerHTML += '<span style="padding:0 4px;color:#94a3b8;align-self:center">…</span>'; addBtn(last_page, last_page); }

    addBtn('<i class="ri-arrow-right-s-line"></i>', current_page + 1, false, current_page === last_page);
}

/* ── Filter / Reset ── */
function applyFilter() { loadPollHistory(1); }
function resetFilter() {
    document.getElementById('filterRegion').value    = '';
    document.getElementById('filterWarehouse').value = '';
    document.getElementById('filterWarehouse').disabled = true;
    document.getElementById('filterType').value      = '';
    document.getElementById('filterStatus').value    = '';
    document.getElementById('filterFrom').value      = new Date(Date.now()-7*86400000).toISOString().slice(0,10);
    document.getElementById('filterTo').value        = new Date().toISOString().slice(0,10);
    loadPollHistory(1);
}

/* ── Export CSV ── */
async function exportCSV() {
    const btn = document.querySelector('.btn-export');
    btn.innerHTML = '<span class="spinner"></span> Exporting…';
    btn.disabled = true;

    const params = new URLSearchParams({ page: 1, per_page: 500 });
    const rid    = document.getElementById('filterRegion').value;
    const wid    = document.getElementById('filterWarehouse').value;
    const type   = document.getElementById('filterType').value;
    const status = document.getElementById('filterStatus').value;
    const from   = document.getElementById('filterFrom').value;
    const to     = document.getElementById('filterTo').value;
    if (rid)    params.set('region_id', rid);
    if (wid)    params.set('warehouse_id', wid);
    if (type)   params.set('device_type', type);
    if (status) params.set('status', status);
    if (from)   params.set('from_date', from);
    if (to)     params.set('to_date', to);

    try {
        const resp = await fetch(`${NMS_BASE}/poll-history?${params}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
        });
        const json = await resp.json();
        const data = json.data || [];

        const headers = ['#','Date & Time','Device','Type','IP Address','Region','Warehouse','Status'];
        const rows = [headers, ...data.map((r,i) => [
            i+1, r.time, r.device_name, r.device_type, r.ip_address, r.region_name, r.warehouse_name, r.status
        ])];
        const csv = rows.map(r => r.map(v => '"'+String(v||'').replace(/"/g,'""')+'"').join(',')).join('\n');
        const a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob(['\uFEFF'+csv], {type:'text/csv;charset=utf-8;'}));
        a.download = 'Poll_History_'+new Date().toISOString().slice(0,10)+'.csv';
        a.click();
    } catch(e) { alert('Export failed: '+e.message); }

    btn.innerHTML = '<i class="ri-file-excel-line"></i> Export CSV';
    btn.disabled = false;
}

/* ── Init ── */
loadDropdowns();
loadPollHistory(1);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\nms\poll_history.blade.php ENDPATH**/ ?>