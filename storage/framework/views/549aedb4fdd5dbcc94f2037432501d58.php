<?php $__env->startSection('title', 'API Data Monitor'); ?>
<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root{--bg:#f0f2f8;--card:#fff;--text:#0f172a;--muted:#94a3b8;--border:#e2e8f0;
--green:#059669;--green-l:#ecfdf5;--green-b:#a7f3d0;
--red:#dc2626;--red-l:#fef2f2;--red-b:#fecaca;
--orange:#d97706;--orange-l:#fffbeb;--orange-b:#fde68a;
--blue:#2563eb;--blue-l:#eff6ff;--blue-b:#bfdbfe;
--r:12px}
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',-apple-system,sans-serif}
.am{background:var(--bg);padding-bottom:48px}

/* Hero */
.am-hero{background:linear-gradient(135deg,#0c1445,#1e3a8a);border-radius:16px;padding:24px 28px;margin-bottom:20px;color:#fff;position:relative;overflow:hidden}
.am-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:rgba(99,102,241,.12)}
.am-hero-title{font-size:22px;font-weight:900;letter-spacing:-.4px;position:relative;z-index:1}
.am-hero-sub{font-size:12px;color:rgba(255,255,255,.5);margin-top:4px;position:relative;z-index:1}

/* Summary strip */
.am-strip{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px;margin-bottom:20px;position:relative;z-index:1}
.am-kpi{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:12px 16px;text-align:center}
.am-kpi-val{font-family:'IBM Plex Mono',monospace;font-size:26px;font-weight:800;line-height:1;color:#fff}
.am-kpi-lbl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.45);margin-top:4px}

/* Controls */
.am-controls{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:16px}
.am-search{padding:8px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;background:#fff;color:var(--text);outline:none;width:240px}
.am-search:focus{border-color:var(--blue)}
.am-filter-btn{padding:7px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:12px;font-weight:700;background:#fff;color:var(--muted);cursor:pointer;transition:all .15s}
.am-filter-btn.active{background:var(--blue);color:#fff;border-color:var(--blue)}
.am-refresh{margin-left:auto;display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--blue);color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s}
.am-refresh:hover{background:#1d4ed8}
.am-refresh-ico{animation:none}.am-refresh-ico.spin{animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

/* API source cards */
.am-grid{display:grid;grid-template-columns:1fr;gap:14px}
.am-api-card{background:#fff;border:1.5px solid var(--border);border-radius:var(--r);overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.04)}
.am-api-hdr{display:flex;align-items:center;gap:12px;padding:14px 18px;border-bottom:1.5px solid var(--border);background:#f8fafc}
.am-api-ico{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.am-api-name{font-size:13px;font-weight:800;color:var(--text)}
.am-api-url{font-size:10.5px;color:var(--muted);margin-top:2px;font-family:'IBM Plex Mono',monospace}
.am-api-status{margin-left:auto;display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;border:1.5px solid}
.st-ok   {background:var(--green-l);color:var(--green);border-color:var(--green-b)}
.st-warn {background:var(--orange-l);color:var(--orange);border-color:var(--orange-b)}
.st-err  {background:var(--red-l);color:var(--red);border-color:var(--red-b)}
.st-load {background:#f1f5f9;color:var(--muted);border-color:var(--border)}
.am-api-latency{font-size:11px;color:var(--muted);font-family:'IBM Plex Mono',monospace}

/* Location table */
.am-tbl-wrap{max-height:340px;overflow-y:auto}
.am-tbl{width:100%;border-collapse:collapse}
.am-tbl thead th{background:#f8fafc;color:var(--muted);font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 14px;border-bottom:1.5px solid var(--border);text-align:left;white-space:nowrap;position:sticky;top:0;z-index:1}
.am-tbl tbody td{padding:9px 14px;font-size:12px;border-bottom:1px solid #f0f4f8;color:var(--text);vertical-align:middle}
.am-tbl tbody tr:last-child td{border-bottom:none}
.am-tbl tbody tr:hover td{background:#fafbfc}

/* Status dot */
.st-dot{width:8px;height:8px;border-radius:50%;display:inline-block;flex-shrink:0}
.dot-ok  {background:#22c55e}
.dot-warn{background:#f59e0b}
.dot-err {background:#ef4444}
.dot-none{background:#cbd5e1}

/* Freshness badge */
.fresh-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;border:1.5px solid}

/* Loader */
.am-loader{display:flex;align-items:center;justify-content:center;padding:32px;gap:8px;color:var(--muted);font-size:12px;font-weight:600}
.am-spin{width:16px;height:16px;border:2.5px solid var(--border);border-top-color:var(--blue);border-radius:50%;animation:spin .7s linear infinite}
.am-empty{text-align:center;padding:28px;color:var(--muted);font-size:12px;font-weight:600}
.am-empty i{font-size:24px;display:block;margin-bottom:8px;opacity:.3}
</style>

<div class="am">


<div class="am-hero">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:10px">
        <div>
            <div class="am-hero-title"><i class="ri-pulse-line" style="margin-right:8px"></i>API Data Monitor</div>
            <div class="am-hero-sub">Track daily data freshness across all locations and external APIs</div>
        </div>
        <div style="font-size:11px;color:rgba(255,255,255,.4);position:relative;z-index:1">
            Last checked: <span id="lastChecked" style="color:rgba(255,255,255,.7)">—</span>
        </div>
    </div>
    <div class="am-strip" style="margin-top:18px">
        <div class="am-kpi"><div class="am-kpi-val" id="kTotal">—</div><div class="am-kpi-lbl">Total Locations</div></div>
        <div class="am-kpi"><div class="am-kpi-val" style="color:#22c55e" id="kFresh">—</div><div class="am-kpi-lbl">Fresh Today</div></div>
        <div class="am-kpi"><div class="am-kpi-val" style="color:#f59e0b" id="kStale">—</div><div class="am-kpi-lbl">Stale / Old</div></div>
        <div class="am-kpi"><div class="am-kpi-val" style="color:#ef4444" id="kMissing">—</div><div class="am-kpi-lbl">No Data</div></div>
        <div class="am-kpi"><div class="am-kpi-val" id="kApis">5</div><div class="am-kpi-lbl">APIs Monitored</div></div>
    </div>
</div>


<div class="am-controls">
    <input type="text" class="am-search" id="locSearch" placeholder="Search location…" oninput="filterLocs()">
    <button class="am-filter-btn active" onclick="setFilter('all',this)">All</button>
    <button class="am-filter-btn" onclick="setFilter('fresh',this)">Fresh</button>
    <button class="am-filter-btn" onclick="setFilter('stale',this)">Stale</button>
    <button class="am-filter-btn" onclick="setFilter('missing',this)">No Data</button>
    <button class="am-refresh" onclick="runChecks()">
        <i class="ri-refresh-line am-refresh-ico" id="refreshIco"></i> Refresh All
    </button>
</div>


<div class="am-grid" id="apiGrid">
    <div class="am-loader"><div class="am-spin"></div> Running checks…</div>
</div>

</div>

<script>
const NMS_BASE  = '<?php echo e($nmsBase ?? "https://nms.cwcnewcctv.in/api/nms/v1"); ?>';
const FRS_BASE_RAW  = '<?php echo e($frsBase ?? "https://frsbag.cwcnewiot.in"); ?>';
const SACK_BASE_RAW = '<?php echo e($sackBase ?? "https://frsbag.cwcnewiot.in"); ?>';
/* Strip any trailing /frs or /sack added by controller config */
const FRS_BASE  = FRS_BASE_RAW.replace(/\/frs$/, '');
const SACK_BASE = SACK_BASE_RAW.replace(/\/sack$/, '');
const IOT_BASE  = '<?php echo e($iotBase ?? "https://co2ph3master.ajeevi.in"); ?>';
const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const HDR       = {'Accept':'application/json','X-CSRF-TOKEN':CSRF};
const fN        = n => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const g         = id => document.getElementById(id);

let allResults = [];
let activeFilter = 'all';

/* ── API definitions ── */
const APIS = [
    {
        id: 'nms',
        name: 'NMS — Network Management',
        url: NMS_BASE + '/warehouses',
        icon: 'ri-router-line',
        color: '#3b82f6',
        bg: '#eff6ff',
        fetch: fetchNMS,
        desc: 'Warehouse device status (NVR, BTS, EPC, WS) — Fresh = API responding with data',
    },
    {
        id: 'frs',
        name: 'FRS — Face Recognition',
        url: FRS_BASE + '/frs/detection_logs',
        icon: 'ri-shield-user-line',
        color: '#7c3aed',
        bg: '#f5f3ff',
        fetch: fetchFRS,
        desc: 'Daily detection logs per warehouse',
    },
    {
        id: 'sack',
        name: 'Sack — Bag Counting',
        url: SACK_BASE + '/sack/data',
        icon: 'ri-shopping-bag-3-line',
        color: '#d97706',
        bg: '#fffbeb',
        fetch: fetchSack,
        desc: 'Daily bag IN/OUT movements per warehouse',
    },
    {
        id: 'iot_cam',
        name: 'IoT — Camera Alerts (Ajeevi)',
        url: IOT_BASE + '/api/camera-alerts',
        icon: 'ri-fire-line',
        color: '#dc2626',
        bg: '#fef2f2',
        fetch: fetchIotCam,
        desc: 'Fire / Smoke / Rodent alerts per location',
    },
    {
        id: 'iot_gas',
        name: 'IoT — Gas Sensors (Ajeevi)',
        url: IOT_BASE + '/api/master-alerts',
        icon: 'ri-cpu-line',
        color: '#059669',
        bg: '#ecfdf5',
        fetch: fetchIotGas,
        desc: 'CO₂ / PH₃ sensor readings per location',
    },
];

/* ── Freshness helper ── */
function freshness(dateStr, isLive) {
    if (isLive) return { label:'Live', cls:'st-ok', dot:'dot-ok', rank:0 };
    if (!dateStr) return { label:'No Data', cls:'st-err', dot:'dot-err', rank:2 };
    const d    = new Date(dateStr);
    const now  = new Date();
    const hrs  = (now - d) / 36e5;
    if (isNaN(hrs))  return { label:'No Data', cls:'st-err', dot:'dot-err', rank:2 };
    if (hrs <= 24)   return { label:'Today',   cls:'st-ok',  dot:'dot-ok',  rank:0, hrs };
    if (hrs <= 72)   return { label:Math.floor(hrs/24)+'d ago', cls:'st-warn', dot:'dot-warn', rank:1, hrs };
    return { label:Math.floor(hrs/24)+'d ago', cls:'st-err', dot:'dot-err', rank:2, hrs };
}

function ago(dateStr, isLive) {
    if (isLive) return 'Live';
    if (!dateStr) return '—';
    const d   = new Date(dateStr);
    const hrs = (new Date() - d) / 36e5;
    if (isNaN(hrs)) return '—';
    if (hrs < 0.1)  return 'Just now';
    if (hrs < 1)  return Math.round(hrs*60)+'m ago';
    if (hrs < 24) return Math.round(hrs)+'h ago';
    return Math.floor(hrs/24)+'d ago';
}

/* ── Individual API fetchers ── */
async function fetchNMS() {
    const t0 = Date.now();
    const r  = await fetch(NMS_BASE + '/warehouses');
    const j  = await r.json();
    const latency = Date.now() - t0;
    const whs = j.data || [];
    /* NMS API doesn't return timestamps per warehouse.
       Use polled_at from strip-summary or treat any responding warehouse as fresh today */
    const today = new Date().toISOString();
    const locs = whs.map(w => ({
        name:    w.warehouse_name,
        region:  w.region_name||'—',
        lastSeen: w.polled_at || w.updated_at || w.last_polled || today,
        isLive: !(w.polled_at || w.updated_at || w.last_polled),
        status:  w.status||'—',
        detail:  `NVR: ${w.nvr_online||0}/${w.nvr_total||0} · BTS: ${w.bts_online||0}/${w.bts_total||0} · Cam: ${w.online_cameras||0}/${w.total_cameras||0}`,
    }));
    return { latency, locs, total: locs.length };
}

async function fetchFRS() {
    const t0    = Date.now();
    const nmsR  = await fetch(NMS_BASE + '/warehouses');
    const nmsJ  = await nmsR.json();
    const nmsWhs= nmsJ.data || [];
    const HDR   = {'Accept':'application/json','X-CSRF-TOKEN':CSRF};

    const results = {};

    /* FRS API is accessible directly from browser — fetch 200 latest logs */
    try {
        const r    = await fetch(FRS_BASE + '/frs/detection_logs?limit=10000');
        const j    = r.ok ? await r.json() : {};
        const logs = j.logs || j.data || [];
        const norm = s => (s||'').toLowerCase().replace(/[^a-z0-9\s]/g,' ').replace(/\s+/g,' ').trim();
        const logMap = {};
        logs.forEach(l => {
            const k = norm(l.warehouse); if (!k) return;
            if (!logMap[k]) logMap[k] = { ts: l.timestamp, count: 0 };
            logMap[k].count++;
            if (new Date(l.timestamp) > new Date(logMap[k].ts)) logMap[k].ts = l.timestamp;
        });
        nmsWhs.forEach(w => {
            const k = norm(w.warehouse_name);
            let m   = logMap[k];
            if (!m) {
                const sig = k.split(' ').find(x => x.length > 3);
                if (sig) m = logMap[Object.keys(logMap).find(x => x.includes(sig))||''];
            }
            if (m) results[w.warehouse_id] = { ts: m.ts, total: m.count, isBulk: true };
        });
    } catch(e) {}

    const latency = Date.now() - t0;
    const locs = nmsWhs.map(w => {
        const r = results[w.warehouse_id];
        return {
            name:    w.warehouse_name,
            region:  w.region_name || '—',
            lastSeen: r?.ts || null,
            detail:   r ? `last detection: ${ago(r.ts)} · ${r.total||0} in batch` : 'No detections found',
        };
    }).sort((a,b) => new Date(b.lastSeen||0) - new Date(a.lastSeen||0));

    return { latency, locs, total: locs.length,
        note: `Fetching last 10,000 FRS logs. Warehouses with No Data have never sent detections (or data is older than the batch).` };
}

async function fetchSack() {
    const t0 = Date.now();
    const nmR = await fetch(NMS_BASE + '/warehouses');
    const nmJ = await nmR.json();
    const masters = nmJ.data || [];
    const HEADERS = {'Accept':'application/json','X-CSRF-TOKEN':CSRF};
    const map = {};
    let successCount = 0, errorCount = 0;

    /* Sample first 5 warehouses to test connectivity */
    const sample = masters.slice(0, 1); /* test just 1 to check connectivity */
    await Promise.allSettled(sample.map(async w => {
        try {
            const url = `/api/proxy/sack?region_id=${w.region_id||''}&warehouse_id=${w.warehouse_id}`;
            const r   = await fetch(url, {headers: HEADERS});
            if (r.status === 502 || r.status === 503 || r.status === 504) {
                errorCount++; return;
            }
            if (!r.ok) { errorCount++; return; }
            const j   = await r.json();
            const rows = Array.isArray(j) ? j : (j.data || []);
            successCount++;
            if (rows.length) {
                const ts = rows[0]?.transaction_time || rows[0]?.DateTime_of_action || rows[0]?.created_at;
                if (ts) map[w.warehouse_id] = { ts, totalIn: rows[0]?.Total_In||0, totalOut: rows[0]?.Total_Out||0 };
            }
        } catch(e) { errorCount++; }
    }));

    const latency = Date.now() - t0;

    /* If all samples failed, sack backend is down */
    if (successCount === 0 && errorCount > 0) {
        throw new Error(`Sack backend returning errors (${errorCount}/${sample.length} failed)`);
    }

    const locs = masters.map(w => ({
        name:    w.warehouse_name,
        region:  w.region_name||'—',
        lastSeen: map[w.warehouse_id]?.ts || null,
        detail:  map[w.warehouse_id]
            ? `IN: ${fN(map[w.warehouse_id].totalIn)} · OUT: ${fN(map[w.warehouse_id].totalOut)}`
            : (sample.find(s=>s.warehouse_id===w.warehouse_id) ? 'No movements' : 'Not sampled'),
    }));
    return { latency, locs, total: locs.length };
}

async function fetchIotCam() {
    const t0 = Date.now();
    const r  = await fetch(IOT_BASE + '/api/camera-alerts?pageNumber=1&pageSize=1000');
    const j  = await r.json();
    const latency = Date.now() - t0;
    const rows = j.data || [];

    const map = {};
    rows.forEach(a => {
        if (!a.locationName || a.locationName.trim()==='' || a.locationName==='—') return;
        const k = a.locationName.trim();
        const ts = a.alertDateTime || a.regDate;
        if (!map[k] || new Date(ts) > new Date(map[k].lastSeen)) {
            map[k] = {
                name: k,
                region: a.state||'—',
                lastSeen: ts,
                detail: `${rows.filter(x=>x.locationName===k).length} alerts`,
            };
        }
    });
    const locs = Object.values(map);
    return { latency, locs, total: locs.length };
}

async function fetchIotGas() {
    const t0 = Date.now();
    const r  = await fetch(IOT_BASE + '/api/master-alerts?pageNumber=1&pageSize=1000');
    const j  = await r.json();
    const latency = Date.now() - t0;
    const rows = Array.isArray(j) ? j : (j.data || []);

    const map = {};
    rows.forEach(a => {
        if (!a.locationName || a.locationName.trim()==='' || a.locationName==='—') return;
        const k = a.locationName.trim();
        const ts = a.recordTime || a.regDate;
        if (!map[k] || new Date(ts) > new Date(map[k].lastSeen)) {
            map[k] = {
                name: k,
                region: a.state||a.city||'—',
                lastSeen: ts,
                detail: `${rows.filter(x=>x.locationName===k).length} readings`,
            };
        }
    });
    const locs = Object.values(map);
    return { latency, locs, total: locs.length };
}

/* ── Render ── */
function renderCard(api, result, error) {
    const { latency, locs = [], total = 0 } = result || {};
    const fresh   = locs.filter(l => freshness(l.lastSeen, l.isLive).rank === 0).length;
    const stale   = locs.filter(l => freshness(l.lastSeen, l.isLive).rank === 1).length;
    const missing = locs.filter(l => freshness(l.lastSeen, l.isLive).rank === 2).length;

    const overallStatus = error ? 'err' : fresh === total && total > 0 ? 'ok' : stale > 0 || missing > 0 ? 'warn' : 'ok';
    const statusLabel   = error
        ? (error.includes('backend') ? '⚠ Backend Down' : 'API Error')
        : overallStatus === 'ok' ? 'All Fresh' : `${missing} Missing · ${stale} Stale`;
    const statusCls     = error ? 'st-err' : overallStatus === 'ok' ? 'st-ok' : 'st-warn';

    /* filter locs */
    const q = (g('locSearch')?.value||'').toLowerCase().trim();
    let filtered = locs;
    if (q) filtered = filtered.filter(l => l.name.toLowerCase().includes(q) || l.region.toLowerCase().includes(q));
    if (activeFilter === 'fresh')   filtered = filtered.filter(l => freshness(l.lastSeen).rank === 0);
    if (activeFilter === 'stale')   filtered = filtered.filter(l => freshness(l.lastSeen).rank === 1);
    if (activeFilter === 'missing') filtered = filtered.filter(l => freshness(l.lastSeen).rank === 2);

    const rows = filtered.length ? filtered.map(l => {
        const f = freshness(l.lastSeen, l.isLive);
        return `<tr>
            <td>
                <div style="display:flex;align-items:center;gap:7px">
                    <span class="st-dot ${f.dot}"></span>
                    <span style="font-weight:700">${l.name}</span>
                </div>
            </td>
            <td style="color:var(--muted);font-size:11.5px">${l.region}</td>
            <td>
                <span class="fresh-badge ${f.cls}">${f.label}</span>
            </td>
            <td style="color:var(--muted);font-size:11px;font-family:'IBM Plex Mono',monospace">${ago(l.lastSeen, l.isLive)}</td>
            <td style="color:var(--muted);font-size:11px">${l.detail||'—'}</td>
        </tr>`;
    }).join('') : `<tr><td colspan="5"><div class="am-empty"><i class="ri-checkbox-circle-line"></i>${q||activeFilter!=='all'?'No matching locations':'No data received'}</div></td></tr>`;

    const am_tbl_body = error
        ? `<tr><td colspan="5"><div class="am-empty">
                <i class="ri-close-circle-line" style="color:#ef4444"></i>
                <div style="color:#dc2626;font-weight:700;margin-bottom:4px">API Unavailable</div>
                <div style="font-size:11px;color:var(--muted)">${error}</div>
           </div></td></tr>`
        : rows;

    return `<div class="am-api-card" id="card-${api.id}">
        <div class="am-api-hdr">
            <div class="am-api-ico" style="background:${api.bg};color:${api.color}"><i class="${api.icon}"></i></div>
            <div>
                <div class="am-api-name">${api.name}</div>
                <div class="am-api-url">${api.url.replace('https://','')}</div>
            </div>
            <div style="margin-left:auto;display:flex;align-items:center;gap:10px">
                ${latency!=null?`<span class="am-api-latency">${latency}ms</span>`:''}
                <div class="am-api-status ${statusCls}">${error?'<i class="ri-close-circle-line"></i>':'<i class="ri-checkbox-circle-line"></i>'} ${statusLabel}</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;padding:10px 18px;background:#f8fafc;border-bottom:1.5px solid var(--border);flex-wrap:wrap">
            <span style="font-size:11px;font-weight:600;color:var(--muted)">${api.desc}${result?.note ? ' · <i>'+result.note+'</i>' : ''}</span>
            <span style="margin-left:auto;display:flex;gap:12px">
                <span style="font-size:11px;font-weight:700;color:#059669"><i class="ri-checkbox-circle-line"></i> ${fresh} fresh</span>
                <span style="font-size:11px;font-weight:700;color:#f59e0b"><i class="ri-time-line"></i> ${stale} stale</span>
                <span style="font-size:11px;font-weight:700;color:#dc2626"><i class="ri-close-circle-line"></i> ${missing} missing</span>
                <span style="font-size:11px;font-weight:700;color:var(--muted)">Total: ${total}</span>
            </span>
        </div>
        <div class="am-tbl-wrap">
            <table class="am-tbl">
                <thead><tr>
                    <th>Location</th>
                    <th>Region</th>
                    <th>Status</th>
                    <th>Last Data</th>
                    <th>Details</th>
                </tr></thead>
                <tbody>${am_tbl_body}</tbody>
            </table>
        </div>
    </div>`;
}

/* ── Run all checks ── */
async function runChecks() {
    const ico = g('refreshIco');
    ico.classList.add('spin');
    g('apiGrid').innerHTML = '<div class="am-loader"><div class="am-spin"></div> Checking all APIs…</div>';

    const results = await Promise.allSettled(APIS.map(async api => {
        try {
            const data = await api.fetch();
            return { api, data, error: null };
        } catch(e) {
            return { api, data: null, error: e.message };
        }
    }));

    /* Compute global stats */
    let totalLocs = 0, freshCount = 0, staleCount = 0, missingCount = 0;
    const rendered = results.map(r => {
        const { api, data, error } = r.value || { api: r.reason?.api, data: null, error: r.reason?.message };
        const locs = data?.locs || [];
        totalLocs = Math.max(totalLocs, locs.length);
        locs.forEach(l => {
            const f = freshness(l.lastSeen);
            if (f.rank === 0) freshCount++;
            else if (f.rank === 1) staleCount++;
            else missingCount++;
        });
        return renderCard(api, data, error);
    });

    g('kTotal').textContent   = fN(totalLocs);
    g('kFresh').textContent   = fN(freshCount);
    g('kStale').textContent   = fN(staleCount);
    g('kMissing').textContent = fN(missingCount);
    g('lastChecked').textContent = new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit'});

    g('apiGrid').innerHTML = rendered.join('');
    allResults = results.map(r => r.value || {});
    ico.classList.remove('spin');
}

function filterLocs() { rerenderAll(); }

function setFilter(f, btn) {
    activeFilter = f;
    document.querySelectorAll('.am-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    rerenderAll();
}

function rerenderAll() {
    if (!allResults.length) return;
    g('apiGrid').innerHTML = allResults.map(r =>
        renderCard(r.api, r.data, r.error)
    ).join('');
}

/* Auto-run on load */
runChecks();

/* Auto-refresh every 5 minutes */
setInterval(runChecks, 5 * 60 * 1000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\nms\api-monitor.blade.php ENDPATH**/ ?>