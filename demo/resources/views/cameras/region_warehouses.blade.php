@extends('layout.master')

@section('title', $region . ' - Warehouses')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
:root {
    --rw-bg: #f5f6fa;
    --rw-card: #ffffff;
    --rw-text: #111827;
    --rw-muted: #9ca3af;
    --rw-border: #e8eaed;
    --rw-red: #dc2626;
    --rw-red-bg: #fef2f2;
    --rw-orange: #d97706;
    --rw-orange-bg: #fffbeb;
    --rw-green: #16a34a;
    --rw-green-bg: #f0fdf4;
    --rw-blue: #3b82f6;
    --rw-blue-bg: #eff6ff;
    --rw-radius: 14px;
    --rw-shadow: 0 1px 4px rgba(0,0,0,.05);
    --rw-shadow-lg: 0 6px 20px rgba(0,0,0,.09);
}

.rw-page * { font-family:'DM Sans',-apple-system,sans-serif; box-sizing:border-box; }
.rw-page { background:var(--rw-bg); min-height:100vh; padding:24px; }

/* Header with Back Button on Right */
.rw-header { margin-bottom:24px; }
.rw-header-top { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:8px; }
.rw-header-left { display:flex; align-items:center; gap:12px; }

/* Back Button - Right Side */
.rw-back-btn {
    background: #ffffff;
    color: #1e293b;
    padding: 10px 16px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.rw-back-btn:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    text-decoration: none;
    color: #0f172a;
}

.rw-back-btn i { font-size: 16px; }

.rw-header-icon { width:48px; height:48px; background:var(--rw-blue-bg); color:var(--rw-blue); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; }
.rw-title { font-size:28px; font-weight:800; color:var(--rw-text); letter-spacing:-.5px; }
.rw-subtitle { font-size:14px; color:var(--rw-muted); font-weight:500; }

/* Stats Grid */
.rw-stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:32px; }
.rw-stat-card { background:var(--rw-card); border:1px solid var(--rw-border); border-radius:var(--rw-radius); padding:20px; box-shadow:var(--rw-shadow); transition:transform .18s,box-shadow .18s; }
.rw-stat-card:hover { transform:translateY(-2px); box-shadow:var(--rw-shadow-lg); }
.rw-stat-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--rw-muted); margin-bottom:8px; }
.rw-stat-value { font-size:32px; font-weight:800; font-family:'IBM Plex Mono',monospace; line-height:1; letter-spacing:-.5px; }
.rw-stat-meta { margin-top:12px; padding-top:12px; border-top:1px solid #f3f4f6; font-size:12px; color:var(--rw-muted); display:flex; align-items:center; gap:6px; }

/* Section Label */
.rw-section-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--rw-muted); margin:24px 0 16px; display:flex; align-items:center; gap:8px; }
.rw-section-label::after { content:''; flex:1; height:1px; background:var(--rw-border); }
.rw-section-label i { font-size:13px; }

/* Warehouse Grid */
.rw-warehouse-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:16px; }

.rw-warehouse-card {
    background: var(--rw-card);
    border: 1px solid var(--rw-border);
    border-radius: var(--rw-radius);
    padding: 20px;
    box-shadow: var(--rw-shadow);
    transition: all 0.2s ease;
    text-decoration: none;
    display: block;
}

.rw-warehouse-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--rw-shadow-lg);
    border-color: var(--rw-blue);
    text-decoration: none;
}

.rw-warehouse-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.rw-warehouse-name {
    font-size: 17px;
    font-weight: 700;
    color: var(--rw-text);
    display: flex;
    align-items: center;
    gap: 10px;
}

.rw-warehouse-name i {
    color: var(--rw-blue);
    font-size: 20px;
}

.rw-warehouse-status {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.rw-warehouse-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 16px;
    padding: 16px 0;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}

.rw-stat-item {
    text-align: center;
}

.rw-stat-item-label {
    display: block;
    font-size: 10px;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.rw-stat-item-value {
    display: block;
    font-size: 18px;
    font-weight: 700;
    color: var(--rw-text);
    font-family: 'IBM Plex Mono', monospace;
}

.rw-warehouse-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    font-size: 13px;
    padding-top: 4px;
}

.rw-view-link {
    color: var(--rw-blue);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s ease;
}

.rw-warehouse-card:hover .rw-view-link {
    gap: 10px;
}

@media (max-width:1024px) { .rw-stats-grid { grid-template-columns:repeat(2,1fr); } .rw-warehouse-grid { grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); } }
@media (max-width:640px) { .rw-stats-grid { grid-template-columns:1fr; } .rw-warehouse-grid { grid-template-columns:1fr; } }
</style>

<div class="rw-page">

    {{-- Header with Back Button on Right --}}
    <div class="rw-header">
        <div class="rw-header-top">
            <div class="rw-header-left">
                <div class="rw-header-icon"><i class="ri-map-pin-line"></i></div>
                <div>
                    <div class="rw-title">{{ $region }}</div>
                    <div class="rw-subtitle">Camera Network Overview • {{ $stats['warehouse_count'] ?? 0 }} Warehouses</div>
                </div>
            </div>

            {{-- Back Button on Right --}}
            <a href="{{ route('dashboard') }}" class="rw-back-btn">
                <i class="ri-arrow-left-line"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Region Stats --}}
    <div class="rw-stats-grid">

        <div class="rw-stat-card" style="border-top:3px solid var(--rw-blue);">
            <div class="rw-stat-label">Total Cameras</div>
            <div class="rw-stat-value" style="color:var(--rw-blue);">{{ number_format($stats['total_cameras'] ?? 0) }}</div>
            <div class="rw-stat-meta">
                <i class="ri-vidicon-line"></i>
                Across All Warehouses
            </div>
        </div>

        <div class="rw-stat-card" style="border-top:3px solid var(--rw-green);">
            <div class="rw-stat-label">Online Cameras</div>
            <div class="rw-stat-value" style="color:var(--rw-green);">{{ number_format($stats['online_cameras'] ?? 0) }}</div>
            <div class="rw-stat-meta">
                <i class="ri-check-line"></i>
                Operational
            </div>
        </div>

        <div class="rw-stat-card" style="border-top:3px solid var(--rw-red);">
            <div class="rw-stat-label">Offline Cameras</div>
            <div class="rw-stat-value" style="color:var(--rw-red);">{{ number_format($stats['offline_cameras'] ?? 0) }}</div>
            <div class="rw-stat-meta">
                <i class="ri-close-line"></i>
                Not Responding
            </div>
        </div>

        <div class="rw-stat-card" style="border-top:3px solid var(--rw-orange);">
            <div class="rw-stat-label">Uptime</div>
            <div class="rw-stat-value" style="color:var(--rw-orange);">{{ $stats['online_percent'] ?? 0 }}%</div>
            <div class="rw-stat-meta">
                <i class="ri-percent-line"></i>
                Regional Average
            </div>
        </div>

    </div>

    {{-- Warehouses Section --}}
    <div class="rw-section-label">
        <i class="ri-building-line"></i>
        Warehouses in {{ $region }}
    </div>

    <div class="rw-warehouse-grid">
        @foreach($warehouses as $warehouse)
            @php
                // ✅ FIXED: Use status instead of nvr_reachable (which doesn't exist in region list)
                $statusColor = ($warehouse['online_percent'] ?? 0) >= 80 ? 'var(--rw-green)' :
                              (($warehouse['online_percent'] ?? 0) >= 50 ? 'var(--rw-orange)' : 'var(--rw-red)');
                $statusIcon = ($warehouse['status'] ?? 'alert') === 'ok' ? 'ri-check-line' : 'ri-close-line';
                $statusBg = ($warehouse['online_percent'] ?? 0) >= 80 ? 'var(--rw-green-bg)' :
                           (($warehouse['online_percent'] ?? 0) >= 50 ? 'var(--rw-orange-bg)' : 'var(--rw-red-bg)');
            @endphp

            <a href="{{ route('cameras.warehouse.details', ['region' => $region, 'warehouse' => $warehouse['warehouse'] ?? '']) }}" class="rw-warehouse-card">
                <div class="rw-warehouse-header">
                    <div class="rw-warehouse-name">
                        <i class="ri-building-line"></i>
                        {{ $warehouse['warehouse'] ?? 'Unknown' }}
                    </div>
                    <div class="rw-warehouse-status" style="background:{{ $statusBg }};color:{{ $statusColor }};">
                        <i class="{{ $statusIcon }}"></i>
                    </div>
                </div>

                <div class="rw-warehouse-stats">
                    <div class="rw-stat-item">
                        <span class="rw-stat-item-label">Total Cameras</span>
                        <span class="rw-stat-item-value">{{ $warehouse['total_cameras'] ?? 0 }}</span>
                    </div>
                    <div class="rw-stat-item">
                        <span class="rw-stat-item-label">Online Cameras</span>
                        <span class="rw-stat-item-value" style="color:var(--rw-green);">{{ $warehouse['online_cameras'] ?? 0 }}</span>
                    </div>
                    <div class="rw-stat-item">
                        <span class="rw-stat-item-label">Offline Cameras</span>
                        <span class="rw-stat-item-value" style="color:var(--rw-red);">{{ $warehouse['offline_cameras'] ?? 0 }}</span>
                    </div>
                    <div class="rw-stat-item">
                        <span class="rw-stat-item-label">Uptime</span>
                        <span class="rw-stat-item-value" style="color:{{ $statusColor }};">{{ $warehouse['online_percent'] ?? 0 }}%</span>
                    </div>
                </div>

                <div class="rw-warehouse-footer">
                    <span class="rw-view-link">View Details <i class="ri-arrow-right-line"></i></span>
                </div>
            </a>
        @endforeach
    </div>

</div>

@endsection
