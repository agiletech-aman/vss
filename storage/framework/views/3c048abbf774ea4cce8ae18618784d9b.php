<?php $__env->startSection('title','NMS — Regions'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('nms.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="nms">
<?php echo $__env->make('nms.partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="nms-kpi-row" style="grid-template-columns:repeat(5,1fr);margin-bottom:18px;">
    <div class="nms-kpi k-navy"><div class="nms-kpi-lbl">Total Regions</div><div class="nms-kpi-val" id="kR">—</div></div>
    <div class="nms-kpi k-orange"><div class="nms-kpi-lbl">Warehouses</div><div class="nms-kpi-val" id="kWh">—</div></div>
    <div class="nms-kpi k-blue"><div class="nms-kpi-lbl">Total Devices</div><div class="nms-kpi-val" id="kTotal">—</div></div>
    <div class="nms-kpi k-green"><div class="nms-kpi-lbl">Online Devices</div><div class="nms-kpi-val" id="kOn">—</div></div>
    <div class="nms-kpi k-red"><div class="nms-kpi-lbl">Offline Devices</div><div class="nms-kpi-val" id="kOff">—</div></div>
</div>

<div class="nms-filters">
    <div class="nms-filter-item">
        <label class="nms-filter-lbl">Search</label>
        <input type="text" class="nms-filter-inp" id="fS" placeholder="Region name…" oninput="render()">
    </div>
    <div class="nms-filter-item">
        <label class="nms-filter-lbl">Status</label>
        <select class="nms-filter-sel" id="fSt" onchange="render()">
            <option value="">All</option>
            <option value="Healthy">Healthy</option>
            <option value="Partial">Partial</option>
            <option value="Down">Down</option>
        </select>
    </div>
    <div style="margin-left:auto;font-size:12px;color:var(--muted);font-weight:600;align-self:center;" id="cnt"></div>
</div>

<div class="nms-card">
    <div class="nms-card-hdr">
        <div class="nms-card-title"><i class="ri-map-pin-2-line"></i> Regions</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="nms-tbl">
            <thead>
                <tr>
                    <th>Region Name</th>
                    <th>Total Devices</th>
                    <th>Online</th>
                    <th>Offline</th>
                </tr>
            </thead>
            <tbody id="tbl">
                <tr><td colspan="4" class="nms-loader"><div class="nms-spinner"></div> Loading…</td></tr>
            </tbody>
        </table>
    </div>
</div>
</div>

<span id="regionDetailBase" style="display:none;"><?php echo e(route('nms.pages.region.detail', '')); ?></span>

<script>
const NMS         = '<?php echo e($nmsBase); ?>';
const REGION_BASE = document.getElementById('regionDetailBase').textContent.trim();
const g   = id => document.getElementById(id);
const fN  = n  => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const col = p  => p>=80 ? 'var(--green)' : p>=50 ? 'var(--amber)' : 'var(--red)';
const blb = p  => p>=80 ? 'Healthy' : p>=50 ? 'Partial' : 'Down';
let all = [];

async function load() {
    try {
        const [sR, rR] = await Promise.all([
            fetch(NMS + '/summary'),
            fetch(NMS + '/regions'),
        ]);
        const s = sR.ok ? (await sR.json()).data || {} : {};
        all     = rR.ok ? (await rR.json()).data || [] : [];

        g('kR').textContent     = all.length;
        g('kOn').textContent    = fN(s.online_devices   ?? 0);
        g('kOff').textContent   = fN(s.offline_devices  ?? 0);
        g('kWh').textContent    = fN(s.total_warehouses ?? 0);
        g('kTotal').textContent = fN(s.total_devices ?? (s.online_devices??0)+(s.offline_devices??0));

        const nav = document.getElementById('nmsNavTime');
        if (nav) nav.textContent = 'Updated ' + new Date().toLocaleTimeString('en-IN', {hour:'2-digit', minute:'2-digit'});
        render();
    } catch(e) {
        g('tbl').innerHTML = '<tr><td colspan="4" style="text-align:center;padding:2rem;color:var(--red);">Failed to load</td></tr>';
    }
}

function render() {
    const q  = g('fS').value.toLowerCase().trim();
    const st = g('fSt').value;
    let list = [...all].sort((a,b) => (b.offline_devices||b.offline_cameras||0) - (a.offline_devices||a.offline_cameras||0));
    if (q)  list = list.filter(r => r.region_name.toLowerCase().includes(q));
    if (st) list = list.filter(r => {
        const camT=r.total_cameras||0, camOn=r.online_cameras||0;
        const p = camT>0?Math.round(camOn/camT*100):Math.round(r.uptime_pct||0);
        return blb(p) === st;
    });
    g('cnt').textContent = list.length + ' regions';
    const tbody = g('tbl');
    if (!list.length) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:2rem;color:var(--muted);">No regions found</td></tr>';
        return;
    }
    tbody.innerHTML = list.map(r => {
        const url = REGION_BASE + '/' + encodeURIComponent(r.region_name);
        return '<tr style="cursor:pointer;" onclick="location.href=\'' + url + '\'">'
            + '<td style="font-weight:700;font-size:13px;">' + r.region_name + '</td>'
            + '<td style="font-family:IBM Plex Mono,monospace;font-weight:700;font-size:14px;">'  + fN(r.total_devices   ?? 0) + '</td>'
            + '<td style="font-family:IBM Plex Mono,monospace;font-weight:700;font-size:14px;color:#059669;">' + fN(r.online_devices  ?? 0) + '</td>'
            + '<td style="font-family:IBM Plex Mono,monospace;font-weight:700;font-size:14px;color:#dc2626;">'  + fN(r.offline_devices ?? 0) + '</td>'

            + '</tr>';
    }).join('');
}

load();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\nms\regions.blade.php ENDPATH**/ ?>