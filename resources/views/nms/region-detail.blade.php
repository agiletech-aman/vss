@extends('layout.master')
@section('title','NMS — {{ $region }}')
@section('content')
@include('nms.partials.styles')
<div class="nms">
@include('nms.partials.nav')

{{-- Breadcrumb + Back button --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <div style="display:flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:var(--muted);">
        <a href="{{ route('nms.pages.regions') }}" style="color:var(--blue);text-decoration:none;">Regions</a>
        <i class="ri-arrow-right-s-line"></i>
        <span style="color:var(--text);">{{ $region }}</span>
    </div>
    <a href="{{ route('nms.pages.regions') }}" style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;background:#f1f5f9;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12px;font-weight:700;color:#475569;text-decoration:none;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
        <i class="ri-arrow-left-line"></i> Back
    </a>
</div>

{{-- Hero card — no status badge, sequence: warehouses, total, online, offline --}}
<div style="background:var(--navy);border-radius:12px;padding:20px 24px;margin-bottom:18px;color:#fff;box-shadow:0 4px 16px rgba(0,0,0,.1);">
    <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:3px;">Region</div>
    <div style="font-size:20px;font-weight:800;margin-bottom:14px;">{{ $region }}</div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:rgba(255,255,255,.1);border-radius:8px;overflow:hidden;">
        <div style="background:rgba(255,255,255,.05);padding:12px 16px;text-align:center;">
            <div style="font-family:'IBM Plex Mono',monospace;font-size:1.4rem;font-weight:800;" id="hWh">—</div>
            <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-top:3px;">Warehouses</div>
        </div>
        <div style="background:rgba(255,255,255,.05);padding:12px 16px;text-align:center;">
            <div style="font-family:'IBM Plex Mono',monospace;font-size:1.4rem;font-weight:800;" id="hTotal">—</div>
            <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-top:3px;">Total Devices</div>
        </div>
        <div style="background:rgba(255,255,255,.05);padding:12px 16px;text-align:center;">
            <div style="font-family:'IBM Plex Mono',monospace;font-size:1.4rem;font-weight:800;color:#34d399;" id="hOn">—</div>
            <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-top:3px;">Online</div>
        </div>
        <div style="background:rgba(255,255,255,.05);padding:12px 16px;text-align:center;">
            <div style="font-family:'IBM Plex Mono',monospace;font-size:1.4rem;font-weight:800;color:#f87171;" id="hOff">—</div>
            <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-top:3px;">Offline</div>
        </div>
    </div>
</div>

<div class="nms-filters">
    <div class="nms-filter-item">
        <label class="nms-filter-lbl">Status</label>
        <select class="nms-filter-sel" id="fSt" onchange="applyF()">
            <option value="">All</option>
            <option value="healthy">Healthy</option>
            <option value="partial">Partial</option>
            <option value="down">Down</option>
        </select>
    </div>
    <div class="nms-filter-item">
        <label class="nms-filter-lbl">Search</label>
        <input type="text" class="nms-filter-inp" id="fQ" placeholder="Warehouse name…" oninput="applyF()">
    </div>
    <div style="margin-left:auto;font-size:12px;color:var(--muted);font-weight:600;align-self:center;" id="cnt"></div>
</div>

<div class="nms-card">
    <div class="nms-card-hdr">
        <div class="nms-card-title"><i class="ri-building-2-line"></i> Warehouses in {{ $region }}</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="nms-tbl">
            <thead>
                <tr>
                    <th>Warehouse Name</th>
                    <th>Total Devices</th>
                    <th>Online</th>
                    <th>Offline</th>
                    <th style="text-align:center;">View</th>
                </tr>
            </thead>
            <tbody id="tbl">
                <tr><td colspan="5" class="nms-loader"><div class="nms-spinner"></div> Loading…</td></tr>
            </tbody>
        </table>
    </div>
</div>
</div>

<span id="whDetailBase" style="display:none;">{{ route('nms.pages.warehouse.detail', '') }}</span>

<script>
const NMS     = '{{ $nmsBase }}';
const REGION  = '{{ $region }}';
const WH_BASE = document.getElementById('whDetailBase').textContent.trim();
const g   = id => document.getElementById(id);
const fN  = n  => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const col = p  => p>=80 ? 'var(--green)' : p>=50 ? 'var(--amber)' : 'var(--red)';
let all = [];

async function load() {
    try {
        const [rR, wR] = await Promise.all([
            fetch(NMS + '/regions'),
            fetch(NMS + '/warehouses?region=' + encodeURIComponent(REGION))
        ]);
        const regs = rR.ok ? (await rR.json()).data || [] : [];
        all        = wR.ok ? (await wR.json()).data || [] : [];

        const r = regs.find(x => x.region_name.toLowerCase() === REGION.toLowerCase()) || {};

        // Hero — compute totals from warehouse list if region summary missing
        const sumW = (key) => all.reduce((s,w)=>s+(w[key]||0),0);
        const totalDev   = sumW('nvr_total')  + sumW('bts_total')  + sumW('epc_total')  + sumW('ws_total');
        const onlineDev  = sumW('nvr_online') + sumW('bts_online') + sumW('epc_online') + sumW('ws_online');
        const offlineDev = totalDev - onlineDev;

        g('hWh').textContent    = fN(all.length);
        g('hTotal').textContent = fN(totalDev);
        g('hOn').textContent    = fN(onlineDev);
        g('hOff').textContent   = fN(offlineDev);

        const nav = document.getElementById('nmsNavTime');
        if (nav) nav.textContent = 'Updated ' + new Date().toLocaleTimeString('en-IN', {hour:'2-digit', minute:'2-digit'});
        applyF();
    } catch(e) {
        g('tbl').innerHTML = '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--red);">Failed to load</td></tr>';
    }
}

function applyF() {
    const st   = g('fSt').value;
    const q    = g('fQ').value.toLowerCase().trim();
    const list = all.filter(w => {
        const camT2=w.total_cameras||0,camOn2=w.online_cameras||0;
        const cp=camT2>0?Math.round(camOn2/camT2*100):Math.round(w.uptime_pct||0);
        const wSt=cp>=80?'healthy':cp>=40?'partial':'down';
        if (st && wSt !== st) return false;
        if (q  && !(w.warehouse_name || '').toLowerCase().includes(q)) return false;
        return true;
    });
    g('cnt').textContent = list.length + ' warehouses';
    const tbody = g('tbl');
    if (!list.length) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--muted);">No warehouses found</td></tr>';
        return;
    }
    tbody.innerHTML = list.map(w => {
        const url = WH_BASE + '/' + w.warehouse_id;
        // Use total_devices if API returns it, otherwise sum all device counts
        const tot = (w.nvr_total||0)+(w.bts_total||0)+(w.epc_total||0)+(w.ws_total||0);
        const on  = (w.nvr_online||0)+(w.bts_online||0)+(w.epc_online||0)+(w.ws_online||0);
        const off = tot - on;
        return '<tr style="cursor:pointer;" onclick="location.href=\'' + url + '\'">'
            + '<td style="font-weight:700;font-size:13px;">' + w.warehouse_name + '</td>'
            + '<td style="font-family:IBM Plex Mono,monospace;font-weight:700;">'                    + fN(tot) + '</td>'
            + '<td style="font-family:IBM Plex Mono,monospace;font-weight:700;color:var(--green);">' + fN(on)  + '</td>'
            + '<td style="font-family:IBM Plex Mono,monospace;font-weight:700;color:var(--red);">'   + fN(off) + '</td>'

            + '<td style="text-align:center;"><a href="' + url + '" class="view-btn" onclick="event.stopPropagation()"><i class="ri-eye-line"></i> View</a></td>'
            + '</tr>';
    }).join('');
}

load();
</script>
@endsection
