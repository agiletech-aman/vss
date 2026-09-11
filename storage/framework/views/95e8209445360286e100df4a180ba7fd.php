<?php $__env->startSection('title', 'Warehouse Activity'); ?>
<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --bg:#f0f2f8;
    --text:#0f172a;--text-2:#475569;--muted:#94a3b8;
    --border:rgba(0,0,0,.08);--card:#fff;
    --blue:#2563eb;--blue-l:#eff6ff;--blue-b:#bfdbfe;--blue-d:#1d4ed8;
    --green:#059669;--green-l:#ecfdf5;--green-b:#a7f3d0;--green-d:#047857;
    --red:#dc2626;--red-l:#fef2f2;--red-b:#fecaca;--red-d:#b91c1c;
    --orange:#d97706;--orange-l:#fffbeb;--orange-b:#fde68a;--orange-d:#b45309;
    --teal:#0d9488;--teal-l:#f0fdfa;--teal-b:#99f6e4;--teal-d:#0f766e;
    --navy:#1e293b;--navy-l:#f1f5f9;--navy-b:#94a3b8;
    --r:16px;--sh:0 1px 3px rgba(0,0,0,.05);--sh-m:0 8px 32px rgba(0,0,0,.08);
}
*{box-sizing:border-box;margin:0;padding:0}
.ew{background:var(--bg);padding-bottom:56px;font-family:'Inter',-apple-system,sans-serif;min-height:100vh}

/* ── Breadcrumb ── */
.ew-bc{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;padding-top:4px}
.ew-bc-trail{display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:var(--muted)}
.ew-bc-trail a{color:var(--blue);text-decoration:none;transition:opacity .15s}.ew-bc-trail a:hover{opacity:.7}
.ew-back{display:inline-flex;align-items:center;gap:5px;padding:7px 16px;background:#fff;border:1.5px solid var(--border);border-radius:10px;font-size:12px;font-weight:700;color:var(--text-2);text-decoration:none;transition:all .15s;box-shadow:0 1px 2px rgba(0,0,0,.04)}
.ew-back:hover{background:var(--navy);color:#fff;border-color:var(--navy)}

/* ── Outer card ── */
.ew-card{background:#fff;border-radius:20px;box-shadow:0 4px 24px rgba(0,0,0,.07),0 1px 2px rgba(0,0,0,.04);overflow:hidden;border:1px solid rgba(0,0,0,.06)}

/* ── Hero ── */
.ew-hero{position:relative;padding:28px 32px 0;overflow:hidden;
    background:linear-gradient(135deg,#0b1437 0%,#0f2057 40%,#1a3a8f 75%,#1e40af 100%)}
.ew-hero-orb1{position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,.3) 0%,transparent 70%)}
.ew-hero-orb2{position:absolute;bottom:-60px;left:20%;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(37,99,235,.2) 0%,transparent 70%)}
.ew-hero-orb3{position:absolute;top:20px;left:-40px;width:150px;height:150px;border-radius:50%;background:radial-gradient(circle,rgba(139,92,246,.15) 0%,transparent 70%)}

.ew-hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;flex-wrap:wrap;position:relative;z-index:2;margin-bottom:24px}
.ew-hero-l{display:flex;align-items:center;gap:16px}
.ew-hero-ico{width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;flex-shrink:0;backdrop-filter:blur(10px)}
.ew-hero-name{font-size:24px;font-weight:800;color:#fff;letter-spacing:-.5px;line-height:1.1}
.ew-hero-meta{display:flex;align-items:center;gap:14px;margin-top:6px;flex-wrap:wrap}
.ew-hero-meta span{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;color:rgba(255,255,255,.55);font-weight:500}
.ew-hero-meta i{font-size:12px}
.ew-status-badge{display:inline-flex;align-items:center;gap:7px;padding:6px 16px;border-radius:24px;font-size:12px;font-weight:700;border:1.5px solid;backdrop-filter:blur(10px);white-space:nowrap}
.ew-pulse{width:8px;height:8px;border-radius:50%;animation:ewPulse 2s infinite}
@keyframes ewPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.75)}}

/* ── KPI strip ── */
.ew-kpi-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:0;position:relative;z-index:2;border-top:1px solid rgba(255,255,255,.08)}
.ew-kpi{padding:16px 20px;text-align:center;position:relative;cursor:default;transition:background .2s}
.ew-kpi::after{content:'';position:absolute;right:0;top:20%;height:60%;width:1px;background:rgba(255,255,255,.08)}
.ew-kpi:last-child::after{display:none}
.ew-kpi:hover{background:rgba(255,255,255,.05)}
.ew-kpi-val{font-family:'IBM Plex Mono',monospace;font-size:1.5rem;font-weight:800;color:#fff;line-height:1;letter-spacing:-.5px}
.ew-kpi-lbl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.35);margin-top:5px}
.ew-kpi-sub{font-size:10px;color:rgba(255,255,255,.4);margin-top:3px;font-weight:500}

/* ── Tabs ── */
.ew-tabs{display:flex;background:#fafafa;border-bottom:1.5px solid rgba(0,0,0,.06);overflow-x:auto;scrollbar-width:none;padding:0 8px}
.ew-tabs::-webkit-scrollbar{display:none}
.ew-tab{display:inline-flex;align-items:center;gap:6px;padding:14px 16px;font-size:12.5px;font-weight:600;color:var(--muted);border-bottom:2.5px solid transparent;cursor:pointer;white-space:nowrap;transition:all .2s;border:none;background:none;font-family:'Inter',sans-serif;margin-bottom:-1.5px;border-radius:0}
.ew-tab:hover{color:var(--text-2)}
.ew-tab.active{color:var(--blue);border-bottom-color:var(--blue);background:#fff}
.ew-tab i{font-size:14px}

/* Tab count pills */
.ew-tc{display:inline-flex;align-items:center;justify-content:center;min-width:19px;height:19px;padding:0 6px;border-radius:20px;font-size:10px;font-weight:800;background:#f1f5f9;color:var(--muted);transition:all .2s}
.ew-tab.active .ew-tc{background:var(--blue-l);color:var(--blue-d)}
.ew-tc.alert{background:var(--red-l);color:var(--red-d)}
.ew-tc.warn{background:var(--orange-l);color:var(--orange-d)}

/* ── Panels ── */
.ew-panel{display:none;padding:24px 28px;animation:ewFadeUp .25s ease}
.ew-panel.active{display:block}
@keyframes ewFadeUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}

/* ── Panel section title ── */
.ew-psec{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.12em;color:var(--muted);margin-bottom:14px;display:flex;align-items:center;gap:8px}
.ew-psec::after{content:'';flex:1;height:1px;background:rgba(0,0,0,.06)}
.ew-psec i{font-size:13px}

/* ── Gradient stat boxes ── */
.ew-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(110px,1fr));gap:10px;margin-bottom:18px}
.ew-stat{border-radius:12px;padding:14px 16px;border:1.5px solid;position:relative;overflow:hidden}
.ew-stat::before{content:'';position:absolute;top:-20px;right:-20px;width:70px;height:70px;border-radius:50%;opacity:.15}
.ew-stat-lbl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;position:relative;z-index:1}
.ew-stat-val{font-family:'IBM Plex Mono',monospace;font-size:24px;font-weight:800;line-height:1;position:relative;z-index:1}

/* stat variants */
.es-blue{background:linear-gradient(135deg,#eff6ff,#dbeafe);border-color:#bfdbfe}
.es-blue .ew-stat-lbl{color:#1d4ed8}.es-blue .ew-stat-val{color:#1e40af}.es-blue::before{background:#2563eb}
.es-green{background:linear-gradient(135deg,#ecfdf5,#d1fae5);border-color:#a7f3d0}
.es-green .ew-stat-lbl{color:#047857}.es-green .ew-stat-val{color:#065f46}.es-green::before{background:#059669}
.es-red{background:linear-gradient(135deg,#fef2f2,#fee2e2);border-color:#fecaca}
.es-red .ew-stat-lbl{color:#b91c1c}.es-red .ew-stat-val{color:#991b1b}.es-red::before{background:#dc2626}
.es-orange{background:linear-gradient(135deg,#fffbeb,#fef3c7);border-color:#fde68a}
.es-orange .ew-stat-lbl{color:#b45309}.es-orange .ew-stat-val{color:#92400e}.es-orange::before{background:#d97706}
.es-navy{background:linear-gradient(135deg,#f1f5f9,#e2e8f0);border-color:#cbd5e1}
.es-navy .ew-stat-lbl{color:#475569}.es-navy .ew-stat-val{color:#1e293b}.es-navy::before{background:#475569}
.es-teal{background:linear-gradient(135deg,#f0fdfa,#ccfbf1);border-color:#99f6e4}
.es-teal .ew-stat-lbl{color:#0f766e}.es-teal .ew-stat-val{color:#134e4a}.es-teal::before{background:#0d9488}
.es-purple{background:linear-gradient(135deg,#f5f3ff,#ede9fe);border-color:#ddd6fe}
.es-purple .ew-stat-lbl{color:#6d28d9}.es-purple .ew-stat-val{color:#4c1d95}.es-purple::before{background:#7c3aed}

/* ── Inner section card ── */
.ew-inner{background:#f8fafc;border:1.5px solid rgba(0,0,0,.06);border-radius:12px;padding:16px;margin-bottom:16px}

/* ── Table ── */
.ew-tbl-wrap{border:1.5px solid rgba(0,0,0,.06);border-radius:12px;overflow:hidden}
.ew-tbl-scroll{max-height:320px;overflow-y:auto}
.ew-tbl{width:100%;border-collapse:collapse}
.ew-tbl thead th{background:#f8fafc;color:var(--muted);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:10px 14px;border-bottom:1.5px solid rgba(0,0,0,.06);text-align:left;white-space:nowrap;position:sticky;top:0;z-index:1}
.ew-tbl tbody td{padding:10px 14px;font-size:12.5px;border-bottom:1px solid rgba(0,0,0,.04);color:var(--text);vertical-align:middle}
.ew-tbl tbody tr:last-child td{border-bottom:none}
.ew-tbl tbody tr:hover td{background:#f8fafc}

/* ── Badges ── */
.ewbdg{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;border:1.5px solid;white-space:nowrap}
.ewbdg-ok  {background:var(--green-l);color:var(--green-d);border-color:var(--green-b)}
.ewbdg-warn{background:var(--orange-l);color:var(--orange-d);border-color:var(--orange-b)}
.ewbdg-err {background:var(--red-l);color:var(--red-d);border-color:var(--red-b)}
.ewbdg-info{background:var(--blue-l);color:var(--blue-d);border-color:var(--blue-b)}
.ewbdg-muted{background:var(--navy-l);color:var(--navy);border-color:#cbd5e1}

/* ── Alert ── */
.ew-alert{border-radius:10px;padding:12px 16px;font-size:12.5px;font-weight:600;display:flex;align-items:center;gap:9px;margin-bottom:14px}
.ew-alert i{font-size:15px;flex-shrink:0}
.ew-alert-ok  {background:var(--green-l);border:1.5px solid var(--green-b);color:var(--green-d)}
.ew-alert-warn{background:var(--orange-l);border:1.5px solid var(--orange-b);color:var(--orange-d)}
.ew-alert-err {background:var(--red-l);border:1.5px solid var(--red-b);color:var(--red-d)}

/* ── Detection hero number ── */
.ew-det-big{font-family:'IBM Plex Mono',monospace;font-size:52px;font-weight:900;line-height:1;letter-spacing:-2px}
.ew-det-lbl{font-size:12px;color:var(--muted);font-weight:600;margin-top:5px}

/* ── Layouts ── */
.ew-2col{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.ew-3col{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}

/* ── Progress ── */
.ew-bar{display:flex;align-items:center;gap:8px}
.ew-bar-track{flex:1;height:6px;background:#e9eef5;border-radius:4px;overflow:hidden;min-width:60px}
.ew-bar-fill{height:100%;border-radius:4px;transition:width .7s ease}

/* ── Thumb ── */
.ew-thumb{width:40px;height:40px;object-fit:cover;border-radius:8px;border:1.5px solid rgba(0,0,0,.08);cursor:pointer;transition:transform .15s}
.ew-thumb:hover{transform:scale(1.1)}

/* ── States ── */
.ew-loader{display:flex;align-items:center;justify-content:center;padding:36px;gap:9px;color:var(--muted);font-size:12px;font-weight:600}
.ew-spin{width:18px;height:18px;border:2.5px solid #e2e8f0;border-top-color:var(--blue);border-radius:50%;animation:ewSpin .75s linear infinite}
@keyframes ewSpin{to{transform:rotate(360deg)}}
.ew-empty{text-align:center;padding:36px 20px;color:var(--muted);font-size:12px;font-weight:600}
.ew-empty i{font-size:30px;display:block;margin-bottom:9px;opacity:.25}
.mono{font-family:'IBM Plex Mono',monospace}

@media(max-width:900px){.ew-2col,.ew-3col{grid-template-columns:1fr}.ew-kpi-strip{grid-template-columns:repeat(3,1fr)}}
@media(max-width:600px){.ew-kpi-strip{grid-template-columns:repeat(2,1fr)}.ew-tab{padding:11px 12px;font-size:11.5px}}
</style>

<div class="ew">


<div class="ew-bc">
    <div class="ew-bc-trail">
        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="<?php echo e(route('nms.pages.warehouses')); ?>">Warehouses</a>
        <i class="ri-arrow-right-s-line"></i>
        <span id="breadName" style="color:var(--text)">Loading…</span>
    </div>
    <a href="<?php echo e(route('nms.pages.warehouses')); ?>" class="ew-back"><i class="ri-arrow-left-line"></i> Back</a>
</div>

<div class="ew-card">

    
    <div class="ew-hero">
        <div class="ew-hero-orb1"></div>
        <div class="ew-hero-orb2"></div>
        <div class="ew-hero-orb3"></div>

        <div class="ew-hero-top">
            <div class="ew-hero-l">
                <div class="ew-hero-ico"><i class="ri-building-4-line"></i></div>
                <div>
                    <div class="ew-hero-name" id="heroName">Loading…</div>
                    <div class="ew-hero-meta">
                        <span><i class="ri-map-pin-2-line"></i><span id="heroRegion">—</span></span>
                        <span><i class="ri-time-line"></i><span id="heroUpdated">—</span></span>
                    </div>
                </div>
            </div>
            <div id="heroStatus" class="ew-status-badge" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15);color:rgba(255,255,255,.7)">
                <div class="ew-pulse" style="background:#94a3b8"></div> Loading
            </div>
        </div>

        <div class="ew-kpi-strip">
            <div class="ew-kpi">
                <div class="ew-kpi-val" id="kNvr">—</div>
                <div class="ew-kpi-lbl">NVR</div>
                <div class="ew-kpi-sub" id="kNvrSub"></div>
            </div>
            <div class="ew-kpi">
                <div class="ew-kpi-val" id="kCam">—</div>
                <div class="ew-kpi-lbl">Cameras</div>
                <div class="ew-kpi-sub" id="kCamSub"></div>
            </div>
            <div class="ew-kpi">
                <div class="ew-kpi-val" id="kBts">—</div>
                <div class="ew-kpi-lbl">BTS</div>
                <div class="ew-kpi-sub" id="kBtsSub"></div>
            </div>
            <div class="ew-kpi">
                <div class="ew-kpi-val" id="kEpc">—</div>
                <div class="ew-kpi-lbl">Embedded PC</div>
                <div class="ew-kpi-sub" id="kEpcSub"></div>
            </div>
            <div class="ew-kpi">
                <div class="ew-kpi-val" id="kBtsC">—</div>
                <div class="ew-kpi-lbl">BTS Clients</div>
            </div>
        </div>
    </div>

    
    <div class="ew-tabs">
        <button class="ew-tab active" onclick="switchTab('nms')" id="tab-nms">
            <i class="ri-router-line"></i> NMS <span class="ew-tc" id="tc-nms">—</span>
        </button>
        <button class="ew-tab" onclick="switchTab('frs')" id="tab-frs">
            <i class="ri-shield-user-line"></i> FRS <span class="ew-tc" id="tc-frs">—</span>
        </button>
        <button class="ew-tab" onclick="switchTab('sack')" id="tab-sack">
            <i class="ri-shopping-bag-3-line"></i> Bag Counting <span class="ew-tc" id="tc-sack">—</span>
        </button>
        <button class="ew-tab" onclick="switchTab('fire')" id="tab-fire">
            <i class="ri-fire-line"></i> Fire <span class="ew-tc" id="tc-fire">0</span>
        </button>
        <button class="ew-tab" onclick="switchTab('smoke')" id="tab-smoke">
            <i class="ri-mist-line"></i> Smoke <span class="ew-tc" id="tc-smoke">0</span>
        </button>
        <button class="ew-tab" onclick="switchTab('rodent')" id="tab-rodent">
            <i class="ri-bug-2-line"></i> Rodent <span class="ew-tc" id="tc-rodent">0</span>
        </button>
        <button class="ew-tab" onclick="switchTab('iot')" id="tab-iot">
            <i class="ri-cpu-line"></i> IoT Sensors <span class="ew-tc" id="tc-iot">—</span>
        </button>
    </div>

    
    <div class="ew-panel active" id="panel-nms">
        <div class="ew-2col">
            <div>
                <div class="ew-psec"><i class="ri-hard-drive-2-line"></i> NVR & Cameras</div>
                <div id="nvrBody"><div class="ew-loader"><div class="ew-spin"></div> Loading…</div></div>
            </div>
            <div>
                <div class="ew-psec"><i class="ri-router-line"></i> BTS Radios</div>
                <div id="btsBody"><div class="ew-loader"><div class="ew-spin"></div> Loading…</div></div>
            </div>
        </div>
    </div>

    
    <div class="ew-panel" id="panel-frs">
        <div class="ew-psec"><i class="ri-camera-lens-line"></i> FRS Detection Logs</div>
        <div id="frsBody"><div class="ew-loader"><div class="ew-spin"></div> Loading…</div></div>
    </div>

    
    <div class="ew-panel" id="panel-sack">
        <div class="ew-psec"><i class="ri-scales-3-line"></i> Sack / Bag Movement</div>
        <div id="sackBody"><div class="ew-loader"><div class="ew-spin"></div> Loading…</div></div>
    </div>

    
    <div class="ew-panel" id="panel-fire">
        <div class="ew-psec"><i class="ri-fire-line"></i> Fire Detections</div>
        <div id="fireBody"><div class="ew-loader"><div class="ew-spin"></div></div></div>
    </div>

    
    <div class="ew-panel" id="panel-smoke">
        <div class="ew-psec"><i class="ri-mist-line"></i> Smoke Detections</div>
        <div id="smokeBody"><div class="ew-loader"><div class="ew-spin"></div></div></div>
    </div>

    
    <div class="ew-panel" id="panel-rodent">
        <div class="ew-psec"><i class="ri-bug-2-line"></i> Rodent Detections</div>
        <div id="rodentBody"><div class="ew-loader"><div class="ew-spin"></div></div></div>
    </div>

    
    <div class="ew-panel" id="panel-iot">
        <div class="ew-2col">
            <div>
                <div class="ew-psec"><i class="ri-temp-cold-line"></i> CO₂ Sensors</div>
                <div id="co2Body"><div class="ew-loader"><div class="ew-spin"></div></div></div>
            </div>
            <div>
                <div class="ew-psec"><i class="ri-flask-line"></i> PH₃ Sensors</div>
                <div id="ph3Body"><div class="ew-loader"><div class="ew-spin"></div></div></div>
            </div>
        </div>
    </div>

</div>
</div>


<script>
/* ── Config from controller ── */
const NMS_BASE  = <?php echo json_encode($nmsBase, 15, 512) ?>;
const FRS_BASE  = <?php echo json_encode($frsBase, 15, 512) ?>;
const SACK_BASE = <?php echo json_encode($sackBase, 15, 512) ?>;
const IOT_BASE  = <?php echo json_encode($iotBase, 15, 512) ?>;
const CO2_URL   = <?php echo json_encode($co2SummaryUrl, 15, 512) ?>;
const WID       = <?php echo e($warehouseId); ?>;
const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const HDR       = {'Accept':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'};

/* Master warehouse list — exact IDs for FRS/Sack/IoT APIs */
const MASTER_WH_URL = 'https://frsbag.cwcnewiot.in/frs/master_warehouses';
let _masterWh = null;

async function getMasterWh() {
    if (_masterWh) return _masterWh;
    try {
        const r = await fetch(MASTER_WH_URL);
        const j = await r.json();
        _masterWh = j.warehouses || [];
    } catch(e) { _masterWh = []; }
    return _masterWh;
}

/* Find this warehouse in master list by NMS warehouse_id match or name match */
function findMasterWh(nmsWhName, warehouses) {
    if (!warehouses.length) return null;
    const name = (nmsWhName||'').toUpperCase().trim();
    /* exact match first */
    let found = warehouses.find(w => w.warehouse_name.toUpperCase() === name);
    if (found) return found;
    /* partial match — any word */
    const words = name.split(/[\s\-\/]+/).filter(w=>w.length>2);
    found = warehouses.find(w => {
        const wn = w.warehouse_name.toUpperCase();
        return words.some(word => wn.includes(word) || word.includes(wn.split(/[\s\-\/]+/)[0]));
    });
    return found || null;
}

/* ── Helpers ── */
const fN  = n  => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const g   = id => document.getElementById(id);
const col = p  => p>=80?'var(--green)':p>=50?'var(--orange)':'var(--red)';
const ago = d  => {
    if (!d) return '—';
    const s = Math.floor((Date.now()-new Date(d))/60000);
    return s<1?'Just now':s<60?s+'m ago':s<1440?Math.floor(s/60)+'h ago':Math.floor(s/1440)+'d ago';
};
const pct = (on,tot) => tot>0?Math.round(on/tot*100):0;

function bdg(id,text,type){ const el=g(id); if(!el)return; el.textContent=text; el.className='ewbdg ewbdg-'+type; }

function statBox(lbl,val,bg,bc,lc,vc){
    return `<div class="ew-stat" style="background:${bg};border-color:${bc}">
        <div class="wa-stat-lbl" style="color:${lc}">${lbl}</div>
        <div class="wa-stat-val" style="color:${vc}">${val}</div>
    </div>`;
}

function mkTable(headers,rows){
    if(!rows.length) return null;
    return `<div class="wa-tbl-wrap"><div class="wa-tbl-scroll"><table class="ew-tbl">
        <thead><tr>${headers.map(h=>`<th>${h}</th>`).join('')}</tr></thead>
        <tbody>${rows.join('')}</tbody>
    </table></div></div>`;
}

function empty(icon,msg){ return `<div class="ew-empty"><i class="${icon}"></i>${msg}</div>`; }

/* ════════════════════════════════
   1. NMS
════════════════════════════════ */
async function loadNMS() { /* returns promise */
    try {
        const r = await fetch(`${NMS_BASE}/warehouses/${WID}`);
        const j = await r.json();
        const wh   = j.data?.warehouse || j.data || j;
        const devs = Array.isArray(j.data?.devices) ? j.data.devices : [];

        const name = wh.warehouse_name || wh.name || 'Warehouse #'+WID;
        g('heroName').textContent  = name;
        g('breadName').textContent = name;
        g('heroRegion').textContent = wh.region_name || wh.region || '—';
        g('heroUpdated').textContent = new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit'});

        const nvrs   = devs.filter(d=>/nvr|dvr|camera_device/i.test(d.type||''));
        const btsDev = devs.filter(d=>/bts/i.test(d.type||''));
        const epcDev = devs.filter(d=>/embedded|epc/i.test(d.type||''));

        const camTot = nvrs.reduce((s,n)=>s+(n.cameras?.total||0),0);
        const camOn  = nvrs.reduce((s,n)=>s+(n.cameras?.online||0),0);
        const camOff = camTot - camOn;
        const camPct = pct(camOn,camTot);
        const btsC   = btsDev.reduce((s,b)=>s+(b.client_count||0),0);

        /* Hero KPIs */
        /* If no NVR devices found, show total device count as fallback */
        const nvrCount = nvrs.length || (wh.nvr_total||0);
        const nvrOnline = nvrs.filter(n=>/online/i.test(n.status||'')).length || (wh.nvr_online||0);
        g('kNvr').textContent  = fN(nvrCount);
        g('kNvrSub').textContent = nvrOnline+' online';
        g('kCam').textContent  = fN(camTot);         g('kCamSub').textContent = fN(camOn)+' on · '+fN(camOff)+' off';
        g('kBts').textContent  = fN(btsDev.length);  g('kBtsSub').textContent = btsDev.filter(b=>/online/i.test(b.status||'')).length+' online';
        g('kEpc').textContent  = fN(epcDev.length);  g('kEpcSub').textContent = epcDev.filter(e=>/online/i.test(e.status||'')).length+' online';
        g('kBtsC').textContent = fN(btsC);

        /* Hero status */
        const status = camPct>=80?'Healthy':camPct>=40?'Partial':'Down';
        setTabCount('nms', fN(devs.length), camPct<40?'alert':'');
        const sc = { Healthy:['#22c55e','rgba(34,197,94,.18)'], Partial:['#f59e0b','rgba(245,158,11,.18)'], Down:['#ef4444','rgba(239,68,68,.18)'] };
        g('heroStatus').innerHTML = `<div class="wa-dot" style="background:${sc[status][0]}"></div> ${status} · ${camPct}% cam uptime`;
        Object.assign(g('heroStatus').style,{background:sc[status][1],borderColor:sc[status][0]+'55',color:sc[status][0]});

        bdg('camUptimeBdg', camPct+'% camera uptime', camPct>=80?'ok':camPct>=40?'warn':'err');

        /* Store region_id and warehouse code for sack/IoT matching */
        window._waRegionId   = wh.region_id || wh.regionId || null;
        window._waWhName     = name;
        window._waWhCode     = wh.warehouse_code || wh.code || name;
        window._waCity       = wh.city || wh.location || '';
        window._waRegionName = wh.region_name || wh.region || '';

        /* Look up exact IDs from master list */
        const masterList = await getMasterWh();
        const masterEntry = findMasterWh(name, masterList);
        window._frsWhId    = masterEntry?.id          || WID;
        window._frsRegId   = masterEntry?.region_id   || window._waRegionId;
        window._frsWhName  = masterEntry?.warehouse_name || name;
        console.log('[Activity] Master WH match:', masterEntry);

        /* NVR table */
        if (!nvrs.length) { g('nvrBody').innerHTML = empty('ri-hard-drive-2-line','No NVR at this warehouse'); }
        else {
            const rows = nvrs.map(n=>{
                const p=pct(n.cameras?.online||0,n.cameras?.total||0), c=col(p), on=/online/i.test(n.status||'');
                return `<tr>
                    <td><span style="font-weight:700">${n.device_name||n.name||'NVR'}</span>${n.ip_address?`<br><span class="mono" style="font-size:10px;color:var(--muted)">${n.ip_address}</span>`:''}</td>
                    <td><span class="ewbdg ${on?'wbdg-ok':'wbdg-err'}">${n.status||'—'}</span></td>
                    <td class="mono" style="color:var(--green);font-weight:700">${fN(n.cameras?.online||0)}</td>
                    <td class="mono" style="color:${(n.cameras?.offline||0)>0?'var(--red)':'var(--muted)'};font-weight:700">${fN(n.cameras?.offline||0)}</td>
                    <td><div class="ew-bar"><div class="ew-bar-track"><div class="ew-bar-fill" style="width:${p}%;background:linear-gradient(90deg,${c},${c}bb)"></div></div><span style="font-size:11px;font-weight:700;color:${c};min-width:34px">${p}%</span></div></td>
                </tr>`;
            });
            g('nvrBody').innerHTML = mkTable(['Device','Status','Cam On','Cam Off','Health'],rows)||'';
        }

        /* BTS table */
        bdg('btsBdg', btsDev.filter(b=>/online/i.test(b.status||'')).length+'/'+btsDev.length+' online', btsDev.length?'ok':'muted');
        if (!btsDev.length) { g('btsBody').innerHTML = empty('ri-router-line','No BTS at this warehouse'); }
        else {
            const rows = btsDev.map(b=>{
                const on=/online/i.test(b.status||'');
                return `<tr>
                    <td style="font-weight:700">${b.device_name||b.name||'BTS'}</td>
                    <td><span class="ewbdg ${on?'wbdg-ok':'wbdg-err'}">${b.status||'—'}</span></td>
                    <td class="mono" style="font-weight:700;color:var(--blue)">${fN(b.client_count||0)}</td>
                    <td class="mono" style="font-size:11px;color:var(--muted)">${b.ip_address||'—'}</td>
                    <td style="color:var(--muted);font-size:11px">${b.signal_strength!=null?b.signal_strength+' dBm':'—'}</td>
                </tr>`;
            });
            g('btsBody').innerHTML = mkTable(['BTS Radio','Status','Clients','IP','Signal'],rows)||'';
        }
    } catch(e) {
        console.warn('NMS error',e);
        g('heroName').textContent  = 'Warehouse #'+WID;
        g('breadName').textContent = '#'+WID;
        g('nvrBody').innerHTML = empty('ri-error-warning-line','Failed to load NMS data');
        g('btsBody').innerHTML = empty('ri-error-warning-line','Failed to load BTS data');
    }
}

/* ════════════════════════════════
   2. FRS  — frsbag.cwcnewiot.in/frs/detection_logs
   Fields: warehouse_id, warehouse, camera_label, timestamp,
           confidence, crop_url, frame_url, region, godown, compartment
════════════════════════════════ */
async function loadFRS() {
    try {
        const frsWhId = window._frsWhId || WID;
        const r = await fetch(`${FRS_BASE}/frs/detection_logs?warehouse_id=${frsWhId}&limit=50`);
        const j = await r.json();
        const items = j.logs || j.data || [];
        const total = j.count ?? items.length;

        const unknown   = items.filter(f => (f.status||'').toLowerCase()==='unknown' || !f.person_id);
        const known     = items.filter(f => f.person_id && (f.status||'').toLowerCase()!=='unknown');

        bdg('frsBdg', fN(total)+' log'+(total!==1?'s':''), unknown.length>0?'warn':'ok');
        setTabCount('frs', fN(total), unknown.length>0?'warn':'');

        if (!items.length) {
            g('frsBody').innerHTML = `<div class="ew-alert ew-alert-ok"><i class="ri-shield-check-line"></i> No FRS logs for this warehouse</div>`;
            return;
        }

        const rows = items.map(f=>{
            const conf  = f.confidence ? (f.confidence*100).toFixed(1)+'%' : '—';
            const isUnk = !f.person_id || (f.status||'').toLowerCase()==='unknown';
            const thumb = (f.crop_url||f.frame_url)
                ? `<img src="${FRS_BASE}${f.crop_url||f.frame_url}" class="ew-thumb" onerror="this.style.display='none'" onclick="window.open('${FRS_BASE}${f.frame_url||f.crop_url}','_blank')">`
                : '—';
            return `<tr>
                <td>${thumb}</td>
                <td style="font-weight:700">${f.name||f.person_name||'Unknown'}</td>
                <td><span class="ewbdg ${isUnk?'wbdg-warn':'wbdg-ok'}">${isUnk?'Unknown':'Known'}</span></td>
                <td style="font-weight:600;font-size:11px">${f.camera_label||'—'}</td>
                <td style="color:var(--muted);font-size:11px">${f.godown||'—'} / ${f.compartment||'—'}</td>
                <td style="font-size:11px;color:var(--orange);font-weight:600">${conf}</td>
                <td style="color:var(--muted);font-size:11px;white-space:nowrap">${ago(f.timestamp)}</td>
            </tr>`;
        });

        g('frsBody').innerHTML = `
            <div class="ew-stats" style="margin-bottom:14px">
                ${statBox('Total Logs',   fN(total),          'var(--navy-l)',   'var(--border-2)', 'var(--navy)',    'var(--navy)')}
                ${statBox('Known',        fN(known.length),   'var(--green-l)', 'var(--green-b)', 'var(--green-d)','var(--green-d)')}
                ${statBox('Unknown',      fN(unknown.length), 'var(--orange-l)','var(--orange-b)','var(--orange-d)','var(--orange-d)')}
            </div>
            ${unknown.length>0
                ? `<div class="ew-alert ew-alert-warn"><i class="ri-alert-line"></i> ${unknown.length} unknown ${unknown.length===1?'identity':'identities'} detected</div>`
                : `<div class="ew-alert ew-alert-ok"><i class="ri-shield-check-line"></i> No unknown identities — all faces recognised</div>`
            }
            ${mkTable(['Crop','Name','Status','Camera','Godown / Compartment','Confidence','When'],rows)||''}`;
    } catch(e) {
        g('frsBody').innerHTML = empty('ri-error-warning-line','Failed to load FRS data');
        bdg('frsBdg','Error','err');
    }
}

/* ════════════════════════════════
   3. Sack — frsbag.cwcnewiot.in/sack/data?region_id=&warehouse_id=
   Fields: Total_In, Total_Out, Day_Total_In, Day_Total_Out,
           action_taken, number_of_bags, transaction_time,
           godown_name, compartment_name
════════════════════════════════ */
async function loadSack(regionId) {
    try {
        const rid    = regionId || window._frsRegId || window._waRegionId || '';
        const sackWid = window._frsWhId || WID;
        const query  = rid ? `region_id=${rid}&warehouse_id=${sackWid}` : `warehouse_id=${sackWid}`;
        /* Try proxy first, then direct */
        let r;
        try { r = await fetch(`/api/proxy/sack?${query}`, {headers:HDR}); if(!r.ok) throw new Error(); }
        catch(_) { r = await fetch(`${SACK_BASE}/sack/data?${query}`); }
        const j = await r.json();
        const items = Array.isArray(j) ? j : (j.data || []);

        if (!items.length) {
            g('sackBody').innerHTML = empty('ri-shopping-bag-3-line','No bag movement data');
            bdg('sackBdg','No data','muted');
            return;
        }

        /* Totals from first item (they carry running totals) */
        const first    = items[0];
        const totalIn  = first.Total_In  || 0;
        const totalOut = first.Total_Out || 0;
        const dayIn    = first.Day_Total_In  || 0;
        const dayOut   = first.Day_Total_Out || 0;
        const net      = totalIn - totalOut;
        const dayNet   = dayIn - dayOut;

        bdg('sackBdg', fN(dayIn)+' IN · '+fN(dayOut)+' OUT today', 'info');
        setTabCount('sack', fN(dayIn+dayOut), '');

        const rows = items.slice(0,15).map(s=>{
            const isIn = (s.action_taken||s.Action_taken||'').toLowerCase()==='in';
            return `<tr>
                <td style="font-weight:600">${s.godown_name||'—'}</td>
                <td style="font-size:11px;color:var(--muted)">${s.compartment_name||'—'}</td>
                <td><span class="ewbdg ${isIn?'wbdg-ok':'wbdg-err'}">${s.action_taken||s.Action_taken||'—'}</span></td>
                <td class="mono" style="font-weight:700;color:${isIn?'var(--green)':'var(--red)'}">${fN(s.number_of_bags||s.Number_Of_Bag||0)}</td>
                <td style="color:var(--muted);font-size:11px">${ago(s.transaction_time||s.DateTime_of_action)}</td>
            </tr>`;
        });

        g('sackBody').innerHTML = `
            <div class="ew-stats">
                ${statBox('Total IN (All Time)', fN(totalIn),  'var(--orange-l)', 'var(--orange-b)', 'var(--orange-d)', 'var(--orange-d)')}
                ${statBox('Total OUT (All Time)',fN(totalOut), 'var(--navy-l)',   'var(--border-2)', 'var(--navy)',     'var(--navy)')}
                ${statBox('Net Stock',           (net>=0?'+':'')+fN(net), net>=0?'var(--green-l)':'var(--red-l)', net>=0?'var(--green-b)':'var(--red-b)', net>=0?'var(--green-d)':'var(--red-d)', net>=0?'var(--green-d)':'var(--red-d)')}
                ${statBox("Today's IN",  fN(dayIn),  'var(--blue-l)',   'var(--blue-b)',   'var(--blue-d)',   'var(--blue-d)')}
                ${statBox("Today's OUT", fN(dayOut), 'var(--purple-l,#f5f3ff)', 'var(--purple-b,#ddd6fe)', '#6d28d9', '#6d28d9')}
            </div>
            <div style="font-size:11px;font-weight:700;color:var(--muted);margin-bottom:8px">Recent Transactions</div>
            ${mkTable(['Godown','Compartment','Action','Bags','When'],rows)||''}`;
    } catch(e) {
        g('sackBody').innerHTML = empty('ri-error-warning-line','Failed to load bag counting data');
        bdg('sackBdg','Error','err');
    }
}

/* ════════════════════════════════
   4. Fire / Smoke / Rodent
   co2ph3master.ajeevi.in/api/camera-alerts
   Fields: cameraName, locationName, alertType, alertDateTime, totalCount
   Filter by locationName matching warehouse
════════════════════════════════ */
async function loadCameraAlerts() {
    try {
        const whName = (window._frsWhName || g('heroName').textContent||'').toUpperCase().trim();
        const r = await fetch(`${IOT_BASE}/api/camera-alerts?pageNumber=1&pageSize=100`);
        const j = await r.json();
        const all = j.data || [];

        /* Filter to this warehouse by locationName */
        /* Multi-field matching: name, code, city against locationName */
        const whCode = (window._waWhCode||'').toUpperCase();
        const whCity = (window._waCity||'').toUpperCase();
        const whWords = [...new Set([
            ...whName.split(/\s+/),
            ...whCode.split(/\s+/),
            ...whCity.split(/\s+/)
        ])].filter(w=>w.length>2);
        const filtered = all.filter(a => {
            const loc = (a.locationName||'').toUpperCase().trim();
            return whWords.some(w => loc.includes(w) || w.includes(loc)) ||
                   loc === whName || loc === whCode || loc === whCity;
        });

        const types = [
            { key:'fire',   bdg:'fireBdg',   body:'fireBody',   match:/fire/i,   icon:'ri-fire-line',  color:'var(--red)',    label:'Fire'   },
            { key:'smoke',  bdg:'smokeBdg',  body:'smokeBody',  match:/smoke/i,  icon:'ri-mist-line',  color:'var(--orange)', label:'Smoke'  },
            { key:'rodent', bdg:'rodentBdg', body:'rodentBody', match:/rodent/i, icon:'ri-bug-2-line', color:'var(--teal)',   label:'Rodent' },
        ];

        for (const t of types) {
            const items = filtered.filter(a => t.match.test(a.alertType||''));
            const total = items.length;
            bdg(t.bdg, fN(total)+' event'+(total!==1?'s':''), total>0?'err':'ok');
            setTabCount(t.key, total, total>0?'alert':'');

            if (!items.length) {
                g(t.body).innerHTML = `<div style="text-align:center;padding:20px 0">
                    <div class="ew-det-big" style="color:var(--muted)">0</div>
                    <div class="ew-det-lbl">${t.label} events</div>
                    <div class="ew-alert ew-alert-ok" style="margin-top:12px"><i class="ri-checkbox-circle-line"></i> All clear — no ${t.label.toLowerCase()} detected</div>
                </div>`;
                continue;
            }

            const rows = items.slice(0,10).map(a=>{
                /* alertType like "{'Fire': 1}" — extract key */
                let aType = a.alertType||t.label;
                try { const m=aType.match(/'(\w+)'/); if(m)aType=m[1]; } catch(_){}
                /* cameraName like "MediaProfile_Channel15_MainStream" — shorten */
                const camName = (a.cameraName||'—').replace('MediaProfile_','').replace('_MainStream','').replace('_',' ');
                return `<tr>
                    <td style="font-weight:600;font-size:11px">${camName}</td>
                    <td><span class="ewbdg wbdg-err" style="font-size:10px">${aType}</span></td>
                    <td style="color:var(--muted);font-size:11px;white-space:nowrap">${ago(a.alertDateTime)}</td>
                </tr>`;
            });

            g(t.body).innerHTML = `
                <div style="text-align:center;margin-bottom:16px;padding:16px 0">
                    <div class="ew-det-big" style="color:${t.color}">${fN(total)}</div>
                    <div class="ew-det-lbl">${t.label} events detected</div>
                </div>
                ${mkTable(['Camera','Type','When'],rows)||''}`;
        }
    } catch(e) {
        for (const id of ['fireBody','smokeBody','rodentBody'])
            g(id).innerHTML = empty('ri-error-warning-line','Failed to load detection data');
        for (const id of ['fireBdg','smokeBdg','rodentBdg'])
            bdg(id,'Error','err');
    }
}

/* ════════════════════════════════
   5. IoT — CO₂ / PH₃
   co2ph3master.ajeevi.in/api/master-alerts
   Fields: locationName, alertType, deviceValue, deviceStatus,
           deviceTypeId (30000=CO2, 30001=PH3), recordTime, deviceIp
════════════════════════════════ */
async function loadIoT() {
    try {
        const whName = (window._frsWhName || g('heroName').textContent||'').toUpperCase().trim();
        const r = await fetch(`${IOT_BASE}/api/master-alerts?pageNumber=1&pageSize=100`);
        const j = await r.json();
        const all = Array.isArray(j) ? j : (j.data||[]);

        /* Match by locationName */
        /* Multi-field matching: name, code, city against locationName */
        const whCode = (window._waWhCode||'').toUpperCase();
        const whCity = (window._waCity||'').toUpperCase();
        const whWords = [...new Set([
            ...whName.split(/\s+/),
            ...whCode.split(/\s+/),
            ...whCity.split(/\s+/)
        ])].filter(w=>w.length>2);
        const filtered = all.filter(a => {
            const loc = (a.locationName||'').toUpperCase().trim();
            return whWords.some(w => loc.includes(w) || w.includes(loc)) ||
                   loc === whName || loc === whCode || loc === whCity;
        });

        const gases = [
            { id:'co2', bdg:'co2Bdg', body:'co2Body', typeId:30000, lbl:'CO₂' },
            { id:'ph3', bdg:'ph3Bdg', body:'ph3Body', typeId:30001, lbl:'PH₃' },
        ];

        for (const gas of gases) {
            const items = filtered.filter(a => a.deviceTypeId === gas.typeId || a.deviceTypeId === String(gas.typeId));
            const online   = items.filter(a=>/online/i.test(a.deviceStatus||'')).length;
            const normal   = items.filter(a=>/normal/i.test(a.alertType||'')).length;
            const severe   = items.filter(a=>/severe/i.test(a.alertType||'')).length;
            const critical = items.filter(a=>/critical/i.test(a.alertType||'')).length;
            const total    = items.length;
            const alerts   = severe + critical;

            bdg(gas.bdg, online+'/'+total+' online', alerts>0?'err':online>0?'ok':'warn');
            if (gas.id==='co2') setTabCount('iot', online+'/'+total, alerts>0?'alert':'');

            let alertHtml = '';
            if (critical>0) alertHtml += `<div class="ew-alert ew-alert-err"><i class="ri-alarm-warning-line"></i> ${critical} CRITICAL ${gas.lbl} alert${critical!==1?'s':''}</div>`;
            if (severe>0)   alertHtml += `<div class="ew-alert ew-alert-warn"><i class="ri-alert-line"></i> ${severe} severe ${gas.lbl} alert${severe!==1?'s':''}</div>`;
            if (!alerts)    alertHtml  = `<div class="ew-alert ew-alert-ok"><i class="ri-checkbox-circle-line"></i> All ${gas.lbl} sensors normal</div>`;

            if (!total) {
                g(gas.body).innerHTML = empty('ri-sensor-line',`No ${gas.lbl} sensors at this warehouse`);
                bdg(gas.bdg,'No sensors','muted');
                continue;
            }

            const rows = items.slice(0,10).map(a=>{
                const isAlert = !/normal/i.test(a.alertType||'');
                return `<tr>
                    <td class="mono" style="font-size:11px;color:var(--muted)">${a.deviceIp||'—'}</td>
                    <td><span class="ewbdg ${isAlert?'wbdg-err':'wbdg-ok'}" style="font-size:10px">${a.alertType||'—'}</span></td>
                    <td class="mono" style="font-weight:700;color:${isAlert?'var(--red)':'var(--green)'}">${a.deviceValue??'—'}</td>
                    <td style="color:var(--muted);font-size:11px">${ago(a.recordTime)}</td>
                </tr>`;
            });

            g(gas.body).innerHTML = `
                <div class="ew-stats">
                    ${statBox('Total',    fN(total),    'var(--navy-l)',   'var(--border-2)', 'var(--navy)',    'var(--navy)')}
                    ${statBox('Online',   fN(online),   'var(--blue-l)',   'var(--blue-b)',   'var(--blue-d)', 'var(--blue-d)')}
                    ${statBox('Normal',   fN(normal),   'var(--green-l)', 'var(--green-b)', 'var(--green-d)','var(--green-d)')}
                    ${statBox('Severe',   fN(severe),   'var(--orange-l)','var(--orange-b)','var(--orange-d)','var(--orange-d)')}
                    ${statBox('Critical', fN(critical), 'var(--red-l)',   'var(--red-b)',   'var(--red-d)',  'var(--red-d)')}
                </div>
                ${alertHtml}
                ${total ? (mkTable(['Device IP','Alert Type','Value','Last Reading'],rows)||'') : ''}`;
        }
    } catch(e) {
        for (const id of ['co2Body','ph3Body'])
            g(id).innerHTML = empty('ri-sensor-line','Failed to load IoT data');
        for (const id of ['co2Bdg','ph3Bdg'])
            bdg(id,'Error','err');
    }
}


/* ── Tab switching ── */
function switchTab(name) {
    document.querySelectorAll('.ew-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.ew-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-'+name)?.classList.add('active');
    document.getElementById('panel-'+name)?.classList.add('active');
}

/* ── Update tab counts ── */
function setTabCount(id, val, alertLevel) {
    const el = document.getElementById('tc-'+id);
    if (!el) return;
    el.textContent = val;
    el.className = 'ew-tc' + (alertLevel==='alert'?' alert':alertLevel==='warn'?' warn':'');
}

/* ── Boot ── */
// NMS first so region_id and warehouse name are known before IoT/sack filter
loadNMS().then(() => {
    loadSack(window._waRegionId);
    loadCameraAlerts();
    loadIoT();
});
loadFRS();
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\warehouse\activity.blade.php ENDPATH**/ ?>