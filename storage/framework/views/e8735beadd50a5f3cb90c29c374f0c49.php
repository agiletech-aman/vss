<?php $__env->startSection('title','NMS — Warehouse'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('nms.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
/* ── Base ── */
.nms * { box-sizing:border-box; }

/* ── Hero ── */
.wh-hero { background:linear-gradient(135deg,#0c1445 0%,#1e3a8a 55%,#1e40af 100%);
    border-radius:16px; padding:24px 28px; margin-bottom:18px;
    color:#fff; box-shadow:0 8px 32px rgba(30,64,175,.25); position:relative; overflow:hidden; }
.wh-hero::before { content:''; position:absolute; top:-60px; right:-60px; width:220px; height:220px;
    border-radius:50%; background:rgba(99,102,241,.15); }
.wh-hero::after  { content:''; position:absolute; bottom:-40px; left:30%; width:160px; height:160px;
    border-radius:50%; background:rgba(255,255,255,.04); }
.wh-hero-top { display:flex; align-items:flex-start; justify-content:space-between; gap:14px; flex-wrap:wrap; position:relative; z-index:1; margin-bottom:18px; }
.wh-hero-ico { width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,.1);
    border:1.5px solid rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:24px; flex-shrink:0; }
.wh-hero-name { font-size:22px; font-weight:900; letter-spacing:-.4px; line-height:1.1; }
.wh-hero-meta { font-size:11.5px; color:rgba(255,255,255,.55); margin-top:5px; }
.wh-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 16px; border-radius:24px;
    font-size:12px; font-weight:700; border:1.5px solid; backdrop-filter:blur(8px); }
.wh-pulse { width:8px; height:8px; border-radius:50%; animation:wPulse 2s infinite; }
@keyframes wPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.75)} }

/* ── KPI strip ── */
.wkpi { display:grid; grid-template-columns:repeat(auto-fit,minmax(110px,1fr)); gap:1px;
    background:rgba(255,255,255,.1); border-radius:10px; overflow:hidden; position:relative; z-index:1; }
.wkc { padding:13px 16px; background:rgba(0,0,0,.18); text-align:center; transition:background .15s; }
.wkc:hover { background:rgba(255,255,255,.06); }
.wkl { font-size:8px; font-weight:700; text-transform:uppercase; letter-spacing:.09em;
    color:rgba(255,255,255,.4); margin-bottom:4px; }
.wkv { font-family:'IBM Plex Mono',monospace; font-size:1.3rem; font-weight:800; color:#fff; line-height:1; }
.wks { font-size:9.5px; color:rgba(255,255,255,.4); margin-top:3px; font-weight:500; }

/* ── Section dividers ── */
.wsec { display:flex; align-items:center; gap:8px; margin:20px 0 12px;
    font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:.13em; color:#94a3b8; }
.wsec::after { content:''; flex:1; height:1px; background:#e2e8f0; }
.wsec i { font-size:12px; }

/* ── Device cards ── */
.dcard { border-radius:14px; margin-bottom:12px; overflow:hidden; border:1.5px solid #e2e8f0;
    box-shadow:0 2px 10px rgba(0,0,0,.05); transition:transform .15s, box-shadow .15s; }
.dcard:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.08); }
.dcard.doff { border-color:#fca5a5; background:#fff5f5; }

/* NVR card gradient */
.dcard-nvr { background:linear-gradient(135deg,#fff 0%,#eff6ff 100%); border-color:#bfdbfe; }
.dcard-nvr.doff { background:linear-gradient(135deg,#fff5f5,#fff); }

/* BTS card gradient */
.dcard-bts { background:linear-gradient(135deg,#fff 0%,#ecfdf5 100%); border-color:#a7f3d0; }
.dcard-bts.doff { background:linear-gradient(135deg,#fff5f5,#fff); }

/* EPC card gradient */
.dcard-epc { background:linear-gradient(135deg,#fff 0%,#fffbeb 100%); border-color:#fde68a; }
.dcard-epc.doff { background:linear-gradient(135deg,#fff5f5,#fff); }

/* Other card */
.dcard-other { background:linear-gradient(135deg,#fff 0%,#f1f5f9 100%); border-color:#cbd5e1; }

.dcard-h { display:flex; align-items:center; gap:12px; padding:14px 18px; border-bottom:1.5px solid rgba(0,0,0,.06); }
.dcard-ico { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.ico-nvr   { background:linear-gradient(135deg,#dbeafe,#bfdbfe); color:#1d4ed8; }
.ico-bts   { background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#047857; }
.ico-epc   { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#b45309; }
.ico-def   { background:linear-gradient(135deg,#f1f5f9,#e2e8f0); color:#475569; }
.dcard-name { font-size:14px; font-weight:800; color:#0f172a; }
.dcard-sub  { font-size:10.5px; color:#94a3b8; margin-top:2px; display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
.dcard-b { padding:16px 18px; }

/* ── Stat pills row ── */
.stat-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(90px,1fr)); gap:8px; margin-bottom:14px; }
.stat-box { border-radius:10px; padding:10px 12px; border:1.5px solid; text-align:center; }
.stat-lbl { font-size:8.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; margin-bottom:4px; }
.stat-val { font-family:'IBM Plex Mono',monospace; font-size:20px; font-weight:800; line-height:1; }
.sb-blue   { background:linear-gradient(135deg,#eff6ff,#dbeafe); border-color:#bfdbfe; }
.sb-blue .stat-lbl { color:#1d4ed8; } .sb-blue .stat-val { color:#1e40af; }
.sb-green  { background:linear-gradient(135deg,#ecfdf5,#d1fae5); border-color:#a7f3d0; }
.sb-green .stat-lbl { color:#047857; } .sb-green .stat-val { color:#065f46; }
.sb-red    { background:linear-gradient(135deg,#fef2f2,#fee2e2); border-color:#fecaca; }
.sb-red .stat-lbl { color:#b91c1c; } .sb-red .stat-val { color:#991b1b; }
.sb-orange { background:linear-gradient(135deg,#fffbeb,#fef3c7); border-color:#fde68a; }
.sb-orange .stat-lbl { color:#b45309; } .sb-orange .stat-val { color:#92400e; }
.sb-navy   { background:linear-gradient(135deg,#f1f5f9,#e2e8f0); border-color:#cbd5e1; }
.sb-navy .stat-lbl { color:#475569; } .sb-navy .stat-val { color:#1e293b; }

/* ── Cam uptime ring ── */
.nvr-sum { display:flex; align-items:center; gap:14px; background:rgba(255,255,255,.7);
    border-radius:12px; padding:12px 14px; margin-bottom:14px; border:1.5px solid rgba(0,0,0,.06); }
.nvr-sum-mid { flex:1; min-width:0; }
.nvr-sum-num { font-family:'IBM Plex Mono',monospace; font-size:26px; font-weight:900; line-height:1; }
.nvr-sum-den { font-size:12px; color:#94a3b8; font-weight:500; }
.nvr-sum-pct { font-size:12px; font-weight:700; margin-left:4px; }
.nvr-sum-bw  { min-width:145px; display:flex; flex-direction:column; gap:3px; }

/* ── Chips ── */
.chip { display:inline-flex; align-items:center; gap:3px; padding:3px 9px;
    border-radius:20px; font-size:10px; font-weight:700; border:1.5px solid; }
.chi-ok   { background:#ecfdf5; color:#047857; border-color:#a7f3d0; }
.chi-err  { background:#fef2f2; color:#b91c1c; border-color:#fecaca; }
.chi-warn { background:#fffbeb; color:#b45309; border-color:#fde68a; }
.chi-dot  { width:5px; height:5px; border-radius:50%; background:currentColor; }

/* ── Tables inside cards ── */
.sublbl { font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.09em; color:#94a3b8; margin-bottom:8px; }
.cam-tbl-wrap { border:1.5px solid #e2e8f0; border-radius:10px; overflow:hidden; }
.cam-tbl-scroll { max-height:380px; overflow-y:auto; }
.ctbl { width:100%; border-collapse:collapse; }
.ctbl thead th { background:#f8fafc; color:#94a3b8; font-size:8.5px; font-weight:800;
    text-transform:uppercase; letter-spacing:.07em; padding:8px 12px;
    border-bottom:1.5px solid #e2e8f0; text-align:left; white-space:nowrap; position:sticky; top:0; z-index:1; }
.ctbl tbody td { padding:7px 12px; font-size:11.5px; border-bottom:1px solid #f0f4f8; color:#0f172a; vertical-align:middle; }
.ctbl tbody tr:last-child td { border-bottom:none; }
.ctbl tbody tr:hover td { background:#f8fafc; }
.ctbl tr.crow-off td { background:#fff5f5; }

.gtbl-wrap { border:1.5px solid #e2e8f0; border-radius:10px; overflow:hidden; overflow-x:auto; }
.gtbl { width:100%; border-collapse:collapse; }
.gtbl thead th { background:#f8fafc; color:#94a3b8; font-size:8.5px; font-weight:800;
    text-transform:uppercase; letter-spacing:.07em; padding:8px 12px;
    border-bottom:1.5px solid #e2e8f0; text-align:left; white-space:nowrap; }
.gtbl tbody td { padding:7px 12px; font-size:11.5px; border-bottom:1px solid #f0f4f8; color:#0f172a; vertical-align:middle; }
.gtbl tbody tr:last-child td { border-bottom:none; }
.gtbl tbody tr:hover td { background:#f8fafc; }

/* ── Other helpers ── */
.nip { font-family:'IBM Plex Mono',monospace; font-size:10px; background:#f1f5f9;
    padding:2px 7px; border-radius:5px; border:1px solid #e2e8f0; color:#334155; }
.npt { background:#1e293b; color:#94a3b8; border-radius:3px; padding:0 4px; font-size:9px; margin-left:1px; }
.rpills { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:12px; }
.rp   { background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:8px; padding:7px 12px; text-align:center; min-width:60px; }
.rpv  { font-family:'IBM Plex Mono',monospace; font-size:13px; font-weight:800; color:#1e293b; line-height:1; }
.rpl  { font-size:8px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#94a3b8; margin-top:3px; }
.gw   { position:relative; width:56px; height:56px; flex-shrink:0; }
.gw svg { transform:rotate(-90deg); }
.gi   { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; line-height:1; }
.gv   { font-family:'IBM Plex Mono',monospace; font-weight:900; font-size:12px; }
.gl   { font-size:7px; font-weight:700; text-transform:uppercase; color:#94a3b8; margin-top:2px; }
.bts-sum { display:flex; align-items:center; gap:14px; background:rgba(255,255,255,.7);
    border-radius:12px; padding:12px 14px; margin-bottom:14px; border:1.5px solid rgba(0,0,0,.06); }
.bts-sum-mid { flex:1; min-width:0; }
.bts-sum-num { font-family:'IBM Plex Mono',monospace; font-size:26px; font-weight:900; color:#10b981; line-height:1; }
.ifc { background:#f8fafc; border-radius:8px; padding:10px 12px; border:1.5px solid #e2e8f0; margin-bottom:7px; }
.ifc:last-child { margin-bottom:0; }
.ifc.up { border-color:#a7f3d0; background:#ecfdf5; }
.ifc.dn { border-color:#fecaca; background:#fff5f5; }
.tbdg { font-size:9px; padding:2px 7px; border-radius:4px; font-weight:700; border:1px solid; }
.tbdg-nvr { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
.tbdg-bts { background:#ecfdf5; color:#047857; border-color:#a7f3d0; }
.tbdg-epc { background:#fffbeb; color:#b45309; border-color:#fde68a; }
.tbdg-def { background:#f1f5f9; color:#475569; border-color:#cbd5e1; }
.d-ico { width:28px; height:28px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; font-size:13px; margin-right:7px; vertical-align:middle; flex-shrink:0; }
.ico-nvr { background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; }
.ico-bts { background:#d1fae5; color:#047857; border:1px solid #a7f3d0; }
.ico-epc { background:#fef3c7; color:#b45309; border:1px solid #fde68a; }
.ico-def { background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; }
.dev-tbl-card { background:#fff; border:1.5px solid #e2e8f0; border-radius:14px; overflow:hidden; margin-bottom:18px; box-shadow:0 2px 8px rgba(0,0,0,.05); }
.dev-tbl-hdr  { padding:12px 18px; border-bottom:1.5px solid #e2e8f0; font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.09em; color:#94a3b8; display:flex; align-items:center; gap:6px; background:#f8fafc; }
.dtbl { width:100%; border-collapse:collapse; }
.dtbl thead th { background:#f8fafc; color:#94a3b8; font-size:8.5px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; padding:8px 14px; border-bottom:1.5px solid #e2e8f0; text-align:left; white-space:nowrap; }
.dtbl tbody td { padding:10px 14px; border-bottom:1px solid #f0f4f8; font-size:12px; color:#0f172a; vertical-align:middle; }
.dtbl tbody tr:last-child td { border-bottom:none; }
.dtbl tbody tr:hover td { background:#f8fafc; }
.dtbl tr.drow-off td { background:#fff5f5; }
.sig { display:flex; align-items:flex-end; gap:2px; height:13px; }
.sig span { width:3px; border-radius:1px; background:#e2e8f0; }
.sig.s4 span:nth-child(-n+4) { background:#22c55e; }
.sig.s3 span:nth-child(-n+3) { background:#22c55e; }
.sig.s2 span:nth-child(-n+2) { background:#f59e0b; }
.sig.s1 span:nth-child(-n+1) { background:#ef4444; }
.cam-bar-wrap { display:flex; align-items:center; gap:6px; }
.cam-bar { width:56px; height:4px; background:#f1f5f9; border-radius:2px; overflow:hidden; flex-shrink:0; }
.cam-bar-fill { height:100%; border-radius:2px; }
@media(max-width:700px){.wkpi{grid-template-columns:1fr 1fr}}
</style>

<div class="nms">
<?php echo $__env->make('nms.partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div style="display:flex;align-items:center;gap:5px;margin-bottom:11px;font-size:12px;font-weight:600;color:var(--muted)">
    <a href="<?php echo e(route('nms.pages.regions')); ?>" style="color:var(--blue);text-decoration:none">Warehouses</a>
    <i class="ri-arrow-right-s-line"></i>
    <span id="bcR"></span>
    <i class="ri-arrow-right-s-line"></i>
    <span id="bcW" style="color:var(--text)">Loading…</span>
</div>

<div class="wh-hero">
    <div class="wh-hero-top">
        <div style="display:flex;align-items:center;gap:14px;position:relative;z-index:1">
            <div class="wh-hero-ico"><i class="ri-building-4-line"></i></div>
            <div>
                <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.4);margin-bottom:3px">Warehouse</div>
                <div class="wh-hero-name" id="wName">Loading…</div>
                <div class="wh-hero-meta" id="wMeta"></div>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;position:relative;z-index:1">
            <div id="wStatus"></div>
            <div style="font-size:10px;color:rgba(255,255,255,.35)" id="wUpd"></div>
        </div>
    </div>
    <div class="wkpi" id="kpiRow"></div>
</div>

<div class="dev-tbl-card" id="devTblCard" style="display:none">
    <div class="dev-tbl-hdr"><i class="ri-server-line"></i> All Devices at this Warehouse</div>
    <div style="overflow-x:auto">
        <table class="dtbl">
            <thead><tr><th>Device Name</th><th>Type</th><th>IP / Port</th><th>Cameras / Clients</th><th>Last Polled</th><th>Status</th></tr></thead>
            <tbody id="devTblBody"></tbody>
        </table>
    </div>
</div>

<div id="secBts"  style="display:none"><div class="wsec"><i class="ri-router-line"></i> BTS </div><div id="btsCards"></div></div>
<div id="secNvr"  style="display:none"><div class="wsec"><i class="ri-hard-drive-2-line"></i> NVR  — Camera Recorders</div><div id="nvrCards"></div></div>



</div>

<span id="regionDetailBase" style="display:none"><?php echo e(route('nms.pages.region.detail', '')); ?></span>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
'use strict';
const NMS = '<?php echo e($nmsBase); ?>';
const WID = '<?php echo e($warehouseId); ?>';
const RB  = document.getElementById('regionDetailBase').textContent.trim();
const $   = id => document.getElementById(id);
const bwC = {};
const MAX = 125_000_000;

const fmtBps = b => {
    if (!b||b<=0) return '—';
    if (b<1e3) return b+' bps';
    if (b<1e6) return (b/1e3).toFixed(1)+' Kbps';
    if (b<1e9) return (b/1e6).toFixed(2)+' Mbps';
    return (b/1e9).toFixed(2)+' Gbps';
};
const ago = iso => {
    if (!iso) return '—';
    try {
        const s=Math.floor((Date.now()-new Date(iso))/1000);
        if(s<5)  return 'just now';
        if(s<60) return s+'s ago';
        if(s<3600) return Math.floor(s/60)+'m ago';
        if(s<86400) return Math.floor(s/3600)+'h ago';
        return Math.floor(s/86400)+'d ago';
    } catch {return '—';}
};
const pct  = (a,b) => b>0?Math.min(100,Math.round(a/b*100)):0;
const cl   = h => (h||[]).filter(r=>(r.bw_in||0)<=MAX&&(r.bw_out||0)<=MAX);
const nipH = (a,p) => a?`<span class="nip">${a}${p?`<span class="npt">:${p}</span>`:''}</span>`:'—';
const bdg  = on  => `<span class="chip ${on?'chi-ok':'chi-err'}"><span class="chi-dot"></span>${on?'Online':'Offline'}</span>`;
const bwR  = (l,v,m,c) => {
    const p=pct(v,m||1);
    return `<div class="bwr"><span class="bwl">${l}</span><div class="bwt"><div class="bwf" style="width:${p}%;background:${c}"></div></div><span class="bwv" style="color:${c}">${fmtBps(v)}</span></div>`;
};
const gH = (v,m,c,l) => {
    const CIRC=2*Math.PI*19, off=CIRC*(1-pct(v,m||1)/100);
    return `<div class="gw"><svg width="52" height="52" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="19" fill="none" stroke="#f1f5f9" stroke-width="4.5"/>
        <circle cx="26" cy="26" r="19" fill="none" stroke="${c}" stroke-width="4.5"
            stroke-dasharray="${CIRC}" stroke-dashoffset="${off}" stroke-linecap="round"/>
    </svg><div class="gi"><div class="gv" style="color:${c}">${pct(v,m||1)}%</div><div class="gl">${l}</div></div></div>`;
};
const sig = r => {
    const l=!r?2:r>-60?4:r>-70?3:r>-80?2:1;
    return `<div class="sig s${l}"><span style="height:3px"></span><span style="height:6px"></span><span style="height:9px"></span><span style="height:12px"></span></div>`;
};

function drawChart(id,iH,oH,lb) {
    if(bwC[id]) bwC[id].destroy();
    const ctx=$(id); if(!ctx) return;
    const all=[...iH,...oH].filter(v=>v>0);
    const yMax=all.length?Math.max(...all)*1.25:1000;
    bwC[id]=new Chart(ctx,{type:'line',data:{labels:lb,datasets:[
        {label:'BW In', data:iH,borderColor:'#3b82f6',backgroundColor:'rgba(59,130,246,.07)',fill:true,tension:.35,pointRadius:0,pointHoverRadius:3,borderWidth:1.5},
        {label:'BW Out',data:oH,borderColor:'#f59e0b',backgroundColor:'rgba(245,158,11,.07)',fill:true,tension:.35,pointRadius:0,pointHoverRadius:3,borderWidth:1.5},
    ]},options:{
        responsive:true,maintainAspectRatio:false,
        interaction:{mode:'index',intersect:false},
        plugins:{
            legend:{display:true,position:'top',align:'end',labels:{font:{size:10},boxWidth:7,padding:8,usePointStyle:true}},
            tooltip:{backgroundColor:'#0f172a',titleFont:{family:'IBM Plex Mono',size:9},bodyFont:{family:'IBM Plex Mono',size:9},padding:8,cornerRadius:5,
                callbacks:{label:c=>' '+c.dataset.label+': '+fmtBps(c.raw)}}
        },
        scales:{
            x:{grid:{display:false},ticks:{font:{family:'IBM Plex Mono',size:7.5},color:'#94a3b8',maxTicksLimit:8,maxRotation:0}},
            y:{min:0,max:yMax,grid:{color:'rgba(0,0,0,.03)'},ticks:{callback:v=>fmtBps(v),font:{family:'IBM Plex Mono',size:7.5},color:'#94a3b8',maxTicksLimit:5}}
        }
    }});
}

async function load() {
    try {
        const r  = await fetch(NMS+'/warehouses/'+WID);
        const wh = r.ok?(await r.json()).data||{}:{};
        const devs = wh.devices||[];

        const rn=wh.region_name||'';
        $('bcR').innerHTML=`<a href="${RB}/${encodeURIComponent(rn)}" style="color:var(--blue);text-decoration:none">${rn}</a>`;
        $('bcW').textContent=wh.warehouse_name||WID;
        $('wName').textContent=wh.warehouse_name||'Unknown';
        $('wMeta').textContent=rn+(wh.address&&wh.address!==rn+'/'+wh.warehouse_name?' · '+wh.address:'');
        $('wUpd').textContent='Updated '+new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit'});

        const nvrs=devs.filter(d=>d.type==='NVR'||d.type==='DVR');
        const nvrOn=nvrs.filter(d=>d.status==='Online').length;
        const anyOn=devs.some(d=>d.status==='Online');
        const hlth=nvrs.length===0?(anyOn?'Partial':'Down'):nvrOn/nvrs.length>=.8?'Healthy':nvrOn>0?'Partial':'Down';
        const sc=hlth==='Healthy'?'var(--green)':hlth==='Partial'?'var(--orange)':'var(--red)';
        $('wStatus').innerHTML=`<div class="wh-badge" style="background:${sc}22;border-color:${sc}55;color:${sc}"><div class="wh-pulse" style="background:${sc}"></div>${hlth}</div>`;

        let tot=0,on=0,btsc=0;
        devs.forEach(d=>{if(d.cameras){tot+=d.cameras.total||0;on+=d.cameras.online||0;}if(d.type==='BTS')btsc+=d.client_count||0;});
        const off=tot-on, dOn=devs.filter(d=>d.status==='Online').length, dOff=devs.length-dOn;

        // ── HDD Storage — one cell per NVR (sum all its disks) ───────────
        const nvrDisks = [];
        devs.forEach(d=>{
            if(!(d.storage&&d.storage.length)) return;
            const tot  = d.storage.reduce((s,x)=>s+(x.total||0),0);
            const used = d.storage.reduce((s,x)=>s+(x.used||0),0);
            const hasErr = d.storage.some(x=>x.status&&!/running|idle|ok|healthy/i.test(x.status));
            nvrDisks.push({ name:d.device_name||d.name||'NVR', diskCount:d.storage.length, tot, used, hasErr });
        });
        const sDiskCount = nvrDisks.length;
        const sTot  = nvrDisks.reduce((s,x)=>s+x.tot,0);
        const sUsed = nvrDisks.reduce((s,x)=>s+x.used,0);
        const sPct  = sTot>0?Math.round(sUsed/sTot*100):0;

        const pills=[['Total Devices',devs.length,dOn+' on · '+dOff+' off','var(--text)']];
        if(tot) pills.push(['Total Cameras',tot,pct(on,tot)+'% online','var(--text)']);
        if(tot) pills.push(['Online Cameras',on,pct(on,tot)+'%','var(--green)']);
        if(off) pills.push(['Offline Cameras',off,pct(off,tot)+'%','var(--red)']);
        if(btsc)pills.push(['CPE Clients',btsc,'connected from 1 BTS','var(--text)']);

        const fmtTB = gb => gb>=1000?(gb/1000).toFixed(1)+' TB':gb+' GB';

        const colMap={'var(--text)':'sb-navy','var(--green)':'sb-green','var(--red)':'sb-red'};
        const genericHtml=pills.map(([l,v,s,c])=>{
            const cls=colMap[c]||'sb-navy';
            return `<div class="wkc"><div class="wkl">${l}</div><div class="wkv">${v}</div><div class="wks">${s}</div></div>`;
        }).join('');

        let storageHtml='';
        if(sDiskCount){
            storageHtml = nvrDisks.map((nvr,idx)=>{
                const dPct   = nvr.tot>0?Math.round(nvr.used/nvr.tot*100):0;
                const isEmpty= nvr.tot===0||dPct===0;
                const dStatus= nvr.hasErr?'Error':dPct>=90?'Critical':dPct>=70?'Warning':isEmpty?'Empty':'Healthy';
                const dCol   = dStatus==='Error'||dStatus==='Critical'?'#ef4444':dStatus==='Warning'?'#f59e0b':isEmpty?'#94a3b8':'#22c55e';
                const dLabel = sDiskCount===1?'HDD Storage':`HDD — ${nvr.name}`;
                return `<div class="wkc wkc-sto">
                    <div class="wkl">${dLabel}</div>
                    <div class="wkv" style="color:${dCol}">${isEmpty?'—':dPct+'%'}</div>
                    <div class="sto-bar"><div class="sto-bar-f" style="width:${dPct}%;background:${dCol}"></div></div>
                    <div class="wks" style="margin-top:4px">${isEmpty?'No data':fmtTB(nvr.used)+' / '+fmtTB(nvr.tot)}</div>
                </div>`;
            }).join('');
        }

        $('kpiRow').innerHTML=genericHtml+storageHtml;

        if(devs.length) {
            const typeIco={NVR:'ri-hard-drive-2-line',DVR:'ri-hard-drive-2-line',BTS:'ri-router-line','Embedded PC':'ri-computer-line',EPC:'ri-computer-line',Workstation:'ri-desktop-line',Router:'ri-router-fill',HDD:'ri-database-2-line'};
            const typeIcoCls={NVR:'ico-nvr',DVR:'ico-nvr',BTS:'ico-bts','Embedded PC':'ico-epc',EPC:'ico-epc'};
            const typeBdgCls={NVR:'tbdg-nvr',DVR:'tbdg-nvr',BTS:'tbdg-bts','Embedded PC':'tbdg-epc',EPC:'tbdg-epc'};
            const typeLabel={NVR:'NVR',DVR:'DVR',BTS:'BTS','Embedded PC':'Embedded PC',EPC:'EPC',Workstation:'Workstation',Router:'Router',HDD:'HDD / Storage'};
            $('devTblBody').innerHTML=devs.map(d=>{
                const isOn=d.status==='Online';
                const ico=typeIco[d.type]||'ri-server-line';
                const icoCls=typeIcoCls[d.type]||'ico-def';
                const bdgCls=typeBdgCls[d.type]||'tbdg-def';
                const lbl=typeLabel[d.type]||d.type||'Device';
                const cams=d.cameras;
                const camTot=cams?.total||0, camOn=cams?.online||0;
                const camPct=pct(camOn,camTot);
                const camCol=camPct>=80?'var(--green)':camPct>=50?'var(--orange)':'var(--red)';
                let camCell='—';
                if(cams&&camTot>0){
                    camCell=`<div class="cam-bar-wrap"><div class="cam-bar"><div class="cam-bar-fill" style="width:${camPct}%;background:${camCol}"></div></div><span style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:var(--muted)">${camOn}/${camTot}</span></div>`;
                } else if(d.type==='BTS'){
                    camCell=`<span style="font-size:10.5px;color:var(--muted)">${d.client_count||0} clients</span>`;
                }
                const bwIn=d.bw_in_bytes||0, bwOut=d.bw_out_bytes||0;
                return`<tr class="${isOn?'':'drow-off'}">
                    <td style="font-weight:700"><span class="d-ico ${icoCls}"><i class="${ico}" style="font-size:13px"></i></span>${d.name}</td>
                    <td><span class="tbdg ${bdgCls}">${lbl}</span></td>
                    <td>${nipH(d.ip,d.port)}</td>
                    <td>${camCell}</td>

                    <td style="font-size:10px;color:var(--muted)">${ago(d.last_polled)}</td>
                    <td>${bdg(isOn)}</td>
                </tr>`;
            }).join('');
            $('devTblCard').style.display='';
        }

        const btsList  =devs.filter(d=>d.type==='BTS');
        const nvrList  =devs.filter(d=>d.type==='NVR'||d.type==='DVR');
        const epcList  =devs.filter(d=>d.type==='Embedded PC'||d.type==='EPC');
        const otherList=devs.filter(d=>!['NVR','DVR','BTS','Embedded PC','EPC'].includes(d.type));

        await renderBts(btsList);
        renderNvr(nvrList);
        // renderEpc hidden
        // renderOther hidden

    } catch(e){console.error(e);}
}

async function renderBts(list) {
    if(!list.length) return;
    $('secBts').style.display='';
    $('btsCards').innerHTML=list.map((_,i)=>
        `<div class="dcard" id="bC_${i}"><div class="dcard-b" style="text-align:center;color:var(--muted);font-size:12px;padding:20px"><div class="nms-spinner" style="margin:0 auto 8px"></div>Loading BTS detail…</div></div>`
    ).join('');

    const dets=await Promise.all(list.map(d=>
        fetch(NMS+'/devices/'+d.device_id+'/bts-detail').then(r=>r.ok?r.json():null).catch(()=>null)
    ));

    list.forEach((d,idx)=>{
        const det=dets[idx]?.data||null;
        const on=d.status==='Online';
        const bwIn=det?.bw_in||d.bw_in_bytes||0;
        const bwOut=det?.bw_out||d.bw_out_bytes||0;
        const clients=det?.clients||[];
        const radio=det?.radio||{};
        const cnt=det?.client_count||d.client_count||0;
        const cid='bC_chart_'+idx;
        const hist=cl(det?.bw_history||[]);
        const iH=hist.length?hist.map(h=>h.bw_in||0) :[bwIn*.2,bwIn*.5,bwIn*.7,bwIn*.9,bwIn,bwIn];
        const oH=hist.length?hist.map(h=>h.bw_out||0):[bwOut*.2,bwOut*.4,bwOut*.65,bwOut*.85,bwOut,bwOut];
        const lb=hist.length?hist.map(h=>h.time||'') :['','','','','','now'];
        const hasRad=radio.frequency||radio.channel_width||radio.tx_power!=null||radio.firmware;

        const cRows=clients.length?clients.map(c=>{
            const tx=c.tx_bytes||0, rx=c.rx_bytes||0, has=tx||rx;
            return`<tr>
                <td style="font-weight:700;font-size:11.5px">${c.name||'—'}</td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:9.5px;color:var(--muted)">${c.ip||'—'}</td>
                <td style="font-size:10.5px">${c.firmware||'—'}</td>
                <td><div style="display:flex;align-items:center;gap:4px">${c.signal!=null?sig(c.signal):''}<span style="font-family:'IBM Plex Mono',monospace;font-size:9.5px;color:var(--muted)">${c.signal!=null?c.signal+' dBm':'—'}</span></div></td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:9.5px">${c.snr!=null?c.snr+'dB':'—'}</td>

                <td>${bdg(true)}</td>
            </tr>`;
        }).join(''):`<tr><td colspan="9" style="text-align:center;padding:12px;color:var(--muted);font-size:11px">${on?'No clients connected':'Device offline'}</td></tr>`;

        let body=`<div class="bts-sum">

            <div class="bts-sum-mid">
                <div><span class="bts-sum-num">${cnt}</span><span style="font-size:12px;color:var(--muted);font-weight:500"> CPE clients connected</span></div>

            </div>
        </div>`;

        body+=`<div style="margin-bottom:${hasRad||iH.some(v=>v>0)?'12':'0'}px">
            <div class="sublbl">CPE Clients (${clients.length})</div>
            <div class="gtbl-wrap"><table class="gtbl">
                <thead><tr><th>Name</th><th>IP</th><th>Firmware</th><th>Signal</th><th>SNR</th><th>Status</th></tr></thead>
                <tbody>${cRows}</tbody>
            </table></div>
        </div>`;

        // if(hasRad){
        //     body+=`<div class="rpills">
        //         ${radio.frequency?   `<div class="rp"><div class="rpv">${radio.frequency}<span style="font-size:8px"> MHz</span></div><div class="rpl">Frequency</div></div>`:''}
        //         ${radio.channel_width?`<div class="rp"><div class="rpv">${radio.channel_width}<span style="font-size:8px"> MHz</span></div><div class="rpl">Ch Width</div></div>`:''}
        //         ${radio.tx_power!=null?`<div class="rp"><div class="rpv">${radio.tx_power}<span style="font-size:8px"> dBm</span></div><div class="rpl">TX Power</div></div>`:''}
        //         ${radio.firmware?`<div class="rp"><div class="rpv" style="font-size:11px">${radio.firmware}</div><div class="rpl">Firmware</div></div>`:''}
        //     </div>`;
        // }

/* bandwidth chart hidden */



        $('bC_'+idx).outerHTML=`<div class="dcard dcard-bts${!on?' doff':''}">
            <div class="dcard-h">
                <div class="dcard-ico ico-bts"><i class="ri-router-line"></i></div>
                <div style="flex:1;min-width:0">
                    <div class="dcard-name">${d.name}</div>
                    <div class="dcard-sub">${nipH(d.ip,d.port)}<span style="font-size:9.5px;color:var(--muted)">${cnt} CPE client${cnt!==1?'s':''} · BTS</span></div>
                </div>
                ${bdg(on)}
            </div>
            <div class="dcard-b">${body}</div>
        </div>`;

/* drawChart hidden */
    });
}

function renderNvr(list) {
    if(!list.length) return;
    $('secNvr').style.display='';
    $('nvrCards').innerHTML=list.map((d,idx)=>{
        const on=d.status==='Online';
        const cams=d.cameras, tot=cams?.total||0, con=cams?.online||0, coff=tot-con;
        const cp=pct(con,tot), cc=cp>=80?'var(--green)':cp>=50?'var(--orange)':'var(--red)';
        const chs=cams?.channels||[];
        const bwIn=d.bw_in_bytes||0, bwOut=d.bw_out_bytes||0, maxBw=Math.max(bwIn,bwOut,1);

        const rows=chs.map((c,i)=>{
            const co=c.status==='Online';
            return`<tr class="${co?'':'crow-off'}">
                <td style="font-family:'IBM Plex Mono',monospace;font-size:9px;color:var(--muted);font-weight:700">${c.channel||(i+1)}</td>
                <td style="font-weight:700;font-size:11.5px">${c.name||'—'}</td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:9.5px;color:var(--muted)">${c.ip||'—'}</td>
                <td style="font-size:10.5px">${c.res||'—'}</td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:9.5px">${c.fps?c.fps+' fps':'—'}</td>
                <td style="font-size:10.5px">${c.codec||'—'}</td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:9.5px;color:var(--muted)">${c.bitrate||'—'}</td>
                <td>${bdg(co)}</td>
            </tr>`;
        }).join('');

        let body='';

        if(tot>0){
            body+=`<div class="nvr-sum">
                ${gH(con,tot,cc,'Cams')}
                <div class="nvr-sum-mid">
                    <div><span class="nvr-sum-num" style="color:${cc}">${con}</span><span class="nvr-sum-den"> / ${tot} cameras</span><span class="nvr-sum-pct" style="color:${cc}">${cp}%</span></div>
                    <div style="display:flex;gap:5px;margin-top:4px;flex-wrap:wrap">
                        <span class="chip chi-ok"><span class="chi-dot"></span>${con} online</span>
                        ${coff>0?`<span class="chip chi-err"><span class="chi-dot"></span>${coff} offline</span>`:''}
                    </div>
                </div>

            </div>`;
        }

        if(chs.length){
            body+=`<div class="sublbl">${chs.length} Cameras${coff>0?' · '+coff+' offline':''}</div>
            <div class="cam-tbl-wrap"><div class="cam-tbl-scroll">
                <table class="ctbl">
                    <thead><tr><th>CH</th><th>Camera Name</th><th>IP Address</th><th>Resolution</th><th>FPS</th><th>Codec</th><th>Bitrate</th><th>Status</th></tr></thead>
                    <tbody>${rows}</tbody>
                </table>
            </div></div>`;
        }

        // ── HDD Storage ──────────────────────────────────────────────
        const sto=d.storage||[];
        if(sto.length){
            const sT=sto.reduce((s,x)=>s+(x.total||0),0);
            const sU=sto.reduce((s,x)=>s+(x.used||0),0);
            const sF=sto.reduce((s,x)=>s+(x.free||0),0);
            const sP=sT>0?Math.round(sU/sT*100):0;
            const sC=sP>=90?'var(--red)':sP>=70?'var(--orange)':'var(--green)';
            const sBg=sP>=90?'var(--red-l)':sP>=70?'var(--orange-l)':'var(--green-l)';
            const sTx=sP>=90?'var(--red-d)':sP>=70?'var(--orange-d)':'var(--green-d)';
            const sE=sto.filter(x=>x.status&&x.status.toLowerCase()!=='running'&&x.status.toLowerCase()!=='idle').length;
            const sMsg=sP>=90?`Critically full — ${sP}% used`:sP>=70?`Getting full — ${sP}% used`:`${sF.toLocaleString()} GB free`;
            body+=`<div style="margin-top:11px;padding-top:11px;border-top:1px solid #f0f4f8">
                <div class="sublbl" style="display:flex;align-items:center;gap:4px"><i class="ri-hard-drive-2-line" style="font-size:10px"></i>HDD Storage </div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:7px">
                    <div style="flex:1">
                        <div style="display:flex;justify-content:space-between;font-size:9.5px;margin-bottom:3px">
                            <span style="color:var(--muted);font-weight:600">${sU.toLocaleString()} / ${sT.toLocaleString()} GB</span>
                            <span style="font-family:'IBM Plex Mono',monospace;font-weight:800;color:${sC}">${sP}%</span>
                        </div>
                        <div style="height:5px;background:#f1f5f9;border-radius:3px;overflow:hidden">
                            <div style="height:100%;width:${sP}%;background:${sC};border-radius:3px"></div>
                        </div>
                    </div>
                    <div style="background:${sE>0?'var(--red-l)':'var(--green-l)'};border-radius:6px;padding:3px 8px;text-align:center;flex-shrink:0">
                        <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:800;color:${sE>0?'var(--red-d)':'var(--green-d)'}">${sE>0?sE:'✓'}</div>
                        <div style="font-size:7.5px;font-weight:700;text-transform:uppercase;color:${sE>0?'var(--red-d)':'var(--green-d)'}">${sE>0?'err':'ok'}</div>
                    </div>
                </div>
                <div style="background:${sBg};border-radius:5px;padding:4px 9px;font-size:9.5px;font-weight:700;color:${sTx}">${sMsg}</div>
            </div>`;
        }



        return`<div class="dcard dcard-nvr${!on?' doff':''}">
            <div class="dcard-h">
                <div class="dcard-ico ico-nvr"><i class="ri-hard-drive-2-line"></i></div>
                <div style="flex:1;min-width:0">
                    <div class="dcard-name">${d.name}</div>
                    <div class="dcard-sub">${nipH(d.ip,d.port)}<span style="font-size:9.5px;color:var(--muted)">${d.type} · ${tot} cameras</span></div>
                </div>
                ${bdg(on)}
            </div>
            ${body?`<div class="dcard-b">${body}</div>`:''}
        </div>`;
    }).join('');
}

function renderEpc(list) {
    if(!list.length) return;
    $('secEpc').style.display='';
    $('epcCards').innerHTML=list.map(d=>{
        const on=d.status==='Online';
        const ifaces=d.interfaces||[];
        const upCnt=ifaces.filter(i=>i.status==='Up'||i.status==='Active').length;
        const dnCnt=ifaces.length-upCnt;
        const sorted=[...ifaces.filter(i=>i.status!=='Up'&&i.status!=='Active'),...ifaces.filter(i=>i.status==='Up'||i.status==='Active')];
        let body='';
        if(ifaces.length){
            body+=`<div style="display:flex;align-items:center;gap:6px;margin-bottom:9px;flex-wrap:wrap">
                <span style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)">Internet</span>
                <span class="chip chi-ok"><span class="chi-dot"></span>Up ${upCnt}</span>
                ${dnCnt>0?`<span class="chip chi-err"><span class="chi-dot"></span>Down ${dnCnt}</span>`:''}
            </div>`;
            body+=sorted.map(i=>{
                const isUp=i.status==='Up'||i.status==='Active';
                const mBw=Math.max(i.bw_in_bps||0,i.bw_out_bps||0,1);
                const hBw=i.bw_in_bps||i.bw_out_bps;
                return`<div class="ifc ${isUp?'up':'dn'}">
                    <div style="display:flex;align-items:center;justify-content:space-between;${hBw?'margin-bottom:6px':''}">
                        <div style="display:flex;align-items:center;gap:5px">
                            <i class="ri-global-line" style="font-size:11px;color:${isUp?'var(--green)':'var(--red)'}"></i>
                            <span style="font-size:11px;font-weight:800;color:var(--text)">${i.name}</span>
                            <span style="font-size:9.5px;font-weight:700;color:${isUp?'var(--green)':'var(--red)'}">${isUp?'● Up':'● Down'}</span>
                        </div>
                        ${i.ip?`<span style="font-family:'IBM Plex Mono',monospace;font-size:9.5px;color:var(--muted)">${i.ip}</span>`:''}
                    </div>

                </div>`;
            }).join('');
        }

        return`<div class="dcard dcard-epc${!on?' doff':''}">
            <div class="dcard-h">
                <div class="dcard-ico ico-epc"><i class="ri-computer-line"></i></div>
                <div style="flex:1;min-width:0">
                    <div class="dcard-name">${d.name}</div>
                    <div class="dcard-sub">${nipH(d.ip,d.port)}<span style="font-size:9.5px;color:var(--muted)">${d.type} · Edge Computing Unit</span></div>
                </div>
                ${bdg(on)}
            </div>
            ${body?`<div class="dcard-b">${body}</div>`:''}
        </div>`;
    }).join('');
}

function renderOther(list) {
    if(!list.length) return;
    $('secOther').style.display='';
    const typeDesc={Workstation:'Operator workstation / PC',Router:'WAN / internet gateway',HDD:'Hard disk storage device'};
    $('otherCards').innerHTML=list.map(d=>{
        const on=d.status==='Online';
        const bwIn=d.bw_in_bytes||0, bwOut=d.bw_out_bytes||0, mBw=Math.max(bwIn,bwOut,1);
        const desc=typeDesc[d.type]||d.type||'Device';
        let body='';


        return`<div class="dcard dcard-other${!on?' doff':''}">
            <div class="dcard-h">
                <div class="dcard-ico ico-def"><i class="ri-server-line"></i></div>
                <div style="flex:1;min-width:0">
                    <div class="dcard-name">${d.name}</div>
                    <div class="dcard-sub">${nipH(d.ip,d.port)}<span style="font-size:9.5px;color:var(--muted)">${desc}</span></div>
                </div>
                ${bdg(on)}
            </div>
            ${body?`<div class="dcard-b">${body}</div>`:''}
        </div>`;
    }).join('');
}

load();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\nms\warehouse-detail.blade.php ENDPATH**/ ?>