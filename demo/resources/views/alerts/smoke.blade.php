@extends('layout.master')

@section('title', 'Smoke Alerts')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

<style>
:root {
    --alert-bg: #f8fafc; --alert-card: #ffffff; --alert-text: #0f172a; --alert-muted: #64748b;
    --alert-border: #e2e8f0; --alert-smoke: #6b7280; --alert-smoke-bg: #f9fafb;
    --alert-smoke-light: #e5e7eb; --alert-radius: 12px;
    --alert-shadow: 0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.06);
    --alert-shadow-lg: 0 4px 6px rgba(0,0,0,.05), 0 10px 15px rgba(0,0,0,.08);
}
* { font-family: 'DM Sans', -apple-system, sans-serif; }
body { background: var(--alert-bg); }
.alert-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:16px; }
.alert-back-btn { display:inline-flex; align-items:center; gap:8px; background:var(--alert-card); color:var(--alert-text); font-size:14px; font-weight:600; padding:10px 18px; border-radius:10px; border:1px solid var(--alert-border); text-decoration:none; transition:all .2s; box-shadow:var(--alert-shadow); }
.alert-back-btn:hover { background:#f8fafc; color:var(--alert-text); text-decoration:none; transform:translateY(-1px); }
.alert-title { display:flex; align-items:center; gap:12px; margin:0; }
.alert-icon { width:44px; height:44px; background:linear-gradient(135deg,#6b7280,#9ca3af); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; color:#fff; box-shadow:0 4px 12px rgba(107,114,128,.3); }
.alert-title h4 { font-size:24px; font-weight:800; color:var(--alert-text); margin:0; letter-spacing:-.5px; }
.alert-title .subtitle { font-size:13px; color:var(--alert-muted); font-weight:500; margin-top:2px; }
.filter-card { background:var(--alert-card); border:1px solid var(--alert-border); border-radius:var(--alert-radius); padding:24px; margin-bottom:20px; box-shadow:var(--alert-shadow); }
.filter-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--alert-muted); margin-bottom:8px; display:block; }
.filter-card .form-select, .filter-card .form-control { height:48px; border:1.5px solid var(--alert-border); border-radius:10px; font-size:14px; font-weight:500; color:var(--alert-text); background:#f8fafc; transition:all .2s; }
.filter-card .form-select:focus, .filter-card .form-control:focus { border-color:var(--alert-smoke); background:#fff; box-shadow:0 0 0 3px rgba(107,114,128,.08); outline:none; }
.filter-actions { display:flex; gap:10px; }
.btn-filter { height:48px; background:linear-gradient(135deg,#6b7280,#4b5563); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; padding:0 24px; transition:all .2s; box-shadow:0 4px 12px rgba(107,114,128,.25); cursor:pointer; }
.btn-filter:hover { background:linear-gradient(135deg,#4b5563,#374151); transform:translateY(-2px); }
.btn-reset { height:48px; background:var(--alert-card); color:var(--alert-muted); border:1.5px solid var(--alert-border); border-radius:10px; font-size:14px; font-weight:600; padding:0 20px; transition:all .2s; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
.btn-reset:hover { background:#f8fafc; border-color:#cbd5e1; color:var(--alert-text); }
.info-banner { background:var(--alert-smoke-bg); border:1px solid var(--alert-smoke-light); border-left:4px solid var(--alert-smoke); border-radius:10px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:12px; font-size:13px; color:#1f2937; font-weight:600; }
.table-card { background:var(--alert-card); border:1px solid var(--alert-border); border-radius:var(--alert-radius); overflow:hidden; box-shadow:var(--alert-shadow-lg); margin-bottom:16px; }
.table-card-header { padding:18px 24px; border-bottom:1px solid var(--alert-border); background:#f9fafb; display:flex; align-items:center; justify-content:space-between; }
.table-card-title { font-size:16px; font-weight:700; color:var(--alert-text); margin:0; display:flex; align-items:center; gap:8px; }
.table-card-title i { color:var(--alert-smoke); }
#smokeTable { width:100%; margin:0; border-collapse:collapse; }
#smokeTable thead th { background:#f9fafb; color:var(--alert-muted); font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; padding:16px 20px; border-bottom:1px solid var(--alert-border); white-space:nowrap; text-align:left; cursor:pointer; user-select:none; }
#smokeTable thead th:after { content:' ⇅'; font-size:10px; opacity:.4; }
#smokeTable thead th.sort-asc:after { content:' ↑'; opacity:1; }
#smokeTable thead th.sort-desc:after { content:' ↓'; opacity:1; }
#smokeTable thead th.no-sort { cursor:default; } #smokeTable thead th.no-sort:after { content:''; }
#smokeTable tbody td { padding:16px 20px; color:var(--alert-text); font-size:14px; font-weight:500; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
#smokeTable tbody tr:hover { background:#f9fafb; }
#smokeTable tbody tr:last-child td { border-bottom:none; }
.empty-state { text-align:center; padding:60px 20px; color:var(--alert-muted); }
.empty-state i { font-size:40px; display:block; margin-bottom:12px; opacity:.4; }
.empty-state p { margin:0; font-size:14px; font-weight:500; }
.datetime-cell { font-family:'IBM Plex Mono',monospace; font-size:13px; color:var(--alert-muted); font-weight:600; }
.camera-name { font-weight:600; color:var(--alert-text); }
.location-cell { color:var(--alert-muted); font-size:13px; }
.alert-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:var(--alert-smoke-bg); color:var(--alert-smoke); border:1px solid var(--alert-smoke-light); border-radius:8px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; }
.preview-img { width:70px; height:70px; object-fit:cover; border-radius:10px; cursor:pointer; transition:all .2s; border:2px solid var(--alert-border); }
.preview-img:hover { transform:scale(1.05); border-color:var(--alert-smoke); }
.pagination-wrapper { background:var(--alert-card); border:1px solid var(--alert-border); border-radius:var(--alert-radius); padding:16px 24px; margin-top:16px; box-shadow:var(--alert-shadow); }
.pagination { margin:0; gap:6px; display:flex; justify-content:center; align-items:center; }
.pagination .page-item { list-style:none; }
.pagination .page-link { border:1.5px solid var(--alert-border); border-radius:8px; color:var(--alert-text); font-weight:600; font-size:14px; padding:10px 16px; transition:all .2s; text-decoration:none; background:var(--alert-card); display:flex; align-items:center; gap:6px; }
.pagination .page-link:hover { background:var(--alert-smoke); color:#fff; border-color:var(--alert-smoke); transform:translateY(-1px); }
.pagination .page-item.active .page-link { background:var(--alert-smoke); border-color:var(--alert-smoke); color:#fff; }
.pagination .page-item.disabled .page-link { opacity:.5; cursor:not-allowed; pointer-events:none; }
.modal-content { border-radius:var(--alert-radius); border:none; box-shadow:0 20px 60px rgba(0,0,0,.3); }
.modal-body { padding:24px; }
@media(max-width:768px){ .alert-header{flex-direction:column;align-items:flex-start;} .filter-actions{width:100%;} }
</style>

<div style="padding:0;">

    <div class="alert-header">
        <div class="alert-title">
            <div class="alert-icon"><i class="ri-mist-fill"></i></div>
            <div><h4>Smoke Detection Alerts</h4><div class="subtitle">Camera Logs &amp; Activity</div></div>
        </div>
        <a href="{{ route('dashboard') }}" class="alert-back-btn"><i class="ri-arrow-left-line"></i> Back to Dashboard</a>
    </div>

    <div class="filter-card">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="filter-label">Location</label>
                <select name="location" class="form-select">
                    <option value="">All Locations</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ request('location')==$loc ? 'selected' : '' }}>{{ $loc }}</option>
                    @endforeach
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
            <div class="col-md-2">
                <label class="filter-label" style="opacity:0;">Actions</label>
                <div class="filter-actions">
                    <button type="submit" class="btn-filter flex-fill"><i class="ri-search-line"></i></button>
                    <a href="{{ route('alerts.smoke') }}" class="btn-reset"><i class="ri-refresh-line"></i></a>
                </div>
            </div>
        </form>
    </div>

    @if(request('from_date') && request('to_date'))
    <div class="info-banner">
        <i class="ri-calendar-line"></i>
        <div>Showing records from <strong>{{ \Carbon\Carbon::parse(request('from_date'))->format('d M Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse(request('to_date'))->format('d M Y') }}</strong></div>
    </div>
    @endif

    <div class="table-card">
        <div class="table-card-header">
            <h5 class="table-card-title"><i class="ri-mist-line"></i> Smoke Alert Logs</h5>
            <div style="display:flex;align-items:center;gap:10px;">
                @if($total > 0)
                <span style="font-size:13px;color:var(--alert-muted);font-weight:600;">{{ number_format($total) }} total records</span>
                @endif
                @if($alerts->count() > 0)
                <a href="{{ route('alerts.smoke.export') }}?{{ http_build_query(request()->query()) }}"
                   style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#6b7280,#4b5563);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;height:34px;padding:0 14px;cursor:pointer;box-shadow:0 4px 10px rgba(107,114,128,.25);text-decoration:none;">
                    <i class="ri-file-excel-line"></i> Export All
                </a>
                @endif
            </div>
        </div>

        @if($alerts->count() > 0)
        <div class="table-responsive">
            <table id="smokeTable" class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th data-col="0">Date &amp; Time</th>
                        <th data-col="1">Camera Name</th>
                        <th data-col="2">Location</th>
                        <th data-col="3">Alert Type</th>
                        <th class="no-sort" style="cursor:default;">Image</th>
                    </tr>
                </thead>
                <tbody id="smokeTableBody">
                    @foreach($alerts as $row)
                        <tr>
                            <td class="datetime-cell">{{ \Carbon\Carbon::parse($row['alertDateTime'])->format('d-m-Y H:i:s') }}</td>
                            <td class="camera-name">{{ $row['cameraName'] ?? '-' }}</td>
                            <td class="location-cell">{{ $row['locationName'] ?? '-' }}</td>
                            <td><span class="alert-badge"><i class="ri-mist-fill"></i> Smoke</span></td>
                            <td class="text-center">
                                @if(!empty($row['imagePath']))
                                    @php $imageUrl = 'https://co2ph3master.ajeevi.in' . $row['imagePath']; @endphp
                                    <img src="{{ $imageUrl }}" class="preview-img" data-full="{{ $imageUrl }}" loading="lazy" onerror="this.style.display='none'" alt="Smoke Alert">
                                @else
                                    <span style="color:var(--alert-muted);font-size:12px;">No Image</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state"><i class="ri-mist-line"></i><p>No smoke alerts found.</p></div>
        @endif
    </div>

    @if($alerts->hasPages())
    <div class="pagination-wrapper mb-4">
        {{ $alerts->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content"><div class="modal-body text-center">
            <img id="previewImage" class="img-fluid rounded" alt="Alert Preview">
        </div></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('smokeTable');
    let sortCol = 0, sortDir = -1;
    if (table) {
        const headers = table.querySelectorAll('thead th[data-col]');
        const tbody   = table.querySelector('tbody');
        function sortTable(colIndex, dir) {
            const rows = Array.from(tbody.querySelectorAll('tr'));
            rows.sort((a, b) => (a.cells[colIndex]?.innerText||'').trim().localeCompare((b.cells[colIndex]?.innerText||'').trim(), undefined, {numeric:true}) * dir);
            rows.forEach(r => tbody.appendChild(r));
            headers.forEach(h => { h.classList.remove('sort-asc','sort-desc'); if (parseInt(h.dataset.col)===colIndex) h.classList.add(dir===1?'sort-asc':'sort-desc'); });
        }
        sortTable(0, -1);
        headers.forEach(th => th.addEventListener('click', function () {
            const col = parseInt(this.dataset.col);
            if (col===sortCol) sortDir*=-1; else { sortCol=col; sortDir=1; }
            sortTable(sortCol, sortDir);
        }));
    }
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('preview-img')) {
            document.getElementById('previewImage').src = e.target.dataset.full;
            new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
        }
    });
});
</script>
@endpush
