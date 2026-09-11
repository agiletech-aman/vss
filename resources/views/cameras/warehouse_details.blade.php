@extends('layout.master')

@section('title', 'Warehouse Details')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
:root {
    --wd-bg: #f5f6fa; --wd-card: #ffffff; --wd-text: #111827; --wd-muted: #9ca3af; --wd-border: #e8eaed;
    --wd-red: #dc2626; --wd-red-bg: #fef2f2;
    --wd-orange: #d97706; --wd-orange-bg: #fffbeb;
    --wd-green: #16a34a; --wd-green-bg: #f0fdf4;
    --wd-blue: #3b82f6; --wd-blue-bg: #eff6ff;
    --wd-gray: #6b7280; --wd-gray-bg: #f9fafb;
    --wd-radius: 14px;
    --wd-shadow: 0 1px 4px rgba(0,0,0,.05);
    --wd-shadow-lg: 0 6px 20px rgba(0,0,0,.09);
}

.wd-page * { font-family:'DM Sans',-apple-system,sans-serif; box-sizing:border-box; }
.wd-page { background:var(--wd-bg); min-height:100vh; padding:24px; }

/* Header */
.wd-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.wd-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.wd-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--wd-card);
    color: var(--wd-text);
    font-size: 13px;
    font-weight: 600;
    padding: 10px 16px;
    border-radius: 10px;
    border: 1px solid var(--wd-border);
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: var(--wd-shadow);
}

.wd-back-btn:hover {
    background: #f8fafc;
    transform: translateY(-1px);
    box-shadow: var(--wd-shadow-lg);
    text-decoration: none;
    color: var(--wd-text);
}

.wd-header-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.wd-header-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--wd-blue-bg);
    color: var(--wd-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.wd-header-info h4 {
    font-size: 22px;
    font-weight: 800;
    color: var(--wd-text);
    margin: 0 0 4px;
    letter-spacing: -.3px;
}

.wd-header-info p {
    font-size: 13px;
    color: var(--wd-muted);
    margin: 0;
}

/* Stats Grid */
.wd-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.wd-stat-card {
    background: var(--wd-card);
    border: 1px solid var(--wd-border);
    border-radius: var(--wd-radius);
    padding: 20px;
    box-shadow: var(--wd-shadow);
    transition: transform .18s, box-shadow .18s;
}

.wd-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--wd-shadow-lg);
}

.wd-stat-card.total { border-top: 3px solid var(--wd-blue); }
.wd-stat-card.online { border-top: 3px solid var(--wd-green); }
.wd-stat-card.offline { border-top: 3px solid var(--wd-red); }
.wd-stat-card.uptime { border-top: 3px solid var(--wd-orange); }

.wd-stat-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--wd-muted);
    margin-bottom: 12px;
}

.wd-stat-value {
    font-size: 36px;
    font-weight: 800;
    font-family: 'IBM Plex Mono', monospace;
    line-height: 1;
    letter-spacing: -1px;
}

.wd-stat-card.total .wd-stat-value { color: var(--wd-blue); }
.wd-stat-card.online .wd-stat-value { color: var(--wd-green); }
.wd-stat-card.offline .wd-stat-value { color: var(--wd-red); }
.wd-stat-card.uptime .wd-stat-value { color: var(--wd-orange); }

/* NVR Configuration Section */
.wd-section-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--wd-muted);
    margin: 24px 0 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.wd-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--wd-border);
}

/* NVR Cards Grid */
.wd-nvr-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.wd-nvr-card {
    background: var(--wd-card);
    border: 1px solid var(--wd-border);
    border-radius: var(--wd-radius);
    padding: 20px;
    box-shadow: var(--wd-shadow);
    transition: transform .18s, box-shadow .18s;
}

.wd-nvr-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--wd-shadow-lg);
}

.wd-nvr-card.status-ok { border-left: 4px solid var(--wd-green); }
.wd-nvr-card.status-warning { border-left: 4px solid var(--wd-orange); }
.wd-nvr-card.status-alert { border-left: 4px solid var(--wd-red); }

.wd-nvr-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.wd-nvr-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--wd-text);
    margin-bottom: 4px;
}

.wd-nvr-type {
    font-size: 11px;
    font-weight: 600;
    color: var(--wd-muted);
    text-transform: uppercase;
    letter-spacing: .05em;
}

.wd-nvr-status-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.wd-nvr-status-badge.reachable {
    background: var(--wd-green-bg);
    color: var(--wd-green);
}

.wd-nvr-status-badge.unreachable {
    background: var(--wd-red-bg);
    color: var(--wd-red);
}

.wd-nvr-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 16px;
}

.wd-nvr-info-item {
    padding: 10px;
    background: var(--wd-gray-bg);
    border-radius: 8px;
}

.wd-nvr-info-label {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--wd-muted);
    margin-bottom: 4px;
}

.wd-nvr-info-value {
    font-size: 14px;
    font-weight: 700;
    font-family: 'IBM Plex Mono', monospace;
    color: var(--wd-text);
}

.wd-nvr-cameras {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.wd-nvr-cam-stat {
    text-align: center;
    padding: 10px 8px;
    border-radius: 8px;
}

.wd-nvr-cam-stat.total {
    background: var(--wd-blue-bg);
    border: 1px solid rgba(59, 130, 246, 0.15);
}

.wd-nvr-cam-stat.online {
    background: var(--wd-green-bg);
    border: 1px solid rgba(22, 163, 74, 0.15);
}

.wd-nvr-cam-stat.offline {
    background: var(--wd-red-bg);
    border: 1px solid rgba(220, 38, 38, 0.15);
}

.wd-nvr-cam-label {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 4px;
}

.wd-nvr-cam-stat.total .wd-nvr-cam-label { color: var(--wd-blue); }
.wd-nvr-cam-stat.online .wd-nvr-cam-label { color: var(--wd-green); }
.wd-nvr-cam-stat.offline .wd-nvr-cam-label { color: var(--wd-red); }

.wd-nvr-cam-value {
    font-size: 20px;
    font-weight: 800;
    font-family: 'IBM Plex Mono', monospace;
    line-height: 1;
}

.wd-nvr-cam-stat.total .wd-nvr-cam-value { color: var(--wd-blue); }
.wd-nvr-cam-stat.online .wd-nvr-cam-value { color: var(--wd-green); }
.wd-nvr-cam-stat.offline .wd-nvr-cam-value { color: var(--wd-red); }

.wd-nvr-footer {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid var(--wd-border);
    font-size: 11px;
    color: var(--wd-muted);
    font-family: 'IBM Plex Mono', monospace;
}

/* Error State */
.wd-error-card {
    background: var(--wd-card);
    border: 1px solid var(--wd-border);
    border-radius: var(--wd-radius);
    padding: 40px;
    text-align: center;
    box-shadow: var(--wd-shadow);
}

.wd-error-card i {
    font-size: 48px;
    color: var(--wd-orange);
    margin-bottom: 16px;
}

.wd-error-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--wd-text);
    margin-bottom: 8px;
}

.wd-error-card p {
    font-size: 14px;
    color: var(--wd-muted);
    margin-bottom: 20px;
}

@media (max-width: 1024px) {
    .wd-stats-grid { grid-template-columns: repeat(2, 1fr); }
    .wd-nvr-grid { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .wd-stats-grid { grid-template-columns: 1fr; }
    .wd-header { flex-direction: column; }
}
</style>

<div class="wd-page">

    <!-- Header -->
    <div class="wd-header">
        <div class="wd-header-title">
            <div class="wd-header-icon">
                <i class="ri-building-2-line"></i>
            </div>
            <div class="wd-header-info">
                <h4>{{ $warehouse }}</h4>
                <p>{{ $region }} Region • Camera Health Status</p>
            </div>
        </div>

        <a href="{{ route('cameras.region', ['region' => $region]) }}" class="wd-back-btn">
            <i class="ri-arrow-left-line"></i>
            Back
        </a>
    </div>

    @if(isset($error) && $error)
        <div class="wd-error-card">
            <i class="ri-alert-line"></i>
            <h3>Unable to Load Data</h3>
            <p>{{ $error }}</p>
            <a href="{{ route('cameras.region', ['region' => $region]) }}" class="wd-back-btn">
                <i class="ri-arrow-left-line"></i>
                Go Back
            </a>
        </div>
    @elseif(isset($data))
        @php
            $d = $data;
        @endphp

        <!-- Summary Stats -->
        <div class="wd-stats-grid">
            <div class="wd-stat-card total">
                <div class="wd-stat-label">Total Cameras</div>
                <div class="wd-stat-value">{{ number_format($d['total_cameras'] ?? 0) }}</div>
            </div>

            <div class="wd-stat-card online">
                <div class="wd-stat-label">Online Cameras</div>
                <div class="wd-stat-value">{{ number_format($d['online_cameras'] ?? 0) }}</div>
            </div>

            <div class="wd-stat-card offline">
                <div class="wd-stat-label">Offline Cameras</div>
                @php
                    // Treat unknown cameras as offline
                    $totalOffline = ($d['offline_cameras'] ?? 0) + ($d['unknown_cameras'] ?? 0);
                @endphp
                <div class="wd-stat-value">{{ number_format($totalOffline) }}</div>
            </div>

            <div class="wd-stat-card uptime">
                <div class="wd-stat-label">Uptime</div>
                <div class="wd-stat-value">{{ $d['uptime'] ?? 0 }}%</div>
            </div>
        </div>

        <!-- NVR Configuration -->
        <div class="wd-section-label">
            <i class="ri-router-line"></i>
            NVR Configuration ({{ $d['nvr_count'] ?? 0 }} {{ ($d['nvr_count'] ?? 0) === 1 ? 'NVR' : 'NVRs' }})
        </div>

        <div class="wd-nvr-grid">
            @foreach(($d['nvrs'] ?? []) as $index => $nvr)
                @php
                    $nvrUptime = $nvr['online_percent'] ?? 0;
                    $nvrStatusClass = $nvrUptime >= 70 ? 'status-ok' : ($nvrUptime >= 40 ? 'status-warning' : 'status-alert');

                    // Treat unknown cameras as offline for each NVR
                    $nvrTotalOffline = ($nvr['offline_cameras'] ?? 0) + ($nvr['unknown_cameras'] ?? 0);
                @endphp

                <div class="wd-nvr-card {{ $nvrStatusClass }}">
                    <!-- NVR Header -->
                    <div class="wd-nvr-header">
                        <div>
                            <div class="wd-nvr-title">NVR #{{ $index + 1 }}</div>
                            <div class="wd-nvr-type">{{ $nvr['type'] ?? 'Unknown' }}</div>
                        </div>
                        <div class="wd-nvr-status-badge {{ ($nvr['nvr_reachable'] ?? false) ? 'reachable' : 'unreachable' }}">
                            {{ ($nvr['nvr_reachable'] ?? false) ? '● Reachable' : '● Unreachable' }}
                        </div>
                    </div>

                    <!-- NVR Info -->
                    <div class="wd-nvr-info-grid">
                        <div class="wd-nvr-info-item">
                            <div class="wd-nvr-info-label">NVR IP Address</div>
                            <div class="wd-nvr-info-value">{{ $nvr['ip'] ?? '-' }}</div>
                        </div>

                        <div class="wd-nvr-info-item">
                            <div class="wd-nvr-info-label">System Status</div>
                            <div class="wd-nvr-info-value" style="color: {{ ($nvr['status'] ?? 'alert') === 'alert' ? 'var(--wd-red)' : 'var(--wd-green)' }}">
                                {{ strtoupper($nvr['status'] ?? 'UNKNOWN') }}
                            </div>
                        </div>
                    </div>

                    <!-- Camera Stats -->
                    <div class="wd-nvr-cameras">
                        <div class="wd-nvr-cam-stat total">
                            <div class="wd-nvr-cam-label">Total Cameras</div>
                            <div class="wd-nvr-cam-value">{{ $nvr['total_cameras'] ?? 0 }}</div>
                        </div>

                        <div class="wd-nvr-cam-stat online">
                            <div class="wd-nvr-cam-label">Online Cameras</div>
                            <div class="wd-nvr-cam-value">{{ $nvr['online_cameras'] ?? 0 }}</div>
                        </div>

                        <div class="wd-nvr-cam-stat offline">
                            <div class="wd-nvr-cam-label">Offline Cameras</div>
                            <div class="wd-nvr-cam-value">{{ $nvrTotalOffline }}</div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="wd-nvr-footer">
                        Last synced: {{ ($nvr['last_synced_at'] ?? null) ? \Carbon\Carbon::parse($nvr['last_synced_at'])->format('d M Y, H:i') : 'Never' }}
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>

@endsection
