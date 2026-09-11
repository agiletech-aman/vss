@extends('layout.master')
@section('title', 'NMS — Dashboard')
@section('content')
@include('nms.partials.styles')

<style>
/* ── NMS KPI Strip (5×2) ── */
.nms-strip{background:#fff;border:1.5px solid #e2e8f0;border-radius:14px;box-shadow:0 4px 12px rgba(0,0,0,.07);margin-bottom:18px;overflow:hidden}
.nms-strip-cells{display:grid;grid-template-columns:repeat(7,1fr)}
.nms-cell{padding:14px 18px;border-right:1.5px solid #e2e8f0;position:relative}
.nms-cell:last-child{border-right:none}
.nms-cell-lbl{font-size:8px;font-weight:800;text-transform:uppercase;letter-spacing:.12em;color:#94a3b8;margin-bottom:5px;display:flex;align-items:center;gap:4px}
.nms-cell-lbl i{font-size:10px}
.nms-cell-val{font-family:'IBM Plex Mono',monospace;font-size:26px;font-weight:800;line-height:1;color:#0f172a}
.nms-cell-sub{font-size:10px;color:#94a3b8;margin-top:4px;font-weight:600;min-height:14px}
/* shimmer */
@keyframes nmsShimmer{0%{background-position:-400px 0}100%{background-position:400px 0}}
.nskel{display:inline-block;border-radius:4px;background:linear-gradient(90deg,#f1f5f9 25%,#e2e8f0 50%,#f1f5f9 75%);background-size:400px 100%;animation:nmsShimmer 1.4s infinite;color:transparent!important}
.nskel-num{height:26px;width:52px}
.nskel-sub{height:10px;width:80px;margin-top:4px}
@media(max-width:1100px){.nms-strip-cells{grid-template-columns:repeat(4,1fr)}.nms-cell:nth-child(4n){border-right:none}.nms-cell{border-bottom:1.5px solid #e2e8f0}}
@media(max-width:700px){.nms-strip-cells{grid-template-columns:repeat(3,1fr)}}
@media(max-width:480px){.nms-strip-cells{grid-template-columns:repeat(2,1fr)}}
</style>

<div class="nms">
@include('nms.partials.nav')

{{-- KPI STRIP 5×2 --}}
<div class="nms-strip">
    <div class="nms-strip-cells">
        {{-- NMS devices only --}}
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-map-pin-2-line" style="color:red"></i> Regions</div>
            <div class="nms-cell-val nskel nskel-num" id="kRegions">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kRegionsSub"></div>
        </div>
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-building-4-line" style="color:red"></i> Warehouses</div>
            <div class="nms-cell-val nskel nskel-num" id="kWh">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kWhSub"></div>
        </div>
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-hard-drive-2-line" style="color:red"></i> NVR</div>
            <div class="nms-cell-val nskel nskel-num" id="kNvrTotal">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kNvrSub"></div>
        </div>
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-router-line" style="color:red"></i> BTS</div>
            <div class="nms-cell-val nskel nskel-num" id="kBtsTotal">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kBtsSub"></div>
        </div>
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-wifi-line" style="color:red"></i> CPE Clients</div>
            <div class="nms-cell-val nskel nskel-num" id="kBtsClients">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kBtsClientsSub"></div>
        </div>
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-computer-line" style="color:red"></i> Embedded PC</div>
            <div class="nms-cell-val nskel nskel-num" id="kEpcTotal">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kEpcSub"></div>
        </div>
        <div class="nms-cell">
            <div class="nms-cell-lbl"><i class="ri-desktop-line" style="color:red"></i> Workstation</div>
            <div class="nms-cell-val nskel nskel-num" id="kWsTotal">—</div>
            <div class="nms-cell-sub nskel nskel-sub" id="kWsSub"></div>
        </div>

    </div>
</div>

{{-- MAIN GRID: Region Health + Offline Devices --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">
    <div class="nms-card">
        <div class="nms-card-hdr">
            <div class="nms-card-title"><i class="ri-map-pin-2-line"></i> Region Health</div>
            <a href="{{ route('nms.pages.regions') }}" class="nms-btn-sm nms-btn-sm-navy">View all <i class="ri-arrow-right-line"></i></a>
        </div>
        <div id="regionList" style="max-height:400px;overflow-y:auto;">
            <div class="nms-loader"><div class="nms-spinner"></div> Loading…</div>
        </div>
    </div>
    <div class="nms-card">
        <div class="nms-card-hdr">
            <div class="nms-card-title"><i class="ri-alarm-warning-line"></i> Offline Devices</div>
            <a href="{{ route('nms.pages.regions') }}" class="nms-btn-sm nms-btn-sm-navy">Warehouses <i class="ri-arrow-right-line"></i></a>
        </div>
        <div id="alertList" style="max-height:400px;overflow-y:auto;">
            <div class="nms-loader"><div class="nms-spinner"></div> Loading…</div>
        </div>
    </div>
</div>

{{-- Device type breakdown --}}
<div class="nms-card" style="margin-bottom:18px;">
    <div class="nms-card-hdr">
        <div class="nms-card-title"><i class="ri-pie-chart-2-line"></i> Device Type Summary</div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:0;border-top:1px solid #f1f5f9;" id="typeCards">
        <div class="nms-loader" style="grid-column:1/-1;padding:2rem;"><div class="nms-spinner"></div> Loading…</div>
    </div>
</div>

{{-- Bottom grid: Top offline regions + All offline devices --}}
<div style="display:grid;grid-template-columns:1fr 2fr;gap:18px;margin-bottom:18px;">
    <div class="nms-card">
        <div class="nms-card-hdr">
            <div class="nms-card-title"><i class="ri-signal-wifi-off-line"></i> Most Offline</div>
        </div>
        <div id="worstRegions" style="max-height:360px;overflow-y:auto;">
            <div class="nms-loader"><div class="nms-spinner"></div> Loading…</div>
        </div>
    </div>
    <div class="nms-card">
        <div class="nms-card-hdr">
            <div class="nms-card-title"><i class="ri-table-2"></i> All Offline Devices</div>
            <a href="{{ route('nms.pages.regions') }}" class="nms-btn-sm nms-btn-sm-blue">Warehouses <i class="ri-arrow-right-line"></i></a>
        </div>
        <div style="overflow-x:auto;max-height:360px;overflow-y:auto;">
            <table class="nms-tbl">
                <thead>
                    <tr>
                        <th>Device</th><th>Type</th><th>Region</th>
                        <th>Warehouse</th><th>Last Polled</th><th>Severity</th>
                    </tr>
                </thead>
                <tbody id="offlineTable">
                    <tr><td colspan="6" class="nms-loader"><div class="nms-spinner"></div></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<span id="whDetailBase" style="display:none;">{{ route('nms.pages.warehouse.detail', '') }}</span>
<span id="regionDetailBase" style="display:none;">{{ route('nms.pages.region.detail', '') }}</span>

<script>
const NMS      = '{{ $nmsBase }}';
const WH_BASE  = document.getElementById('whDetailBase').textContent.trim();
const REG_BASE = document.getElementById('regionDetailBase').textContent.trim();
const fN       = n => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const el       = id => document.getElementById(id);

// ── Strip helpers ──────────────────────────────────────────
function sc(id, val) {
    const e = el(id); if (!e) return;
    e.textContent = val;
    e.classList.remove('nskel','nskel-num','nskel-sub');
}
function ss(id, html) {
    const e = el(id); if (!e) return;
    e.classList.remove('nskel','nskel-sub');
    e.innerHTML = html;
}
const num = v => `<span style="color:#1a73e8;font-weight:700">${fN(v)}</span>`;
const lbl = t => `<span style="color:#94a3b8">${t}</span>`;

async function loadDashboard() {
    try {
        const [sumR, regR, offR, typR] = await Promise.all([
            fetch(NMS+'/summary'),
            fetch(NMS+'/regions'),
            fetch(NMS+'/alerts/offline?limit=100'),
            fetch(NMS+'/stats/by-type'),

        ]);
        const sum   = sumR.ok  ? (await sumR.json()).data||{} : {};
        const regs  = regR.ok  ? (await regR.json()).data||[] : [];
        const offs  = offR.ok  ? (await offR.json()).data||[] : [];
        const types = typR.ok  ? (await typR.json()).data||[] : [];


        // ── find helper ──
        const find = (...keys) => types.find(t => keys.map(k=>k.toLowerCase()).includes((t.type||'').toLowerCase())) || {};

        const nvr = find('NVR','DVR');
        const bts = find('BTS');
        const epc = find('Embedded PC','EPC');
        const ws  = find('Workstation');

        // ── Strip ──────────────────────────────────────────
        sc('kRegions', regs.length || '—');
        ss('kRegionsSub', lbl('active regions'));

        sc('kWh', fN(sum.total_warehouses||0));
        ss('kWhSub', lbl('monitored'));

        sc('kNvrTotal', fN(nvr.total||0) || '—');
        ss('kNvrSub', num(nvr.online||0) + lbl(' on · ') + num(nvr.offline||0) + lbl(' off'));

        sc('kBtsTotal', fN(bts.total||0) || '—');
        ss('kBtsSub', num(bts.online||0) + lbl(' on · ') + num(bts.offline||0) + lbl(' off'));

        sc('kBtsClients', fN(sum.bts_clients||0) || '—');
        ss('kBtsClientsSub', lbl('connected clients'));

        sc('kEpcTotal', fN(epc.total||0) || '—');
        ss('kEpcSub', num(epc.online||0) + lbl(' on · ') + num(epc.offline||0) + lbl(' off'));

        sc('kWsTotal', fN(ws.total||0) || '—');
        ss('kWsSub', num(ws.online||0) + lbl(' on · ') + num(ws.offline||0) + lbl(' off'));



        const nav = document.getElementById('nmsNavTime');
        if (nav) nav.textContent = 'Updated '+new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit'});

        // ── Region Health ──────────────────────────────────
        const sortedRegs = [...regs].sort((a,b)=>(b.offline_devices||0)-(a.offline_devices||0));
        el('regionList').innerHTML = sortedRegs.length ? sortedRegs.map(r=>{
            const p=r.uptime_pct??0, c=p>=80?'var(--green)':p>=50?'var(--amber)':'var(--red)';
            const url = REG_BASE+'/'+encodeURIComponent(r.region_name);
            return '<a href="'+url+'" style="display:flex;align-items:center;gap:10px;padding:10px 18px;border-bottom:1px solid #f0f4f8;text-decoration:none;" onmouseover="this.style.background=\'#f8faff\'" onmouseout="this.style.background=\'\'">'
                +'<div style="font-size:12px;font-weight:700;color:var(--text);min-width:85px;flex-shrink:0;">'+r.region_name+'</div>'
                +'<div style="flex:1;height:5px;background:#f1f5f9;border-radius:999px;overflow:hidden;">'
                +'<div style="height:100%;border-radius:999px;background:'+c+';width:'+p+'%;transition:width .6s;"></div></div>'
                +'<div style="font-family:IBM Plex Mono,monospace;font-size:11px;font-weight:800;color:'+c+';min-width:32px;text-align:right;">'+p+'%</div>'
                +'<div style="font-size:10px;color:var(--muted);min-width:52px;text-align:right;">'+r.online_devices+'/'+r.total_devices+' on</div>'
                +'<div style="font-size:10px;color:var(--red);font-weight:700;min-width:24px;text-align:right;">'+r.offline_devices+' off</div>'
                +'</a>';
        }).join('') : '<div class="nms-empty"><div class="nms-empty-txt">No region data</div></div>';

        // ── Offline Alerts ─────────────────────────────────
        el('alertList').innerHTML = offs.length ? offs.slice(0,20).map(d=>{
            const hi  = d.severity==='high';
            const url = WH_BASE+'/'+(d.warehouse_id||'');
            const typeColors = {NVR:'#3b82f6',BTS:'#10b981','Embedded PC':'#f59e0b',DVR:'#3b82f6',EPC:'#f59e0b'};
            const tc = typeColors[d.type||d.device_type]||'#64748b';
            return '<a href="'+url+'" style="display:flex;align-items:center;gap:10px;padding:9px 18px;border-bottom:1px solid #f0f4f8;text-decoration:none;" onmouseover="this.style.background=\'#fff8f8\'" onmouseout="this.style.background=\'\'">'
                +'<div style="width:7px;height:7px;border-radius:50%;background:var(--red);flex-shrink:0;animation:nmsBlink 2s infinite;"></div>'
                +'<div style="background:'+tc+'22;border:1px solid '+tc+';color:'+tc+';font-size:9px;font-weight:800;padding:1px 6px;border-radius:4px;flex-shrink:0;">'+(d.type||d.device_type||'—')+'</div>'
                +'<div style="flex:1;min-width:0;">'
                +'<div style="font-size:12px;font-weight:700;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">'+(d.name||'—')+'</div>'
                +'<div style="font-size:10.5px;color:var(--muted);">'+(d.region_name||'—')+' › '+(d.warehouse_name||'—')+'</div>'
                +'</div>'
                +'<span class="sbadge sb-alert" style="font-size:9px;padding:1px 6px;">'+(hi?'HIGH':'MED')+'</span>'
                +'</a>';
        }).join('') : '<div style="text-align:center;padding:2rem;color:var(--green);font-size:13px;font-weight:700;"><i class="ri-check-circle-line" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>All Devices Online ✓</div>';

        // ── Device Type Summary ────────────────────────────
        if (types.length) {
            const colors = {NVR:'#3b82f6','Embedded PC':'#f59e0b',BTS:'#10b981',DVR:'#3b82f6',EPC:'#8b5cf6',Router:'#06b6d4',Workstation:'#8b5cf6',Camera:'#059669'};
            el('typeCards').innerHTML = types.map(t=>{
                const pct = t.uptime_pct||0;
                const c   = colors[t.type]||'#64748b';
                const col = pct>=80?'var(--green)':pct>=50?'var(--amber)':'var(--red)';
                return '<div style="padding:20px 24px;border-right:1px solid #f1f5f9;">'
                    +'<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">'
                    +'<div style="background:'+c+'22;border:1.5px solid '+c+';color:'+c+';font-size:10px;font-weight:800;padding:2px 9px;border-radius:6px;">'+t.type+'</div>'
                    +'<div style="font-size:11px;color:var(--red);font-weight:700;">'+fN(t.offline||0)+' offline</div>'
                    +'</div>'
                    +'<div style="display:flex;align-items:baseline;gap:6px;margin-bottom:6px;">'
                    +'<div style="font-family:IBM Plex Mono,monospace;font-size:1.6rem;font-weight:800;color:var(--text);">'+fN(t.online||0)+'</div>'
                    +'<div style="font-size:12px;color:var(--muted);">/ '+fN(t.total||0)+'</div>'
                    +'</div>'
                    +'<div style="height:5px;background:#f1f5f9;border-radius:3px;overflow:hidden;margin-bottom:5px;">'
                    +'<div style="height:100%;border-radius:3px;background:'+col+';width:'+pct+'%;transition:width .6s;"></div></div>'
                    +'<div style="font-size:10.5px;font-weight:700;color:'+col+';">'+pct+'% uptime</div>'
                    +'</div>';
            }).join('');
        } else { el('typeCards').innerHTML = ''; }

        // ── Worst Regions ──────────────────────────────────
        const worst = [...regs].sort((a,b)=>(b.offline_devices||0)-(a.offline_devices||0)).slice(0,8);
        el('worstRegions').innerHTML = worst.length ? worst.map(r=>{
            const p=r.uptime_pct??0, c=p>=80?'var(--green)':p>=50?'var(--amber)':'var(--red)';
            const url = REG_BASE+'/'+encodeURIComponent(r.region_name);
            return '<a href="'+url+'" style="display:flex;align-items:center;justify-content:space-between;padding:11px 18px;border-bottom:1px solid #f1f5f9;text-decoration:none;" onmouseover="this.style.background=\'#fafbff\'" onmouseout="this.style.background=\'\'">'
                +'<div><div style="font-size:12.5px;font-weight:700;color:var(--text);">'+r.region_name+'</div>'
                +'<div style="font-size:10.5px;color:var(--muted);margin-top:1px;">'+r.total_warehouses+' warehouses · '+r.total_devices+' devices</div></div>'
                +'<div style="text-align:right;">'
                +'<div style="font-family:IBM Plex Mono,monospace;font-size:13px;font-weight:800;color:var(--red);">'+r.offline_devices+' off</div>'
                +'<div style="font-size:10px;font-weight:700;color:'+c+';">'+p+'% up</div>'
                +'</div></a>';
        }).join('') : '<div style="text-align:center;padding:2rem;color:var(--green);font-weight:700;">All Regions Healthy ✓</div>';

        // ── Offline Devices Table ──────────────────────────
        const tbody = el('offlineTable');
        if (!offs.length) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--green);font-weight:700;">All devices online ✓</td></tr>';
        } else {
            tbody.innerHTML = offs.map(d=>{
                const hi  = d.severity==='high';
                const url = WH_BASE+'/'+(d.warehouse_id||'');
                const typeColors = {NVR:'#3b82f6',BTS:'#10b981','Embedded PC':'#f59e0b',DVR:'#3b82f6'};
                const tc  = typeColors[d.type||d.device_type]||'#64748b';
                return '<tr style="cursor:pointer;" onclick="location.href=\''+url+'\'">'
                    +'<td style="font-weight:700;font-size:13px;">'+(d.name||'—')+'</td>'
                    +'<td><span style="background:'+tc+'22;border:1px solid '+tc+';color:'+tc+';font-size:10px;font-weight:800;padding:2px 7px;border-radius:4px;">'+(d.type||d.device_type||'—')+'</span></td>'
                    +'<td style="font-size:12px;">'+(d.region_name||'—')+'</td>'
                    +'<td style="font-size:12px;">'+(d.warehouse_name||'—')+'</td>'
                    +'<td style="font-family:IBM Plex Mono,monospace;font-size:11px;color:var(--muted);">'+(d.last_polled_human||'—')+'</td>'
                    +'<td><span class="sbadge sb-alert" style="font-size:9px;padding:1px 7px;">'+(hi?'HIGH':'MED')+'</span></td>'
                    +'</tr>';
            }).join('');
        }

    } catch(e) { console.error('NMS dashboard error:', e); }
}

loadDashboard();
setInterval(loadDashboard, 2*60*1000);
</script>
@endsection
