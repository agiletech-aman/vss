@extends('layout.master')

@section('title', 'Face Recognition Logs')

@section('content')

<style>
.page-content { background: #f0f2f7 !important; }
.page-header { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 24px; flex-wrap: wrap; }
.page-header-left { display: flex; align-items: center; gap: 14px; }
.page-back-btn { display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #1e293b; font-size: 13px; font-weight: 600; padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0; text-decoration: none; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.page-back-btn:hover { background: #f8fafc; color: #1e293b; text-decoration: none; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.page-back-btn i { font-size: 14px; }
.page-header-icon { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; font-size: 22px; color: #fff; box-shadow: 0 6px 16px rgba(30,58,138,0.30); }
.page-header-text h4 { font-size: 20px; font-weight: 800; color: #1e293b; margin: 0; line-height: 1.2; }
.page-header-text span { font-size: 12px; color: #94a3b8; font-weight: 500; }
.filter-card { background: #ffffff; border-radius: 16px; border: 1px solid #e4e8ee; box-shadow: 0 2px 12px rgba(0,0,0,0.05); padding: 20px 24px; margin-bottom: 20px; }
.filter-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #64748b; margin-bottom: 6px; display: block; }
.filter-card .form-select, .filter-card .form-control { border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #1e293b; height: 40px; background-color: #f8fafc; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
.filter-card .form-select:focus, .filter-card .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); background: #fff; }
.filter-card .btn-primary { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none; border-radius: 10px; font-size: 13px; font-weight: 600; height: 40px; box-shadow: 0 4px 12px rgba(59,130,246,0.30); transition: all 0.2s ease; }
.filter-card .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(59,130,246,0.40); }
.filter-card .btn-reset { border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; font-weight: 600; height: 40px; color: #64748b; background: #f8fafc; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; text-decoration: none; }
.filter-card .btn-reset:hover { background: #f1f5f9; border-color: #cbd5e1; color: #1e293b; }
.btn-export { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; height: 36px; padding: 0 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(59,130,246,.25); transition: all .2s; text-decoration: none; white-space: nowrap; }
.btn-export:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(59,130,246,.40); color: #fff; }
.table-card { background: #ffffff; border-radius: 16px; border: 1px solid #e4e8ee; box-shadow: 0 2px 12px rgba(0,0,0,0.05); overflow: hidden; animation: cardIn 0.4s 0.20s ease both; }
.table-card-header { padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.table-card-title { font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }
.table-card-title i { color: #3b82f6; font-size: 16px; }
.table-card-actions { display: flex; align-items: center; justify-content: flex-end; gap: 10px; flex-wrap: wrap; }
.table-search { position: relative; min-width: 220px; }
.table-search i { position: absolute; left: 11px; top: 50%; color: #94a3b8; font-size: 15px; pointer-events: none; transform: translateY(-50%); }
.table-search input { width: 100%; height: 36px; padding: 6px 12px 6px 34px; border: 1px solid #dbe3ee; border-radius: 9px; background: #fff; color: #1e293b; font-size: 13px; outline: none; transition: border-color .2s ease, box-shadow .2s ease; }
.table-search input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.10); }
.record-count-badge { font-size: 11px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }
.table-card-body { padding: 0; }
.table-card-body .table-responsive { overflow-x: auto; scrollbar-color: #cbd5e1 #f8fafc; }
#frsTable { table-layout: fixed; width: 100% !important; min-width: 1060px; margin: 0 !important; }
#frsTable thead th { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; border-top: none; padding: 14px 28px 14px 12px; white-space: nowrap; vertical-align: middle; }
#frsTable tbody td { height: 78px; font-size: 13px; color: #334155; padding: 9px 12px; border-color: #edf2f7; vertical-align: middle; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
#frsTable tbody tr { transition: background 0.15s ease; }
#frsTable tbody tr:hover { background: #f8fafc; }
#frsTable th:nth-child(7), #frsTable td:nth-child(7),
#frsTable th:nth-child(8), #frsTable td:nth-child(8) { text-align: center !important; padding: 8px !important; }
.badge { font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
.badge.bg-success { background: linear-gradient(135deg, #065f46, #10b981) !important; }
.badge.bg-secondary { background: linear-gradient(135deg, #475569, #64748b) !important; }
.img-thumbnail { border: 2px solid #e2e8f0; border-radius: 8px; transition: all 0.2s ease; display: inline-block; width: 60px !important; height: 60px !important; object-fit: cover; }
.img-thumbnail:hover { border-color: #3b82f6; transform: scale(1.05); box-shadow: 0 4px 12px rgba(59,130,246,0.20); }
.preview-img { cursor: pointer; }
.no-img { font-size: 11px; color: #94a3b8; }
.dataTables_wrapper .dataTables_length select { border: 1px solid #e2e8f0; border-radius: 8px; padding: 4px 8px; font-size: 13px; color: #1e293b; margin: 0 6px; }
.dataTables_wrapper .dataTables_info { font-size: 12px; color: #94a3b8; padding-top: 16px; }
.dataTables_wrapper .dataTables_paginate { padding-top: 12px; }
.dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 8px !important; font-size: 12px; font-weight: 600; padding: 4px 10px !important; border: none !important; color: #64748b !important; }
.dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f1f5f9 !important; color: #1e293b !important; border: none !important; }
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important; color: #fff !important; border: none !important; }
.dataTables_wrapper .row { margin-left: 0 !important; margin-right: 0 !important; }
.modal-content { border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15); }
.modal-header { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; padding: 18px 24px; }
.modal-title { font-size: 16px; font-weight: 700; color: #1e293b; }
.modal-body { padding: 24px; }
.btn-close { background-size: 14px; }
.pagination { margin-bottom: 0; }
.pagination .page-link { border: 1px solid #e2e8f0; border-radius: 8px; color: #64748b; font-size: 13px; font-weight: 600; padding: 6px 12px; margin: 0 4px; transition: all 0.2s ease; }
.pagination .page-link:hover { background: #f1f5f9; border-color: #cbd5e1; color: #1e293b; }
.pagination .page-item.active .page-link { background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-color: transparent; color: #fff; }
.pagination .page-item.disabled .page-link { background: #f8fafc; border-color: #e2e8f0; color: #cbd5e1; }
@keyframes cardIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
@media (max-width: 768px) { .page-header { flex-direction: column; align-items: flex-start; } .page-header-icon { width: 40px; height: 40px; font-size: 18px; } .page-header-text h4 { font-size: 18px; } .table-card-header, .table-card-actions { align-items: stretch; flex-direction: column; } .table-card-actions { width: 100%; } .table-search { min-width: 100%; order: -1; } .btn-export { justify-content: center; } }
</style>

{{-- Pass ALL logs to JS for export --}}
<script>
    const FRS_ALL_LOGS = @json($allLogsForExport);
</script>

{{-- ── Page Header ── --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-icon">
            <i class="ri-user-search-line"></i>
        </div>
        <div class="page-header-text">
            <h4>Face Recognition System (FRS)</h4>
            <span>Monitor face detection logs across warehouses</span>
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="page-back-btn">
        <i class="ri-arrow-left-line"></i>
        Back to Dashboard
    </a>
</div>

{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" id="frsFilterForm" class="row g-2 align-items-end">

        <input type="hidden" name="region_id"      id="region_id_input"     value="{{ request('region_id') }}">
        <input type="hidden" name="warehouse_id"   id="warehouse_id_input"  value="{{ request('warehouse_id') }}">
        <input type="hidden" name="region_name"    id="region_name"         value="{{ request('region_name') }}">
        <input type="hidden" name="warehouse_name" id="warehouse_name"      value="{{ request('warehouse_name') }}">

        <div class="col-md-3">
            <label class="filter-label">Region</label>
            <select id="region" class="form-select">
                <option value="">Select Region</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="filter-label">Warehouse</label>
            <select id="warehouse" class="form-select" disabled>
                <option value="">Select Warehouse</option>
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
            <button type="submit" class="btn btn-primary w-100">
                <i class="ri-search-line"></i>
            </button>
        </div>

        <div class="col-md-1">
            <a href="{{ route('frs.logs') }}" class="btn-reset w-100">
                <i class="ri-refresh-line"></i>
            </a>
        </div>

    </form>
</div>

{{-- ── Data Table ── --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            <i class="ri-table-line"></i>
            FRS Detection Logs
        </div>
        <div class="table-card-actions">
            <label class="table-search" for="frsTableSearch">
                <i class="ri-search-line"></i>
                <input type="search" id="frsTableSearch" placeholder="Search logs..." autocomplete="off">
            </label>
            <span class="record-count-badge">
                {{ $paginatedLogs->count() }} of {{ $total }} records
            </span>
            @if($total > 0)
            <button onclick="exportFrsExcel()" class="btn-export">
                <i class="ri-file-excel-line"></i>
                Export Excel ({{ $total }})
            </button>
            @endif
        </div>
    </div>
    <div class="table-card-body">
        <div class="table-responsive">
            <table id="frsTable" class="table table-bordered align-middle w-100">
                <colgroup>
                    <col style="width: 170px;">
                    <col style="width: 130px;">
                    <col style="width: 105px;">
                    {{-- Confidence column removed --}}
                    <col style="width: 125px;">
                    <col style="width: 180px;">
                    <col style="width: 220px;">
                    <col style="width: 85px;">
                    <col style="width: 85px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Date &amp; Time</th>
                        <th>Name</th>
                        <th>Status</th>
                        {{-- <th>Confidence</th> --}}
                        <th>Region</th>
                        <th>Warehouse</th>
                        <th>Camera</th>
                        <th class="text-center">Crop</th>
                        <th class="text-center">Frame</th>
                    </tr>
                </thead>
                <tbody id="frsTableBody">

                @foreach($paginatedLogs as $log)
                    @php
                        $base    = 'https://frsbag.cwcnewiot.in/frs/';
                        $altBase = 'https://frsbag.cwcnewiot.in/';

                        $cropPath  = !empty($log['crop_path'])  ? ltrim($log['crop_path'],  '/') : null;
                        $framePath = !empty($log['frame_path']) ? ltrim($log['frame_path'], '/') : null;

                        $cropUrl   = $cropPath  ? $base . $cropPath  : null;
                        $frameUrl  = $framePath ? $base . $framePath : null;

                        $cropAlt   = $cropPath  ? $altBase . $cropPath  : null;
                        $frameAlt  = $framePath ? $altBase . $framePath : null;
                    @endphp
                    <tr>
                        <td class="text-nowrap">
                            {{ \Carbon\Carbon::parse($log['timestamp'])->format('d-m-Y H:i:s') }}
                        </td>
                        <td title="{{ $log['name'] ?? 'Unknown' }}">{{ $log['name'] ?? 'Unknown' }}</td>
                        <td>
                            <span class="badge {{ ($log['status'] ?? '') === 'known' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($log['status'] ?? 'unknown') }}
                            </span>
                        </td>
                        {{-- Confidence hidden
                        <td>
                            <span class="badge {{ $confidence >= 80 ? 'bg-success' : ($confidence >= 60 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $confidence }}%
                            </span>
                        </td>
                        --}}
                        <td title="{{ $log['region'] ?? '-' }}">{{ $log['region'] ?? '-' }}</td>
                        <td title="{{ $log['warehouse'] ?? '-' }}">{{ $log['warehouse'] ?? '-' }}</td>
                        <td title="{{ $log['camera_label'] ?? '-' }}">{{ $log['camera_label'] ?? '-' }}</td>

                        {{-- Crop image --}}
                        <td class="text-center">
                            @if($cropUrl)
                                <img src="{{ $cropUrl }}"
                                     class="img-thumbnail preview-img"
                                     data-full="{{ $cropUrl }}"
                                     data-alt="{{ $cropAlt }}"
                                     loading="lazy"
                                     onerror="if(!this.dataset.tried){this.dataset.tried=1;this.src=this.dataset.alt;}else{this.style.display='none';}"
                                     alt="Crop">
                            @else
                                <span class="no-img">-</span>
                            @endif
                        </td>

                        {{-- Frame image --}}
                        <td class="text-center">
                            @if($frameUrl)
                                <img src="{{ $frameUrl }}"
                                     class="img-thumbnail preview-img"
                                     data-full="{{ $frameUrl }}"
                                     data-alt="{{ $frameAlt }}"
                                     loading="lazy"
                                     onerror="if(!this.dataset.tried){this.dataset.tried=1;this.src=this.dataset.alt;}else{this.style.display='none';}"
                                     alt="Frame">
                            @else
                                <span class="no-img">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── Pagination ── --}}
<div class="mt-3">
    {{ $paginatedLogs->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<!-- IMAGE PREVIEW MODAL -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-image-line me-2"></i>
                    Image Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>

<script>

/* ====================================
   LOAD REGIONS & WAREHOUSES
==================================== */
document.addEventListener('DOMContentLoaded', () => {

    const regionSelect       = document.getElementById('region');
    const warehouseSelect    = document.getElementById('warehouse');
    const filterForm         = document.getElementById('frsFilterForm');
    const regionIdInput      = document.getElementById('region_id_input');
    const warehouseIdInput   = document.getElementById('warehouse_id_input');
    const regionNameInput    = document.getElementById('region_name');
    const warehouseNameInput = document.getElementById('warehouse_name');

    const selectedRegionId    = "{{ request('region_id') }}";
    const selectedWarehouseId = "{{ request('warehouse_id') }}";

    let allWarehouses    = [];
    let hasAutoSubmitted = false;

    Promise.all([
        fetch('/iot/frs/regions').then(r => r.json()),
        fetch('/iot/frs/warehouses').then(r => r.json())
    ]).then(([regions, warehouses]) => {

        allWarehouses = warehouses;

        regionSelect.innerHTML = '<option value="">Select Region</option>';
        regions.forEach(region => {
            const id   = region.id || region.region_id;
            const name = region.region_name || region.name;
            regionSelect.innerHTML += `<option value="${id}" data-name="${name}" ${id == selectedRegionId ? 'selected' : ''}>${name}</option>`;
        });

        if (selectedRegionId && regionSelect.selectedIndex > 0) {
            const opt = regionSelect.options[regionSelect.selectedIndex];
            regionIdInput.value   = selectedRegionId;
            regionNameInput.value = opt.dataset.name || opt.text;
        }

        if (regions.length === 1) {
            const r  = regions[0];
            const id = r.id || r.region_id;
            regionSelect.value    = id;
            regionSelect.disabled = true;
            regionIdInput.value   = id;
            regionNameInput.value = r.region_name || r.name;
        }

        const regionToLoad = selectedRegionId ||
            (regions.length === 1 ? (regions[0].id || regions[0].region_id) : null);

        if (regionToLoad) {
            loadWarehouses(regionToLoad, () => {
                if (warehouses.length === 1 && !selectedRegionId && !hasAutoSubmitted) {
                    hasAutoSubmitted = true;
                    setTimeout(submitForm, 500);
                }
            });
        }

    }).catch(err => console.error('Dropdown error:', err));

    regionSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        regionIdInput.value      = this.value;
        regionNameInput.value    = opt ? (opt.dataset.name || opt.text) : '';
        warehouseIdInput.value   = '';
        warehouseNameInput.value = '';
        loadWarehouses(this.value);
    });

    warehouseSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        warehouseIdInput.value   = this.value;
        warehouseNameInput.value = opt ? (opt.dataset.name || opt.text) : '';

        if (regionSelect.disabled && this.value && !hasAutoSubmitted) {
            hasAutoSubmitted = true;
            setTimeout(submitForm, 300);
        }
    });

    function loadWarehouses(regionId, callback) {
        warehouseSelect.innerHTML = '<option value="">Select Warehouse</option>';
        warehouseSelect.disabled  = true;
        warehouseIdInput.value    = '';
        warehouseNameInput.value  = '';

        if (!regionId) return;

        const filtered = allWarehouses.filter(wh => wh.region_id == regionId);

        filtered.forEach(wh => {
            const id   = wh.id || wh.warehouse_id;
            const name = wh.warehouse_name || wh.name;
            const sel  = id == selectedWarehouseId ? 'selected' : '';
            warehouseSelect.innerHTML += `<option value="${id}" data-name="${name}" ${sel}>${name}</option>`;
        });

        if (selectedWarehouseId && warehouseSelect.selectedIndex > 0) {
            const selOpt = warehouseSelect.options[warehouseSelect.selectedIndex];
            warehouseIdInput.value   = selectedWarehouseId;
            warehouseNameInput.value = selOpt.dataset.name || selOpt.text;
        }

        if (filtered.length === 1) {
            const wh = filtered[0];
            const id = wh.id || wh.warehouse_id;
            warehouseSelect.value    = id;
            warehouseSelect.disabled = true;
            warehouseIdInput.value   = id;
            warehouseNameInput.value = wh.warehouse_name || wh.name;
        } else {
            warehouseSelect.disabled = filtered.length === 0;
        }

        if (callback) callback();
    }

    function submitForm() {
        if (regionSelect.disabled)    regionSelect.disabled    = false;
        if (warehouseSelect.disabled) warehouseSelect.disabled = false;
        filterForm.submit();
    }

    filterForm.addEventListener('submit', function () {
        if (regionSelect.disabled)    regionSelect.disabled    = false;
        if (warehouseSelect.disabled) warehouseSelect.disabled = false;
    });
});


/* ====================================
   DATATABLE
==================================== */
$(document).ready(function () {
    const frsTable = $('#frsTable').DataTable({
        paging:    false,
        info:      false,
        searching: true,
        ordering:  true,
        order:     [[0, 'desc']],
        autoWidth: false,
        dom:        't',
        columnDefs: [
            { targets: 6, orderable: false, className: 'text-center' },
            { targets: 7, orderable: false, className: 'text-center' }
        ],
        language: {
            emptyTable:  'No FRS logs found.',
            zeroRecords: 'No logs match your filter.'
        }
    });

    $('#frsTableSearch').on('input', function () {
        frsTable.search(this.value).draw();
    });
});


/* ====================================
   IMAGE PREVIEW
==================================== */
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('preview-img')) {
        document.getElementById('previewImage').src = e.target.dataset.full;
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }
});


/* ====================================
   EXCEL EXPORT — Confidence removed
==================================== */
function exportFrsExcel() {
    if (!FRS_ALL_LOGS || !FRS_ALL_LOGS.length) {
        alert('No data to export.');
        return;
    }

    const headers = [
        '#',
        'Date & Time',
        'Name',
        'Status',
        // 'Confidence', // removed
        'Region',
        'Warehouse',
        'Camera',
        'Crop Image URL',
        'Frame Image URL',
    ];

    const data = [headers];

    FRS_ALL_LOGS.forEach((row, i) => {
        data.push([
            i + 1,
            row.datetime,
            row.name,
            row.status,
            // row.confidence, // removed
            row.region,
            row.warehouse,
            row.camera,
            row.crop_url  || '-',
            row.frame_url || '-',
        ]);
    });

    const ws = XLSX.utils.aoa_to_sheet(data);

    ws['!cols'] = [
        { wch: 5  },
        { wch: 20 },
        { wch: 25 },
        { wch: 12 },
        // { wch: 12 }, // confidence removed
        { wch: 15 },
        { wch: 18 },
        { wch: 25 },
        { wch: 65 },
        { wch: 65 },
    ];

    ws['!freeze'] = { xSplit: 0, ySplit: 1 };

    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'FRS Logs');
    XLSX.writeFile(wb, 'FRS_Logs_' + new Date().toISOString().slice(0, 10) + '.xlsx');
}

</script>
@endpush
