{{-- resources/views/nms/partials/styles.blade.php --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
    --bg:#eef0f6; --card:#fff; --text:#0f172a; --text-2:#475569; --muted:#94a3b8;
    --border:#e2e8f0; --navy:#1e293b; --navy-l:#f1f5f9; --navy-b:#94a3b8;
    --blue:#2563eb; --blue-l:#eff6ff; --blue-b:#bfdbfe; --blue-d:#1d4ed8;
    --green:#059669; --green-l:#ecfdf5; --green-b:#a7f3d0; --green-d:#047857;
    --red:#dc2626; --red-l:#fef2f2; --red-b:#fecaca; --red-d:#b91c1c;
    --orange:#d97706; --orange-l:#fffbeb; --orange-b:#fde68a; --orange-d:#b45309;
    --amber:#f59e0b; --amber-l:#fffbeb; --amber-b:#fde68a; --amber-d:#92400e;
    --teal:#0d9488; --teal-l:#f0fdfa; --teal-b:#99f6e4; --teal-d:#0f766e;
    --r:12px; --rs:8px;
    --sh:0 1px 3px rgba(0,0,0,.05),0 1px 2px rgba(0,0,0,.03);
    --sh-m:0 4px 12px rgba(0,0,0,.07),0 2px 4px rgba(0,0,0,.04);
    --sh-l:0 12px 32px rgba(0,0,0,.1),0 4px 8px rgba(0,0,0,.05);
}
.nms * { font-family:'DM Sans',-apple-system,sans-serif; box-sizing:border-box; }
.nms   { background:var(--bg); padding-bottom:48px; }
.nms-nav { display:flex; gap:4px; background:#fff; border:1.5px solid var(--border); border-radius:var(--r); padding:5px; margin-bottom:22px; flex-wrap:wrap; box-shadow:var(--sh); }
.nms-nav-item { display:inline-flex; align-items:center; gap:6px; padding:7px 15px; border-radius:var(--rs); font-size:12.5px; font-weight:700; color:var(--muted); text-decoration:none; transition:all .16s; white-space:nowrap; }
.nms-nav-item:hover { color:var(--navy); background:var(--navy-l); text-decoration:none; }
.nms-nav-item.active { background:var(--navy); color:#fff; }
.nms-nav-item i { font-size:14px; }
.nms-kpi-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-bottom:20px; }
.nms-kpi { background:var(--card); border:1.5px solid var(--border); border-radius:var(--r); padding:14px 18px; box-shadow:var(--sh); position:relative; overflow:hidden; }
.nms-kpi::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; border-radius:2px 0 0 2px; }
.nms-kpi.k-green::before  { background:var(--green); }
.nms-kpi.k-red::before    { background:var(--red); }
.nms-kpi.k-blue::before   { background:var(--blue); }
.nms-kpi.k-orange::before { background:var(--orange); }
.nms-kpi.k-navy::before   { background:var(--navy); }
.nms-kpi.k-amber::before  { background:var(--amber); }
.nms-kpi-lbl { font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); margin-bottom:5px; }
.nms-kpi-val { font-family:'IBM Plex Mono',monospace; font-size:1.75rem; font-weight:800; line-height:1; color:var(--text); }
.nms-kpi-sub { font-size:10.5px; color:var(--muted); margin-top:4px; font-weight:500; }
.nms-kpi-bar { height:3px; background:#f1f5f9; border-radius:999px; overflow:hidden; margin-top:8px; }
.nms-kpi-bar-fill { height:100%; border-radius:999px; transition:width .8s; }
.nms-card { background:var(--card); border:1.5px solid var(--border); border-radius:var(--r); box-shadow:var(--sh-m); overflow:hidden; margin-bottom:18px; }
.nms-card-hdr { display:flex; align-items:center; justify-content:space-between; padding:13px 20px; border-bottom:1.5px solid var(--border); background:linear-gradient(90deg,#f8fafc,#fff); flex-wrap:wrap; gap:10px; }
.nms-card-title { font-size:13.5px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:8px; }
.nms-card-title i { color:var(--muted); font-size:15px; }
.nms-tbl { width:100%; border-collapse:collapse; font-size:12.5px; }
.nms-tbl thead th { background:#f8fafc; color:var(--muted); font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; padding:10px 14px; border-bottom:1.5px solid var(--border); text-align:left; white-space:nowrap; }
.nms-tbl tbody td { padding:11px 14px; border-bottom:1px solid #f0f4f8; color:var(--text); vertical-align:middle; }
.nms-tbl tbody tr:last-child td { border-bottom:none; }
.nms-tbl tbody tr:hover { background:#f8faff; cursor:pointer; }
.nms-tbl .t-m { font-family:'IBM Plex Mono',monospace; font-weight:700; font-size:12px; }
.nms-tbl .t-b { font-weight:700; font-size:13px; }
.badge { display:inline-flex; align-items:center; gap:4px; font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; border:1.5px solid; white-space:nowrap; }
.badge-g   { background:var(--green-l);  color:var(--green-d);  border-color:var(--green-b); }
.badge-r   { background:var(--red-l);    color:var(--red-d);    border-color:var(--red-b); }
.badge-a   { background:var(--orange-l); color:var(--orange-d); border-color:var(--orange-b); }
.badge-b   { background:var(--blue-l);   color:var(--blue-d);   border-color:var(--blue-b); }
.badge-n   { background:var(--navy-l);   color:var(--navy);     border-color:var(--navy-b); }
.badge-amb { background:var(--amber-l);  color:var(--amber-d);  border-color:var(--amber-b); }
.badge-dot { width:5px; height:5px; border-radius:50%; background:currentColor; }
.pct-bar { display:flex; align-items:center; gap:8px; }
.pct-track { flex:1; max-width:80px; height:6px; background:#e9eef5; border-radius:3px; overflow:hidden; }
.pct-fill  { height:100%; border-radius:3px; transition:width .6s; }
.nms-filters { background:var(--card); border:1.5px solid var(--border); border-left:4px solid var(--navy); border-radius:var(--r); padding:14px 20px; box-shadow:var(--sh); margin-bottom:18px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; }
.nms-filter-item { display:flex; flex-direction:column; gap:5px; }
.nms-filter-lbl  { font-size:10.5px; font-weight:700; color:var(--navy); }
.nms-filter-sel, .nms-filter-inp { height:38px; border:1.5px solid var(--border); border-radius:var(--rs); padding:0 12px; font-size:12.5px; font-family:'DM Sans',sans-serif; color:var(--text); background:#fff; outline:none; transition:all .16s; }
.nms-filter-sel { padding-right:32px; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; cursor:pointer; min-width:140px; }
.nms-filter-sel:focus, .nms-filter-inp:focus { border-color:var(--navy); box-shadow:0 0 0 3px rgba(30,41,59,.08); }
.nms-filter-inp { min-width:200px; }
.nms-btn { display:inline-flex; align-items:center; gap:5px; height:38px; padding:0 16px; font-size:12.5px; font-weight:700; border-radius:var(--rs); border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:all .16s; white-space:nowrap; }
.nms-btn-primary { background:var(--navy); color:#fff; }
.nms-btn-primary:hover { background:#0f172a; }
.nms-btn-ghost { background:#fff; color:var(--text-2); border:1.5px solid var(--border); }
.nms-btn-ghost:hover { border-color:var(--navy); color:var(--navy); }
.nms-loader { display:flex; align-items:center; justify-content:center; padding:52px 20px; gap:10px; color:var(--muted); font-size:13px; font-weight:600; }
.nms-spinner { width:20px; height:20px; border:2.5px solid var(--border); border-top-color:var(--navy); border-radius:50%; animation:nmsSpin .7s linear infinite; flex-shrink:0; }
.nms-empty { text-align:center; padding:52px 20px; color:var(--muted); }
.nms-empty i { font-size:2.5rem; display:block; margin-bottom:10px; opacity:.35; }
.nms-empty-txt { font-size:13px; font-weight:600; }
.nms-err { text-align:center; padding:36px; color:var(--red); font-size:13px; font-weight:600; }
.live-chip { display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:600; color:var(--green-d); background:var(--green-l); border:1.5px solid var(--green-b); padding:4px 10px; border-radius:20px; }
.live-dot  { width:7px; height:7px; border-radius:50%; background:var(--green); animation:nmsBlink 2s infinite; }
.nms-btn-sm { display:inline-flex; align-items:center; gap:4px; padding:4px 11px; font-size:11.5px; font-weight:700; border-radius:6px; text-decoration:none; transition:all .14s; border:1.5px solid; }
.nms-btn-sm-blue { background:var(--blue-l); color:var(--blue); border-color:var(--blue-b); }
.nms-btn-sm-blue:hover { background:var(--blue); color:#fff; text-decoration:none; }
.nms-btn-sm-navy { background:var(--navy-l); color:var(--navy); border-color:var(--navy-b); }
.nms-btn-sm-navy:hover { background:var(--navy); color:#fff; text-decoration:none; }
/* Breadcrumb */
.nms-breadcrumb { display:flex; align-items:center; gap:6px; margin-bottom:18px; font-size:12.5px; font-weight:600; color:var(--muted); flex-wrap:wrap; }
.nms-breadcrumb a { color:var(--blue); text-decoration:none; }
.nms-breadcrumb a:hover { text-decoration:underline; }
.nms-breadcrumb i { font-size:13px; }
/* Region card grid */
.region-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; margin-bottom:20px; }
.region-card { background:var(--card); border:1.5px solid var(--border); border-radius:var(--r); padding:18px 20px; box-shadow:var(--sh); cursor:pointer; transition:all .18s; text-decoration:none; display:block; }
.region-card:hover { transform:translateY(-2px); box-shadow:var(--sh-m); border-color:var(--navy-b); text-decoration:none; }
.region-card-name { font-size:15px; font-weight:800; color:var(--text); margin-bottom:12px; display:flex; align-items:center; justify-content:space-between; }
.region-card-bar { height:6px; background:#f1f5f9; border-radius:999px; overflow:hidden; margin-bottom:8px; }
.region-card-bar-fill { height:100%; border-radius:999px; transition:width .6s; }
.region-card-stats { display:flex; gap:16px; font-size:11px; font-weight:600; color:var(--muted); }
@keyframes nmsSpin  { to { transform:rotate(360deg); } }
@keyframes nmsBlink { 0%,100%{opacity:1;} 50%{opacity:.2;} }
</style>
