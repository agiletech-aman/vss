@extends('layout.master')
@section('title','NMS — Warehouses')
@section('content')
@include('nms.partials.styles')

<style>
.wh-page { font-family: 'DM Sans', -apple-system, sans-serif; }

/* Tab nav */
.wh-tabs { display:flex; align-items:center; gap:2px; background:var(--card); border:1.5px solid var(--border); border-radius:10px; padding:4px; margin-bottom:16px; }
.wh-tab  { padding:7px 16px; font-size:12.5px; font-weight:600; color:var(--muted); border-radius:7px; cursor:pointer; text-decoration:none; transition:all .15s; border:none; background:none; }
.wh-tab:hover  { color:var(--text); background:var(--bg, #f1f5f9); }
.wh-tab.active { color:var(--blue,#2563eb); background:var(--blue-l,#eff6ff); font-weight:700; }
.wh-tab-right  { margin-left:auto; display:flex; align-items:center; gap:6px; font-size:11px; font-weight:700; color:var(--green,#059669); }

/* Summary strip */
.wh-strip { display:grid; grid-template-columns:repeat(auto-fit,minmax(120px,1fr)); gap:10px; margin-bottom:16px; }
.wh-kpi   { background:var(--card); border:1.5px solid var(--border); border-radius:10px; padding:12px 14px; }
.wh-kpi-lbl { font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; color:var(--muted); margin-bottom:4px; }
.wh-kpi-val { font-family:'IBM Plex Mono',monospace; font-size:22px; font-weight:800; color:var(--text); line-height:1; }
.wh-kpi-sub { font-size:10px; color:var(--muted); margin-top:2px; font-weight:500; }

/* Filter bar */
.wh-filter-bar { background:var(--card); border:1.5px solid var(--border); border-radius:10px; padding:12px 16px; margin-bottom:14px; display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.wh-filter-lbl { font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; display:block; margin-bottom:3px; }
.wh-filter-sel, .wh-filter-inp { font-size:12px; padding:6px 10px; border:1.5px solid var(--border); border-radius:7px; background:var(--card); color:var(--text); outline:none; }
.wh-filter-sel:focus, .wh-filter-inp:focus { border-color:var(--blue,#2563eb); }
.wh-cnt { margin-left:auto; font-size:11.5px; font-weight:700; color:var(--muted); }

/* Table card */
.wh-card { background:var(--card); border:1.5px solid var(--border); border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.04); }
.wh-card-hdr { padding:12px 18px; border-bottom:1.5px solid var(--border); background:#f8fafc; display:flex; align-items:center; gap:8px; }
.wh-card-title { font-size:12px; font-weight:800; color:var(--text); text-transform:uppercase; letter-spacing:.06em; }

/* Table */
.wh-tbl { width:100%; border-collapse:collapse; }
.wh-tbl thead th {
    background:#f8fafc; color:var(--muted);
    font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.07em;
    padding:9px 14px; border-bottom:1.5px solid var(--border);
    text-align:left; white-space:nowrap; position:sticky; top:0; z-index:1;
}
.wh-tbl tbody td { padding:11px 14px; border-bottom:1px solid #f0f4f8; font-size:12.5px; color:var(--text); vertical-align:middle; }
.wh-tbl tbody tr:last-child td { border-bottom:none; }
.wh-tbl tbody tr { cursor:pointer; transition:background .12s; }
.wh-tbl tbody tr:hover td { background:#f8fafc; }

/* Device pill */
.dev-pill { display:inline-flex; flex-direction:column; align-items:center; gap:1px; min-width:36px; }
.dev-tot  { font-family:'IBM Plex Mono',monospace; font-size:13px; font-weight:800; color:var(--text); line-height:1; }
.dev-stat { font-size:10px; font-weight:600; display:flex; gap:3px; }
.dev-on   { color:#059669; }
.dev-off  { color:#dc2626; }
.dev-none { color:var(--muted); font-size:12px; }

/* Status dot */
.wh-dot { width:8px; height:8px; border-radius:50%; display:inline-block; flex-shrink:0; }

/* Cam uptime bar */
.cam-bar-wrap { display:flex; align-items:center; gap:7px; }
.cam-bar-track { width:52px; height:5px; background:#e9eef5; border-radius:3px; overflow:hidden; }
.cam-bar-fill  { height:100%; border-radius:3px; }
.cam-pct       { font-family:'IBM Plex Mono',monospace; font-size:11px; font-weight:800; min-width:32px; }

/* View btn */
.wh-view { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; background:var(--blue-l,#eff6ff); color:var(--blue,#2563eb); border:1.5px solid var(--blue-b,#bfdbfe); border-radius:6px; font-size:11px; font-weight:700; text-decoration:none; transition:all .15s; }
.wh-view:hover { background:var(--blue,#2563eb); color:#fff; }

/* Loader */
.wh-loader { display:flex; align-items:center; justify-content:center; padding:36px; gap:8px; color:var(--muted); font-size:12px; font-weight:600; }
.wh-spin { width:16px; height:16px; border:2.5px solid var(--border); border-top-color:var(--blue,#2563eb); border-radius:50%; animation:whSpin .7s linear infinite; }
@keyframes whSpin { to { transform:rotate(360deg); } }
@keyframes whFade { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
.wh-row-in { animation:whFade .2s ease both; }
</style>

<div class="wh-page">

{{-- Tab nav --}}
<div class="wh-tabs">
    <a href="{{ route('dashboard') }}"            class="wh-tab">Dashboard</a>
    <a href="{{ route('nms.pages.regions') }}"    class="wh-tab">Regions</a>
    <a href="{{ route('nms.pages.warehouses') }}" class="wh-tab active">Warehouses</a>
    <a href="{{ route('nms.pages.map') }}"        class="wh-tab">Live Map</a>
    <div class="wh-tab-right">
        <span style="width:7px;height:7px;border-radius:50%;background:#059669;animation:pulse 2s infinite"></span>
        Updated <span id="nmsNavTime">—</span>
    </div>
</div>

{{-- KPI strip --}}
<div class="wh-strip" id="kpiStrip" style="display:none">
    <div class="wh-kpi"><div class="wh-kpi-lbl">Warehouses</div><div class="wh-kpi-val" id="kTotal">—</div></div>
    <div class="wh-kpi"><div class="wh-kpi-lbl">NVR Total</div><div class="wh-kpi-val" id="kNvr">—</div><div class="wh-kpi-sub" id="kNvrSub"></div></div>
    <div class="wh-kpi"><div class="wh-kpi-lbl">BTS</div><div class="wh-kpi-val" id="kBts">—</div><div class="wh-kpi-sub" id="kBtsSub"></div></div>
    <div class="wh-kpi"><div class="wh-kpi-lbl">CPE Connected Clients</div><div class="wh-kpi-val" id="kBtsC">—</div></div>
    <div class="wh-kpi"><div class="wh-kpi-lbl">Embedded PC</div><div class="wh-kpi-val" id="kEpc">—</div><div class="wh-kpi-sub" id="kEpcSub"></div></div>
    <div class="wh-kpi"><div class="wh-kpi-lbl">Workstation</div><div class="wh-kpi-val" id="kWs">—</div><div class="wh-kpi-sub" id="kWsSub"></div></div>
</div>

{{-- Filter bar --}}
<div class="wh-filter-bar">
    <div>
        <label class="wh-filter-lbl" for="fReg">Region</label>
        <select class="wh-filter-sel" id="fReg" onchange="applyF()">
            <option value="">All Regions</option>
        </select>
    </div>
    <div>
        <label class="wh-filter-lbl" for="fSt">Status</label>
        <select class="wh-filter-sel" id="fSt" onchange="applyF()">
            <option value="">All</option>
            <option value="healthy">Healthy</option>
            <option value="partial">Partial</option>
            <option value="down">Down</option>
        </select>
    </div>
    <div>
        <label class="wh-filter-lbl" for="fQ">Search</label>
        <input type="text" class="wh-filter-inp" id="fQ" placeholder="Warehouse name…" oninput="applyF()" style="width:200px">
    </div>
    <span class="wh-cnt" id="cnt">— warehouses</span>
</div>

{{-- Table --}}
<div class="wh-card">
    <div class="wh-card-hdr">
        <i class="ri-building-2-line" style="color:var(--blue,#2563eb)"></i>
        <span class="wh-card-title">All Warehouses</span>
    </div>
    <div style="overflow-x:auto">
        <table class="wh-tbl" style="min-width:860px">
            <thead>
                <tr>
                    <th>Warehouse Name</th>
                    <th>Region</th>
                    <th>Total Devices</th>
                    <th>Online</th>
                    <th>Offline</th>
                    <th style="text-align:center">View</th>
                </tr>
            </thead>
            <tbody id="tbl">
                <tr><td colspan="6"><div class="wh-loader"><div class="wh-spin"></div> Loading warehouses…</div></td></tr>
            </tbody>
        </table>
    </div>
</div>

</div>

<script>
const NMS     = '{{ $nmsBase }}';
const WH_BASE = '/nms/warehouses';
const fN      = n => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const g       = id => document.getElementById(id);
const sum     = (arr, key) => arr.reduce((s,w)=>s+(w[key]||0),0);
let all = [];

function camPct(w) {
    const t=w.total_cameras||0, o=w.online_cameras||0;
    return t>0 ? Math.round(o/t*100) : Math.round(w.camera_coverage_pct||w.uptime_pct||0);
}

function devPill(tot, on, off) {
    const t = tot||0, o = on||0, f = off||0;
    const clr = t===0 ? 'var(--muted)' : 'var(--text)';
    return `<div class="dev-pill">
        <span class="dev-tot" style="color:${clr}">${fN(t)}</span>
        <span class="dev-stat"><span class="dev-on">${fN(o)}</span><span style="color:var(--muted)">/</span><span class="dev-off">${fN(f)}</span></span>
    </div>`;
}

function statusDot(p) {
    const c = p>=80?'#22c55e':p>=40?'#f59e0b':'#ef4444';
    return `<span class="wh-dot" style="background:${c}" title="${p>=80?'Healthy':p>=40?'Partial':'Down'}"></span>`;
}

async function load() {
    try {
        const r = await fetch(NMS + '/warehouses');
        const j = await r.json();
        all = j.data || [];

        // KPI strip
        const kd = {
            nvr:   sum(all,'nvr_total'),  nvrOn: sum(all,'nvr_online'),
            bts:   sum(all,'bts_total'),  btsOn: sum(all,'bts_online'),
            btsC:  sum(all,'bts_clients'),
            epc:   sum(all,'epc_total'),  epcOn: sum(all,'epc_online'),
            ws:    sum(all,'ws_total'),   wsOn:  sum(all,'ws_online'),
        };
        g('kTotal').textContent = fN(all.length);
        g('kNvr').textContent   = fN(kd.nvr);   g('kNvrSub').textContent = fN(kd.nvrOn)+' on · '+fN(kd.nvr-kd.nvrOn)+' off';
        g('kBts').textContent   = fN(kd.bts);   g('kBtsSub').textContent = fN(kd.btsOn)+' on · '+fN(kd.bts-kd.btsOn)+' off';
        g('kBtsC').textContent  = fN(kd.btsC);
        g('kEpc').textContent   = fN(kd.epc);   g('kEpcSub').textContent = fN(kd.epcOn)+' on · '+fN(kd.epc-kd.epcOn)+' off';
        g('kWs').textContent    = fN(kd.ws);    g('kWsSub').textContent  = fN(kd.wsOn) +' on · '+fN(kd.ws-kd.wsOn) +' off';
        g('kpiStrip').style.display = '';

        // Region filter
        const regions = [...new Set(all.map(w=>w.region_name||'—'))].sort();
        g('fReg').innerHTML = '<option value="">All Regions</option>'
            + regions.map(r=>`<option value="${r}">${r}</option>`).join('');

        g('nmsNavTime').textContent = new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit'});
        applyF();
    } catch(e) {
        g('tbl').innerHTML = '<tr><td colspan="6" style="text-align:center;padding:2rem;color:#dc2626">Failed to load warehouse data</td></tr>';
    }
}

const PAGE_SIZE = 25;
let currentPage = 1;
let filteredList = [];

function applyF() {
    currentPage = 1;
    renderTable();
}

function renderTable() {
    const reg = g('fReg').value;
    const st  = g('fSt').value;
    const q   = g('fQ').value.toLowerCase().trim();

    filteredList = all.filter(w => {
        if (reg && w.region_name !== reg) return false;
        if (st) {
            const p = camPct(w);
            const status = p>=80?'healthy':p>=40?'partial':'down';
            if (status !== st) return false;
        }
        if (q && !(w.warehouse_name||'').toLowerCase().includes(q)) return false;
        return true;
    });

    const total = filteredList.length;
    const totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
    currentPage = Math.min(currentPage, totalPages);
    const start = (currentPage - 1) * PAGE_SIZE;
    const list  = filteredList.slice(start, start + PAGE_SIZE);

    g('cnt').textContent = fN(total) + ' warehouses';
    renderPagination(totalPages, total);

    if (!filteredList.length) {
        g('tbl').innerHTML = '<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--muted)">No warehouses found</td></tr>';
        return;
    }

    g('tbl').innerHTML = list.map((w,i) => {
        const url = WH_BASE + '/' + w.warehouse_id;
        const nvrT = w.nvr_total||0,  nvrOn = w.nvr_online||0,  nvrOff = w.nvr_offline||0;
        const btsT = w.bts_total||0,  btsOn = w.bts_online||0,  btsOff = w.bts_offline||0;
        const epcT = w.epc_total||0,  epcOn = w.epc_online||0,  epcOff = w.epc_offline||0;
        const wsT  = w.ws_total||0,   wsOn  = w.ws_online||0,   wsOff  = w.ws_offline||0;
        const tot  = nvrT+btsT+epcT+wsT;
        const on   = nvrOn+btsOn+epcOn+wsOn;
        const off  = nvrOff+btsOff+epcOff+wsOff;

        var row = `<tr class="wh-row-in" style="animation-delay:${Math.min(i,20)*12}ms" onclick="location.href='${url}'">`;
        row += `<td style="font-weight:800;font-size:14px">${w.warehouse_name}</td>`;
        row += `<td style="font-size:12px;color:var(--muted);font-weight:600">${w.region_name||'—'}</td>`;
        row += `<td><span style="font-family:'IBM Plex Mono',monospace;font-weight:700;font-size:14px">${fN(tot)}</span></td>`;
        row += `<td><span style="font-family:'IBM Plex Mono',monospace;font-weight:700;font-size:14px;color:#059669">${fN(on)}</span></td>`;
        row += `<td><span style="font-family:'IBM Plex Mono',monospace;font-weight:700;font-size:14px;color:#dc2626">${fN(off)}</span></td>`;

        row += `<td style="text-align:center"><a href="${url}" class="wh-view" onclick="event.stopPropagation()"><i class="ri-eye-line"></i> View</a></td>`;
        row += '</tr>';
        return row;
    }).join('');
}

function renderPagination(totalPages, total) {
    let el = g('pagination');
    if (!el) {
        el = document.createElement('div');
        el.id = 'pagination';
        document.querySelector('.wh-card').after(el);
    }
    if (totalPages <= 1) { el.innerHTML = ''; return; }
    const start = (currentPage-1)*PAGE_SIZE + 1;
    const end   = Math.min(currentPage*PAGE_SIZE, total);
    const pages = [];
    for (let i=1;i<=totalPages;i++) {
        if (i===1||i===totalPages||Math.abs(i-currentPage)<=2) pages.push(i);
        else if (pages[pages.length-1]!=='…') pages.push('…');
    }
    el.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 18px;background:var(--card);border:1.5px solid var(--border);border-radius:10px;margin-top:10px';
    el.innerHTML = `
        <span style="font-size:12px;color:var(--muted);font-weight:600">Showing ${fN(start)}–${fN(end)} of ${fN(total)}</span>
        <div style="display:flex;gap:4px;align-items:center">
            <button onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''} style="padding:5px 10px;border:1.5px solid var(--border);border-radius:6px;background:var(--card);color:var(--text);font-size:12px;font-weight:700;cursor:pointer;${currentPage===1?'opacity:.4':''}">&lsaquo;</button>
            ${pages.map(p=>p==='…'
                ? `<span style="padding:5px 8px;color:var(--muted)">…</span>`
                : `<button onclick="goPage(${p})" style="padding:5px 10px;border:1.5px solid ${p===currentPage?'var(--blue,#2563eb)':'var(--border)'};border-radius:6px;background:${p===currentPage?'var(--blue,#2563eb)':'var(--card)'};color:${p===currentPage?'#fff':'var(--text)'};font-size:12px;font-weight:700;cursor:pointer">${p}</button>`
            ).join('')}
            <button onclick="goPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''} style="padding:5px 10px;border:1.5px solid var(--border);border-radius:6px;background:var(--card);color:var(--text);font-size:12px;font-weight:700;cursor:pointer;${currentPage===totalPages?'opacity:.4':''}">&rsaquo;</button>
        </div>`;
}

function goPage(p) {
    const total = filteredList.length;
    const totalPages = Math.ceil(total/PAGE_SIZE);
    if (p<1||p>totalPages) return;
    currentPage = p;
    renderTable();
    document.querySelector('.wh-card').scrollIntoView({behavior:'smooth', block:'start'});
}

load();
</script>
@endsection
