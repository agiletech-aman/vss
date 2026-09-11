@extends('layout.master')
@section('title', 'NMS — Live Map')
@section('content')
@include('nms.partials.styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<div class="nms">

@include('nms.partials.nav')

{{-- Map controls bar --}}
<div style="background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);padding:12px 18px;margin-bottom:16px;display:flex;align-items:center;gap:14px;flex-wrap:wrap;box-shadow:var(--sh);">
    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0">
        <div style="width:36px;height:36px;background:var(--navy);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0"><i class="ri-global-line"></i></div>
        <div>
            <div style="font-size:13px;font-weight:800;color:var(--text);letter-spacing:-.2px;line-height:1.2">Health Monitoring System</div>
            <div style="font-size:10px;color:var(--muted);font-weight:500;margin-top:2px">Live warehouse status based on average camera uptime</div>
        </div>
    </div>
    <div style="width:1.5px;height:34px;background:var(--border);margin:0 2px;flex-shrink:0"></div>
    <div style="display:flex;gap:14px;align-items:center;flex-wrap:wrap;">
        <span style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);">Camera Uptime</span>
        <span style="display:flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--text-2);"><span style="width:11px;height:11px;border-radius:50%;background:#10b981;border:2.5px solid #fff;box-shadow:0 0 0 1.5px rgba(0,0,0,.12);display:inline-block;"></span>Healthy <span style="color:var(--muted);font-weight:500">≥80%</span></span>
        <span style="display:flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--text-2);"><span style="width:11px;height:11px;border-radius:50%;background:#f59e0b;border:2.5px solid #fff;box-shadow:0 0 0 1.5px rgba(0,0,0,.12);display:inline-block;"></span>Partial <span style="color:var(--muted);font-weight:500">40–79%</span></span>
        <span style="display:flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--text-2);"><span style="width:11px;height:11px;border-radius:50%;background:#ef4444;border:2.5px solid #fff;box-shadow:0 0 0 1.5px rgba(0,0,0,.12);display:inline-block;"></span>Down <span style="color:var(--muted);font-weight:500">&lt;40%</span></span>
    </div>
    <div style="width:1.5px;height:24px;background:var(--border);margin:0 4px;"></div>
    <select class="nms-filter-sel" id="mapFilter" style="min-width:130px;height:34px;" onchange="filterPins()">
        <option value="">All</option>
        <option value="healthy">Healthy only</option>
        <option value="partial">Partial only</option>
        <option value="down">Down only</option>
    </select>
    <input type="text" class="nms-filter-inp" id="mapSearch" placeholder="Search warehouse…" style="min-width:180px;height:34px;" oninput="filterPins()">
    <div style="margin-left:auto;display:flex;gap:8px;align-items:center;">
        <span id="mapCount" style="font-size:12px;color:var(--muted);font-weight:600;"></span>
        <button class="nms-btn nms-btn-ghost" onclick="resetView()" style="height:34px;"><i class="ri-fullscreen-line"></i> Reset</button>
    </div>
</div>

{{-- Map --}}
<div class="nms-card" style="margin-bottom:0;">
    <div id="nmsMap" style="height:calc(100vh - 280px);min-height:500px;width:100%;background:#f8fafc;"></div>
</div>

</div>

<style>
.leaflet-control-zoom { border:1.5px solid var(--border)!important; border-radius:10px!important; overflow:hidden; box-shadow:var(--sh)!important; }
.leaflet-control-zoom a { width:30px!important; height:30px!important; line-height:30px!important; font-size:14px!important; color:var(--text)!important; background:#fff!important; border-bottom:1px solid var(--border)!important; }
.leaflet-control-attribution { display:none!important; }
.leaflet-container { background:#f8fafc!important; }
.tip-state  { background:rgba(15,23,42,.82)!important; color:#fff!important; border:none!important; border-radius:6px!important; padding:4px 10px!important; font-size:11px!important; font-weight:600!important; pointer-events:none!important; font-family:'DM Sans',sans-serif!important; }
.tip-state::before { display:none!important; }
.tip-wh { background:#fff!important; border:1.5px solid var(--border)!important; border-radius:12px!important; padding:12px 16px!important; box-shadow:0 8px 24px rgba(0,0,0,.12)!important; min-width:200px!important; font-family:'DM Sans',sans-serif!important; z-index:9999!important; }
.tip-wh::before { display:none!important; }
.leaflet-tooltip-pane { z-index:9999!important; }
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const NMS = '{{ $nmsBase }}';
const fN  = n => new Intl.NumberFormat('en-IN').format(Math.round(n||0));
const colorMap = { healthy:'#10b981', partial:'#f59e0b', down:'#ef4444' };
const labelMap = { healthy:'Healthy', partial:'Partial', down:'Down' };
let map, allPins = [], markers = [];

/* status based on camera online % — 80%+ healthy, 40-79% partial, <40% down */
function camStatus(pin) {
    const tot = pin.cam_total ?? 0, on = pin.cam_online ?? 0;
    if (tot <= 0) return pin.status || 'down';
    const p = (on / tot) * 100;
    if (p >= 80) return 'healthy';
    if (p >= 40) return 'partial';
    return 'down';
}

// ─── Marker radius by zoom ────────────────────────────────────────────────────
// Tune freely — raise/lower any value below.
// Zoom 5  (full India)  → 5   visible at country view, still compact w/ 200 pins
// Zoom 7  (region)      → 7   medium
// Zoom 10+ (WH level)   → 10  full size, easy to click
function getRadius() {
    const z = map.getZoom();
    if (z >= 10) return 10;
    if (z >= 7)  return 7;
    return 5;
}
// ──────────────────────────────────────────────────────────────────────────────

async function initMap() {
    map = L.map('nmsMap', { zoomControl:true, scrollWheelZoom:true, attributionControl:false }).setView([23.5, 82], 5);

    const [geo, nmsResp] = await Promise.all([
        fetch('/geojson/india_states.geojson').then(r=>r.ok?r.json():null).catch(()=>null),
        fetch(NMS+'/map').then(r=>r.ok?r.json():null).catch(()=>null),
    ]);

    if (geo) {
        const layer = L.geoJSON(geo, {
            style: ()=>({ color:'#d1d5db', weight:1, fillColor:'#f8fafc', fillOpacity:1 }),
            onEachFeature:(f,l)=>{
                const n = f.properties.NAME_1||f.properties.name||f.properties.ST_NM||f.properties.State_Name||'';
                if (n) l.bindTooltip(n, { sticky:true, className:'tip-state', direction:'center' });
                l.on('mouseover', function(){ this.setStyle({fillColor:'#f1f5f9'}); });
                l.on('mouseout',  function(){ layer.resetStyle(this); });
            }
        }).addTo(map);
        map.fitBounds(layer.getBounds(), { padding:[20,20] });
    }

    // Filter out no_devices warehouses — only show healthy, partial, down
    allPins = (nmsResp?.data || []).filter(p => p.lat && p.lng && p.status !== 'no_devices');
    renderPins(allPins);
    document.getElementById('mapCount').textContent = allPins.length + ' warehouses';

    // Re-render on zoom so marker sizes update live
    map.on('zoomend', () => filterPins());
}

function buildTooltip(pin) {
    const st    = camStatus(pin);
    const color = colorMap[st]||'#ef4444';
    const label = labelMap[st]||'Unknown';

    const hasCams   = (pin.cam_total ?? 0) > 0;
    const camOnline = pin.cam_online ?? 0;
    const camTotal  = pin.cam_total  ?? 0;
    const camPct    = camTotal > 0 ? Math.round(camOnline / camTotal * 100) : null;
    const camColor  = camOnline === camTotal ? '#10b981' : camOnline === 0 ? '#ef4444' : '#f59e0b';
    const camRow = hasCams ? `
        <div style="background:#f8fafc;border-radius:6px;padding:5px 8px;">
            <div style="color:#94a3b8;font-weight:700;text-transform:uppercase;font-size:8.5px;letter-spacing:.07em;margin-bottom:2px;">Cameras</div>
            <div style="font-weight:800;color:${camColor};font-family:'IBM Plex Mono',monospace;">${camOnline}<span style="color:#94a3b8;font-weight:500;">/${camTotal}</span>${camPct!==null?` <span style="color:${camColor}">(${camPct}%)</span>`:''}</div>
        </div>` : '';

    const btsRow = (pin.bts_clients > 0) ? `
        <div style="background:#f8fafc;border-radius:6px;padding:5px 8px;grid-column:1/-1;">
            <div style="color:#94a3b8;font-weight:700;text-transform:uppercase;font-size:8.5px;letter-spacing:.07em;margin-bottom:2px;">BTS Clients</div>
            <div style="font-weight:800;color:#0f172a;font-family:'IBM Plex Mono',monospace;">${fN(pin.bts_clients)}</div>
        </div>` : '';

    return `
        <div style="font-family:'DM Sans',sans-serif;min-width:200px;">
            <div style="font-weight:800;font-size:13px;color:#0f172a;margin-bottom:2px;">${pin.warehouse_name}</div>
            <div style="font-size:11px;color:#64748b;margin-bottom:7px;">${pin.region_name}</div>
            <div style="font-weight:700;font-size:11.5px;color:${color};margin-bottom:8px;">● ${label}</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:10.5px;">
                <div style="background:#f8fafc;border-radius:6px;padding:5px 8px;">
                    <div style="color:#94a3b8;font-weight:700;text-transform:uppercase;font-size:8.5px;letter-spacing:.07em;margin-bottom:2px;">NVR</div>
                    <div style="font-weight:800;color:#0f172a;font-family:'IBM Plex Mono',monospace;">${pin.nvr_online ?? 0}<span style="color:#94a3b8;font-weight:500;">/${pin.nvr_total ?? 0}</span></div>
                </div>
                ${camRow}
                ${btsRow}
            </div>
            <div style="margin-top:8px;font-size:10px;color:#94a3b8;text-align:center;">Click to open detail</div>
        </div>`;
}

function renderPins(pins) {
    markers.forEach(m => map.removeLayer(m));
    markers = [];
    pins.forEach(pin => {
        const color = colorMap[camStatus(pin)] || '#ef4444';
        const m = L.circleMarker([pin.lat, pin.lng], {
            radius:      getRadius(),   // ← zoom-aware, small preset
            fillColor:   color,
            color:       '#fff',
            weight:      1.5,           // visible white ring without overpowering small dots
            opacity:     1,
            fillOpacity: .9
        }).addTo(map);

        m.bindTooltip(buildTooltip(pin), { className:'tip-wh', direction:'top', offset:[0,-12], permanent:false });
        m.on('click',     () => { window.location.href = '{{ route('nms.pages.warehouse.detail', '') }}/'+pin.warehouse_id; });
        m.on('mouseover', () => m.openTooltip());
        markers.push(m);
    });
    document.getElementById('mapCount').textContent = pins.length + ' shown';
}

function filterPins() {
    const status = document.getElementById('mapFilter').value;
    const search = document.getElementById('mapSearch').value.toLowerCase().trim();
    const filtered = allPins.filter(p => {
        if (status && camStatus(p) !== status) return false;
        if (search && !(p.warehouse_name||'').toLowerCase().includes(search) && !(p.region_name||'').toLowerCase().includes(search)) return false;
        return true;
    });
    renderPins(filtered);
    if (filtered.length === 1 && filtered[0].lat && filtered[0].lng) {
        map.setView([filtered[0].lat, filtered[0].lng], 10);
    }
}

function resetView() {
    document.getElementById('mapFilter').value = '';
    document.getElementById('mapSearch').value = '';
    renderPins(allPins);
    map.setView([23.5, 82], 5);
}

initMap();
setInterval(async () => {
    const r = await fetch(NMS+'/map').then(r => r.ok ? r.json() : null).catch(() => null);
    if (r?.data) {
        allPins = r.data.filter(p => p.lat && p.lng && p.status !== 'no_devices');
        filterPins();
    }
}, 2 * 60 * 1000);
</script>
@endsection
