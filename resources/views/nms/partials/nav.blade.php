{{-- resources/views/nms/partials/nav.blade.php --}}
@php $cur = request()->route()?->getName() ?? ''; @endphp
<div style="display:flex;gap:4px;background:#fff;border:1.5px solid var(--border);border-radius:10px;padding:4px;margin-bottom:20px;box-shadow:var(--sh);flex-wrap:wrap;">
    <a href="{{ route('nms.pages.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:7px;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;{{ $cur==='nms.pages.dashboard' ? 'background:var(--navy);color:#fff;' : 'color:var(--muted);' }}">
        <i class="ri-dashboard-3-line"></i> Dashboard
    </a>
    <a href="{{ route('nms.pages.regions') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:7px;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;{{ str_starts_with($cur,'nms.pages.region') ? 'background:var(--navy);color:#fff;' : 'color:var(--muted);' }}">
        <i class="ri-map-pin-2-line"></i> Regions
    </a>
    <a href="{{ route('nms.pages.warehouses') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:7px;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;{{ str_starts_with($cur,'nms.pages.warehouse') ? 'background:var(--navy);color:#fff;' : 'color:var(--muted);' }}">
        <i class="ri-building-2-line"></i> Warehouses
    </a>
    <a href="{{ route('nms.pages.map') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:7px;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;{{ $cur==='nms.pages.map' ? 'background:var(--navy);color:#fff;' : 'color:var(--muted);' }}">
        <i class="ri-map-2-line"></i> Live Map
    </a>
    <div style="flex:1;"></div>
    <div class="live-chip"><span class="live-dot"></span><span id="nmsNavTime">Live</span></div>
</div>
