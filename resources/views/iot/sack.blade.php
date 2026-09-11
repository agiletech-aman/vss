@extends('layout.master')
@section('title', 'Bag Counting')
@section('content')

<style>
.page-content { background: #f0f2f7 !important; }
.page-header { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:24px; flex-wrap:wrap; }
.page-header-left { display:flex; align-items:center; gap:14px; }
.page-back-btn { display:inline-flex; align-items:center; gap:8px; background:#fff; color:#1e293b; font-size:13px; font-weight:600; padding:10px 16px; border-radius:10px; border:1px solid #e2e8f0; text-decoration:none; transition:all .2s; box-shadow:0 2px 8px rgba(0,0,0,.04); }
.page-back-btn:hover { background:#f8fafc; text-decoration:none; transform:translateY(-1px); }
.page-header-icon { width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg,#065f46,#10b981); display:flex; align-items:center; justify-content:center; font-size:22px; color:#fff; box-shadow:0 6px 16px rgba(6,95,70,.30); }
.page-header-text h4 { font-size:20px; font-weight:800; color:#1e293b; margin:0; }
.page-header-text span { font-size:12px; color:#94a3b8; font-weight:500; }
.filter-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:20px 24px; margin-bottom:20px; }
.filter-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; margin-bottom:6px; display:block; }
.filter-card .form-select, .filter-card .form-control { border:1px solid #e2e8f0; border-radius:10px; font-size:13px; color:#1e293b; height:40px; background-color:#f8fafc; transition:border-color .2s,box-shadow .2s; }
.filter-card .form-select:focus, .filter-card .form-control:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.12); background:#fff; }
.filter-card .btn-primary { background:linear-gradient(135deg,#065f46,#10b981); border:none; border-radius:10px; font-size:13px; font-weight:600; height:40px; box-shadow:0 4px 12px rgba(16,185,129,.30); }
.filter-card .btn-reset { border:1px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; height:40px; color:#64748b; background:#f8fafc; display:flex; align-items:center; justify-content:center; text-decoration:none; }
.btn-export { display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg,#065f46,#10b981); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:600; height:36px; padding:0 14px; cursor:pointer; box-shadow:0 4px 12px rgba(16,185,129,.25); transition:all .2s; }
.btn-export:hover { transform:translateY(-1px); color:#fff; }

/* Summary tiles */
.sack-tiles { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
.sack-tile { border-radius:12px; padding:14px 16px; border:1.5px solid; }
.st-in  { background:#f0fdf4; border-color:#bbf7d0; }
.st-out { background:#fffbeb; border-color:#fde68a; }
.st-net { background:#eff6ff; border-color:#bfdbfe; }
.st-reg { background:#f5f3ff; border-color:#ddd6fe; }
.sack-tile-lbl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; margin-bottom:5px; }
.st-in  .sack-tile-lbl { color:#065f46; }
.st-out .sack-tile-lbl { color:#92400e; }
.st-net .sack-tile-lbl { color:#1d4ed8; }
.st-reg .sack-tile-lbl { color:#6d28d9; }
.sack-tile-val { font-family:'IBM Plex Mono',monospace; font-size:22px; font-weight:800; line-height:1; }
.st-in  .sack-tile-val { color:#065f46; }
.st-out .sack-tile-val { color:#92400e; }
.st-net .sack-tile-val { color:#1d4ed8; }
.st-reg .sack-tile-val { color:#6d28d9; }

/* Drill table */
.table-card { background:#fff; border-radius:16px; border:1px solid #e4e8ee; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; animation:cardIn .4s ease both; }
.table-card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.table-card-title { font-size:14px; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:8px; }
.table-card-title i { color:#10b981; font-size:16px; }
.record-count-badge { font-size:11px; font-weight:600; color:#64748b; background:#f1f5f9; padding:4px 10px; border-radius:20px; }
.drill-tbl { width:100%; border-collapse:collapse; }
.drill-tbl thead th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0; padding:12px 16px; white-space:nowrap; text-align:left; }
.drill-tbl tbody td { font-size:13px; color:#334155; padding:11px 16px; border-bottom:1px solid #f1f5f9; }
.drill-tbl tbody tr:last-child td { border-bottom:none; }
.drill-tbl tbody tr.clickable:hover td { background:#f0fdf4; cursor:pointer; }
.td-in  { font-weight:800; color:#065f46 !important; }
.td-out { font-weight:800; color:#92400e !important; }
.td-net-p { font-weight:800; color:#1d4ed8 !important; }
.td-net-n { font-weight:800; color:#dc2626 !important; }
.bar-wrap { display:flex; align-items:center; gap:8px; }
.bar-track { flex:1; height:6px; background:#f1f5f9; border-radius:3px; overflow:hidden; min-width:60px; }
.bar-fill  { height:100%; border-radius:3px; }

/* Breadcrumb nav */
.drill-nav { display:flex; align-items:center; gap:8px; margin-bottom:14px; }
.drill-nav-btn { display:inline-flex; align-items:center; gap:4px; padding:5px 12px; border:1.5px solid #e2e8f0; border-radius:8px; background:#fff; font-size:11px; font-weight:700; color:#64748b; cursor:pointer; transition:all .15s; }
.drill-nav-btn:hover { border-color:#10b981; color:#065f46; background:#f0fdf4; }
.drill-breadcrumb { font-size:11px; color:#94a3b8; font-weight:600; display:flex; align-items:center; gap:4px; }

/* Detail table (after warehouse selected) */
#detailTable thead th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0; padding:12px; }
#detailTable tbody td { font-size:13px; padding:11px 12px; border-color:#f1f5f9; }

@keyframes cardIn { from{opacity:0;transform:translateY(12px);}to{opacity:1;transform:translateY(0);} }
@media(max-width:768px) { .sack-tiles{grid-template-columns:1fr 1fr;} .page-header{flex-direction:column;align-items:flex-start;} }
</style>

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-icon"><i class="ri-archive-line"></i></div>
        <div class="page-header-text">
            <h4>Bag Counting</h4>
            <span>Monitor bag IN / OUT across regions and warehouses</span>
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="page-back-btn">
        <i class="ri-arrow-left-line"></i> Back to Dashboard
    </a>
</div>

{{-- Filter Card --}}
<div class="filter-card">
    <form method="GET" id="sackFilterForm" class="row g-2 align-items-end">
        <input type="hidden" name="region_id"    id="region_id_hidden"    value="{{ request('region_id') }}">
        <input type="hidden" name="warehouse_id" id="warehouse_id_hidden" value="{{ request('warehouse_id') }}">
        <div class="col-md-3">
            <label class="filter-label">Region</label>
            <select id="regionSelect" class="form-select">
                <option value="">All Regions</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="filter-label">Warehouse</label>
            <select id="warehouseSelect" class="form-select" disabled>
                <option value="">All Warehouses</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="filter-label">From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-2">
            <label class="filter-label">To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100"><i class="ri-search-line"></i></button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('sack.count') }}" class="btn-reset w-100"><i class="ri-refresh-line"></i></a>
        </div>
    </form>
</div>



{{-- Drill Table — hidden when detail records are loaded --}}
<div class="table-card" id="drillCard" {{ count($records) > 0 ? 'style=display:none' : '' }}>
    <div class="table-card-header">
        <div>
            <div class="table-card-title"><i class="ri-table-line"></i> <span id="drillTitle">Region Summary</span></div>
            <div class="drill-nav mt-1" id="drillNav" style="display:none">
                <button class="drill-nav-btn" id="drillBackBtn" onclick="goBack()"><i class="ri-arrow-left-s-line"></i> All Regions</button>
                <div class="drill-breadcrumb"><i class="ri-map-pin-2-line" style="color:#10b981"></i> <span id="drillBreadcrumb"></span></div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px">
            <span class="record-count-badge" id="drillCount">Loading…</span>
            <button class="btn-export" id="drillExportBtn" onclick="exportDrill()" style="display:none"><i class="ri-file-excel-line"></i> Export</button>
        </div>
    </div>
    <div style="overflow-x:auto">
        <table class="drill-tbl" id="drillTable">
            <thead id="drillThead"></thead>
            <tbody id="drillTbody"></tbody>
        </table>
    </div>
</div>

{{-- Detail table (shown after warehouse selected, uses existing sack records) --}}
@if(count($records) > 0)
<div class="table-card mt-3" id="detailCard">
    <div class="table-card-header">
        <div>
            <div class="table-card-title"><i class="ri-list-check-2"></i> Detailed Records</div>
            <div style="margin-top:5px">
                <button onclick="showDrillTable()" class="drill-nav-btn"><i class="ri-arrow-left-s-line"></i> Back to Summary</button>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px">
            <span class="record-count-badge">{{ count($records) }} record(s)</span>
            <button onclick="exportSackExcel()" class="btn-export"><i class="ri-file-excel-line"></i> Export Excel</button>
        </div>
    </div>
    <div class="table-card-body" style="padding:0 24px 24px">
        <div class="table-responsive">
            <table id="sackTable" class="table align-middle w-100">
                <thead>
                    <tr>
                        <th>Date</th><th>Region</th><th>Warehouse</th>
                        <th>Godown</th><th>Compartment</th>
                        <th>Day Total IN</th><th>Day Total OUT</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($records as $row)
                    <tr>
                        <td>{{ $row['date']        ?? '-' }}</td>
                        <td>{{ $row['region']      ?? '-' }}</td>
                        <td>{{ $row['warehouse']   ?? '-' }}</td>
                        <td>{{ $row['godown']      ?? '-' }}</td>
                        <td>{{ $row['compartment'] ?? '-' }}</td>
                        <td class="td-in">{{ number_format($row['Day_Total_In']  ?? 0) }}</td>
                        <td class="td-out">{{ number_format($row['Day_Total_Out'] ?? 0) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
const SACK_URL    = '/api/sack/region-summary';
const SACK_ROUTE  = '{{ route("sack.count") }}';
const fN = n => new Intl.NumberFormat('en-IN').format(Math.round(n||0));

let allRegions = [], currentMode = 'region', currentRegion = null, drillData = [];

/* ── Init dropdowns ── */
document.addEventListener('DOMContentLoaded', () => {
    const regionSel    = document.getElementById('regionSelect');
    const warehouseSel = document.getElementById('warehouseSelect');
    const ridHidden    = document.getElementById('region_id_hidden');
    const widHidden    = document.getElementById('warehouse_id_hidden');
    const selRid       = "{{ request('region_id') }}";
    const selWid       = "{{ request('warehouse_id') }}";

    Promise.all([
        fetch('/iot/sack/regions').then(r=>r.json()),
        fetch('/iot/sack/warehouses').then(r=>r.json())
    ]).then(([regions, warehouses]) => {
        allRegions = regions;
        regionSel.innerHTML = '<option value="">All Regions</option>';
        regions.forEach(r => {
            const id = r.id||r.region_id, name = r.region_name||r.name;
            regionSel.innerHTML += `<option value="${id}" ${id==selRid?'selected':''}>${name}</option>`;
        });
        if (selRid) {
            const filtered = warehouses.filter(w=>w.region_id==selRid);
            warehouseSel.innerHTML = '<option value="">All Warehouses</option>';
            filtered.forEach(w=>{
                const id=w.id||w.warehouse_id, name=w.warehouse_name||w.name;
                warehouseSel.innerHTML += `<option value="${id}" ${id==selWid?'selected':''}>${name}</option>`;
            });
            warehouseSel.disabled = filtered.length===0;
        }
        regionSel.addEventListener('change', function(){
            ridHidden.value = this.value;
            widHidden.value = '';
            warehouseSel.innerHTML = '<option value="">All Warehouses</option>';
            const filtered = warehouses.filter(w=>w.region_id==this.value);
            filtered.forEach(w=>{
                const id=w.id||w.warehouse_id, name=w.warehouse_name||w.name;
                warehouseSel.innerHTML += `<option value="${id}">${name}</option>`;
            });
            warehouseSel.disabled = filtered.length===0;
        });
        warehouseSel.addEventListener('change', function(){ widHidden.value = this.value; });
        document.getElementById('sackFilterForm').addEventListener('submit', ()=>{
            ridHidden.value = regionSel.value;
            widHidden.value = warehouseSel.value;
        });
    });

    /* Load region-level drill table only if no detail records */
    @if(count($records) === 0)
    loadRegionDrill();
    @endif

    /* Init detail datatable if records present */
    if (document.getElementById('sackTable')) {
        $('#sackTable').DataTable({
            paging:true, pageLength:10, info:true, searching:true,
            ordering:true, order:[[0,'desc']], scrollX:true, autoWidth:false,
            language:{search:'',searchPlaceholder:'Search…',emptyTable:'No records.',zeroRecords:'No match.'}
        });
    }
});

/* ── Load region summary from API ── */
async function loadRegionDrill() {
    document.getElementById('drillCount').textContent = 'Loading…';
    try {
        const res  = await fetch(SACK_URL, {headers:{'Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''}});
        const json = await res.json();
        if (!json.success) throw new Error(json.error||'API error');
        allRegions = json.data || [];
        renderRegionTable(allRegions);
    } catch(e) {
        document.getElementById('drillTbody').innerHTML = `<tr><td colspan="5" style="padding:20px;text-align:center;color:#ef4444">${e.message}</td></tr>`;
        document.getElementById('drillCount').textContent = 'Error';
    }
}

function renderRegionTable(regions) {
    currentMode = 'region'; currentRegion = null;
    document.getElementById('drillTitle').textContent  = 'Region Summary';
    document.getElementById('drillNav').style.display  = 'none';
    document.getElementById('drillExportBtn').style.display = 'inline-flex';

    const totalIn  = regions.reduce((s,r)=>s+(r.total_in_bags||0),0);
    const totalOut = regions.reduce((s,r)=>s+(r.total_out_bags||0),0);
    const net      = totalIn - totalOut;

    document.getElementById('drillCount').textContent = regions.length+' regions';

    document.getElementById('drillThead').innerHTML = `<tr>
        <th>Region</th>
        <th>Total IN</th>
        <th>Total OUT</th>
        <th>Net</th>
        <th>Last Action</th>
    </tr>`;

    drillData = regions;
    document.getElementById('drillTbody').innerHTML = regions.map((r,i)=>{
        const net = (r.total_in_bags||0)-(r.total_out_bags||0);
        const la   = r.last_action_at ? new Date(r.last_action_at).toLocaleDateString('en-IN') : '—';
        return `<tr class="clickable" onclick="drillRegion(${i})">
            <td style="font-weight:700">${r.region||r.region_name||'—'} <i class="ri-arrow-right-s-line" style="color:#10b981;font-size:13px"></i></td>
<td class="td-in">${fN(r.total_in_bags||0)}</td>
            <td class="td-out">${fN(r.total_out_bags||0)}</td>
            <td class="${net>=0?'td-net-p':'td-net-n'}">${net>=0?'+':''}${fN(net)}</td>
            <td style="font-size:12px;color:#94a3b8">${la}</td>
        </tr>`;
    }).join('');
}

function drillRegion(idx) {
    const reg = allRegions[idx];
    if (!reg) return;
    currentMode = 'warehouse'; currentRegion = reg;
    const regionName = reg.region || reg.region_name || '—';
    const whs = (reg.warehouses||[]).filter(w=>(w.total_in_bags||0)+(w.total_out_bags||0)>0)
        .sort((a,b)=>(b.total_in_bags||0)-(a.total_in_bags||0));

    document.getElementById('drillTitle').textContent      = regionName+' — Warehouses';
    document.getElementById('drillNav').style.display      = 'flex';
    document.getElementById('drillBreadcrumb').textContent = regionName;
    document.getElementById('drillCount').textContent      = whs.length+' warehouses';

    const totalIn  = whs.reduce((s,w)=>s+(w.total_in_bags||0),0);
    const totalOut = whs.reduce((s,w)=>s+(w.total_out_bags||0),0);
    const net      = totalIn-totalOut;


    document.getElementById('drillThead').innerHTML = `<tr>
        <th>Warehouse</th><th>Total IN</th><th>Total OUT</th><th>Net</th><th>Last Action</th>
    </tr>`;

    drillData = whs;
    document.getElementById('drillTbody').innerHTML = whs.length ? whs.map((w,i)=>{
        const net = (w.total_in_bags||0)-(w.total_out_bags||0);
        const la   = w.last_action_at ? new Date(w.last_action_at).toLocaleDateString('en-IN') : '—';
        return `<tr class="clickable" onclick="gotoWarehouse(${i})">
            <td style="font-weight:700">${w.warehouse_name||'—'} <i class="ri-arrow-right-s-line" style="color:#10b981;font-size:13px"></i></td>
<td class="td-in">${fN(w.total_in_bags||0)}</td>
            <td class="td-out">${fN(w.total_out_bags||0)}</td>
            <td class="${net>=0?'td-net-p':'td-net-n'}">${net>=0?'+':''}${fN(net)}</td>
            <td style="font-size:12px;color:#94a3b8">${la}</td>
        </tr>`;
    }).join('') : `<tr><td colspan="5" style="padding:20px;text-align:center;color:#94a3b8">No warehouse data</td></tr>`;
}

function gotoWarehouse(idx) {
    const w   = drillData[idx];
    const reg = currentRegion;
    if (!w || !w.warehouse_id) return;
    window.location.href = SACK_ROUTE
        + '?region_id='    + encodeURIComponent(reg.region_id||'')
        + '&warehouse_id=' + encodeURIComponent(w.warehouse_id)
        + '&region_name='  + encodeURIComponent(reg.region||'')
        + '&warehouse_name='+ encodeURIComponent(w.warehouse_name||'');
}

function showDrillTable() {
    document.getElementById('drillCard').style.display = '';
    document.getElementById('detailCard')?.style.setProperty('display','none');
    /* Navigate back to clean URL to reset filter state */
    window.location.href = SACK_ROUTE;
}

function goBack() {
    renderRegionTable(allRegions);
}

/* ── Export ── */
function exportDrill() {
    const mode = currentMode;
    const rows = [mode==='region'
        ? ['Region','Total IN','Total OUT','Net','Last Action']
        : ['Warehouse','Total IN','Total OUT','Net','Last Action']];

    drillData.forEach(r=>{
        const net = (r.total_in_bags||0)-(r.total_out_bags||0);
        const la  = r.last_action_at ? new Date(r.last_action_at).toLocaleDateString('en-IN') : '—';
        rows.push([r.region||r.warehouse_name||'—', r.total_in_bags||0, r.total_out_bags||0, net, la]);
    });

    let html = '<html><head><meta charset="UTF-8"><style>th{background:#f2f2f2;padding:6px 10px;border:1px solid #999;font-size:12px}td{padding:5px 10px;border:1px solid #ccc;font-size:12px}</style></head><body><table>';
    rows.forEach((r,i)=>{ html += '<tr>'+r.map(c=>`<${i===0?'th':'td'}>${c}</${i===0?'th':'td'}>`).join('')+'</tr>'; });
    html += '</table></body></html>';
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([html],{type:'application/vnd.ms-excel'}));
    a.download = 'Sack_'+(currentMode==='region'?'Regions':'Warehouses')+'_'+new Date().toISOString().slice(0,10)+'.xls';
    a.click();
}

function exportSackExcel() {
    const rows = [['#','Date','Region','Warehouse','Godown','Compartment','Day Total IN','Day Total OUT']];
    document.querySelectorAll('#sackTable tbody tr').forEach((tr,i)=>{
        const c = tr.querySelectorAll('td');
        if(c.length<7) return;
        rows.push([i+1,...[...c].map(x=>x.textContent.trim())]);
    });
    if(rows.length<2){alert('No data.');return;}
    let html = '<html><head><meta charset="UTF-8"><style>th{background:#f2f2f2;padding:6px 10px;border:1px solid #999;font-size:12px}td{padding:5px 10px;border:1px solid #ccc;font-size:12px}</style></head><body><table>';
    rows.forEach((r,i)=>{ html += '<tr>'+r.map(c=>`<${i===0?'th':'td'}>${c}</${i===0?'th':'td'}>`).join('')+'</tr>'; });
    html += '</table></body></html>';
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([html],{type:'application/vnd.ms-excel'}));
    a.download = 'Sack_Detail_'+new Date().toISOString().slice(0,10)+'.xls';
    a.click();
}
</script>
@endpush
