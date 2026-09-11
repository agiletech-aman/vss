<?php $__env->startSection('title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;0,9..40,900&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --bg:#eef0f6;--card:#ffffff;--text:#0f172a;--text-2:#475569;--muted:#94a3b8;--border:#e2e8f0;--border-2:#cbd5e1;
    --blue:#2563eb;--blue-l:#eff6ff;--blue-b:#bfdbfe;--blue-d:#1d4ed8;
    --green:#059669;--green-l:#ecfdf5;--green-b:#a7f3d0;--green-d:#047857;
    --red:#dc2626;--red-l:#fef2f2;--red-b:#fecaca;--red-d:#b91c1c;
    --orange:#d97706;--orange-l:#fffbeb;--orange-b:#fde68a;--orange-d:#b45309;
    --teal:#0d9488;--teal-l:#f0fdfa;--teal-b:#99f6e4;--teal-d:#0f766e;
    --navy:#1e293b;--navy-l:#f1f5f9;--navy-b:#94a3b8;
    --r:14px;--rs:8px;
    --sh:0 1px 3px rgba(0,0,0,.05),0 1px 2px rgba(0,0,0,.03);
    --sh-m:0 4px 12px rgba(0,0,0,.07),0 2px 4px rgba(0,0,0,.04);
    --sh-l:0 12px 32px rgba(0,0,0,.1),0 4px 8px rgba(0,0,0,.05);
}
.ud*{font-family:'DM Sans',-apple-system,sans-serif;box-sizing:border-box}.ud{background:var(--bg);padding-bottom:40px}
.card-loading{position:relative;overflow:hidden}
.card-loading-overlay{position:absolute;inset:0;z-index:20;background:rgba(255,255,255,.93);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;opacity:1;transition:opacity .35s}
.card-loading-overlay.loaded{opacity:0;pointer-events:none}
.dots-loader{display:flex;gap:7px}
.dots-loader .dot{width:8px;height:8px;border-radius:50%;animation:dotWave 1.3s ease-in-out infinite}
.dots-loader .dot:nth-child(1){background:var(--navy)}.dots-loader .dot:nth-child(2){background:var(--orange);animation-delay:.18s}.dots-loader .dot:nth-child(3){background:var(--red);animation-delay:.36s}
@keyframes dotWave{0%,60%,100%{transform:translateY(0) scale(1)}30%{transform:translateY(-10px) scale(1.25)}}
.sec-div{display:flex;align-items:center;gap:9px;margin:22px 0 14px;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.14em;color:var(--muted)}
.sec-div::after{content:'';flex:1;height:1px;background:var(--border)}.sec-div i{font-size:12px}
.sec-pill{padding:2px 9px;border-radius:20px;font-size:9px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.filter-bar{background:var(--card);border:1.5px solid var(--border);border-left:4px solid var(--blue);border-radius:var(--r);padding:16px 22px;box-shadow:var(--sh-m);margin-bottom:18px}
.filter-bar-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.filter-bar-title{font-size:14px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
.filter-bar-title i{color:var(--blue);font-size:17px}
.filter-bar-actions{display:flex;gap:8px;align-items:center}
.live-chip{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;color:var(--text-2);background:var(--green-l);border:1.5px solid var(--green-b);padding:4px 10px;border-radius:20px}
.live-dot{width:7px;height:7px;border-radius:50%;background:var(--green);animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.2}}
.fbtn{display:inline-flex;align-items:center;gap:5px;padding:6px 13px;font-size:12px;font-weight:600;border:1.5px solid var(--border);border-radius:var(--rs);background:#fff;color:var(--text-2);cursor:pointer;transition:all .16s}
.fbtn:hover{border-color:var(--blue);color:var(--blue);background:var(--blue-l)}
.fbtn.primary{background:var(--blue);color:#fff;border-color:var(--blue)}
.fbtn.primary:hover{background:var(--blue-d);transform:translateY(-1px);box-shadow:0 4px 12px rgba(37,99,235,.3)}
.fbtn:disabled{opacity:.5;cursor:not-allowed;transform:none!important}
.filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:14px;align-items:end}
.filter-item{display:flex;flex-direction:column;gap:5px}
.filter-lbl{font-size:11px;font-weight:700;color:var(--navy);display:flex;align-items:center;gap:5px}
.filter-lbl i{color:var(--muted);font-size:13px}
.filter-sel{width:100%;padding:9px 32px 9px 12px;font-size:13px;font-weight:500;font-family:'DM Sans',sans-serif;color:var(--text);background:#fff;border:1.5px solid var(--border);border-radius:var(--rs);outline:none;cursor:pointer;transition:all .16s;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center}
.filter-sel:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.filter-sel:disabled{background-color:#f9fafb;opacity:.5;cursor:not-allowed}
.map-card{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);overflow:hidden;box-shadow:var(--sh-m);margin-bottom:18px;position:relative;min-height:520px}
.map-hdr{display:flex;align-items:center;justify-content:space-between;padding:14px 22px;border-bottom:1.5px solid var(--border);background:linear-gradient(90deg,#f8fafc,#fff);gap:12px;flex-wrap:wrap}
.map-hdr-left{display:flex;align-items:center;gap:12px}
.map-hdr-icon{width:40px;height:40px;background:var(--navy);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0}
.map-title{font-size:16px;font-weight:800;color:var(--text);letter-spacing:-.2px}
.map-subtitle{font-size:11px;color:var(--muted);font-weight:500;margin-top:1px}
.map-legend{display:flex;gap:14px;align-items:center}
.map-leg{display:flex;align-items:center;gap:6px;font-size:11.5px;font-weight:600;color:var(--text-2)}
.map-dot{width:10px;height:10px;border-radius:50%;border:2.5px solid #fff;box-shadow:0 0 0 1.5px rgba(0,0,0,.12)}
.map-link{display:inline-flex;align-items:center;gap:5px;padding:6px 13px;border-radius:6px;font-size:12px;font-weight:700;background:var(--red-l);color:var(--red);border:1.5px solid var(--red-b);text-decoration:none;transition:all .16s}
.map-link:hover{background:var(--red);color:#fff;text-decoration:none}
.map-filter-row{display:none;align-items:center;gap:10px;padding:10px 22px;border-bottom:1.5px solid var(--border);background:#fff;flex-wrap:wrap}
.map-filter-sel{padding:7px 30px 7px 10px;font-size:12px;font-weight:600;font-family:'DM Sans',sans-serif;color:var(--text);background:#fff;border:1.5px solid var(--border);border-radius:8px;outline:none;cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;min-width:140px;transition:all .16s}
.map-filter-sel:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.map-filter-inp{padding:7px 12px;font-size:12px;font-weight:500;font-family:'DM Sans',sans-serif;color:var(--text);border:1.5px solid var(--border);border-radius:8px;outline:none;min-width:200px;transition:all .16s}
.map-filter-inp:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.map-filter-count{font-size:11.5px;color:var(--muted);font-weight:600;margin-left:auto}
.map-filter-reset{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;font-size:12px;font-weight:600;border:1.5px solid var(--border);border-radius:8px;background:#fff;color:var(--text-2);cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .16s}
.map-filter-reset:hover{border-color:var(--blue);color:var(--blue);background:var(--blue-l)}
#dashMap{height:440px;width:100%;background:#fff!important}
.leaflet-control-zoom{border:1.5px solid var(--border)!important;border-radius:10px!important;overflow:hidden;box-shadow:var(--sh)!important}
.leaflet-control-zoom a{width:30px!important;height:30px!important;line-height:30px!important;font-size:14px!important;color:var(--text)!important;background:#fff!important;border-bottom:1px solid var(--border)!important}
.leaflet-control-attribution{display:none!important}
.leaflet-container{background:#ffffff!important}
.leaflet-tooltip.tip-state{background:rgba(15,23,42,.85);color:#fff;border:none;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:600;pointer-events:none}
.leaflet-tooltip.tip-state::before{display:none}
.leaflet-tooltip.tip-marker{background:#fff;color:var(--text);border:1.5px solid var(--border);border-radius:12px;padding:12px 16px;box-shadow:0 8px 24px rgba(0,0,0,.12);min-width:150px}
.leaflet-tooltip.tip-marker::before{display:none}

/* ── KPI cards ── */
.kpi-row{display:grid;grid-template-columns:repeat(4,1fr);grid-auto-rows:1fr;gap:15px;margin-bottom:18px}
.kpi-card{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--sh-m);transition:transform .18s,box-shadow .18s;animation:fadeUp .38s ease both;position:relative;overflow:hidden;display:flex;flex-direction:column;cursor:pointer;min-height:0}
.kpi-card:hover{transform:translateY(-3px);box-shadow:var(--sh-l)}
.kpi-body{padding:16px 16px 14px 20px;display:flex;flex-direction:column;flex:1}
.kpi-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px}
.kpi-eye{font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;margin-bottom:3px}
.kc-blue .kpi-eye{color:var(--blue)}.kc-red .kpi-eye{color:var(--red)}.kc-orange .kpi-eye{color:var(--orange)}.kc-teal .kpi-eye{color:var(--teal)}
.kpi-name{font-size:13.5px;font-weight:800;color:var(--text);letter-spacing:-.2px}
.kpi-icon{width:40px;height:40px;border-radius:11px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:20px}
.kc-blue .kpi-icon{background:var(--blue-l);color:var(--blue)}.kc-red .kpi-icon{background:var(--red-l);color:var(--red)}.kc-orange .kpi-icon{background:var(--orange-l);color:var(--orange)}.kc-teal .kpi-icon{background:var(--teal-l);color:var(--teal)}
.cam-list{display:flex;flex-direction:column;gap:6px;margin-bottom:14px}
.cam-row{display:flex;align-items:center;justify-content:space-between;padding:8px 11px;border-radius:9px;border:1.5px solid;transition:filter .14s}.cam-row:hover{filter:brightness(.97)}
.cr-total{background:var(--blue-l);border-color:var(--blue-b)}.cr-online{background:var(--green-l);border-color:var(--green-b)}.cr-offline{background:var(--red-l);border-color:var(--red-b)}
.cr-l{display:flex;align-items:center;gap:7px}
.cr-pip{width:7px;height:7px;border-radius:50%;flex-shrink:0}
.cr-total .cr-pip{background:var(--blue);box-shadow:0 0 0 2px rgba(37,99,235,.2)}.cr-online .cr-pip{background:var(--green);box-shadow:0 0 0 2px rgba(5,150,105,.2)}.cr-offline .cr-pip{background:var(--red);box-shadow:0 0 0 2px rgba(220,38,38,.2)}
.cr-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em}
.cr-total .cr-lbl{color:var(--blue)}.cr-online .cr-lbl{color:var(--green)}.cr-offline .cr-lbl{color:var(--red)}
.cr-val{font-family:'IBM Plex Mono',monospace;font-weight:800;font-size:18px;line-height:1;flex-shrink:0}
.cr-total .cr-val{color:var(--blue)}.cr-online .cr-val{color:var(--green)}.cr-offline .cr-val{color:var(--red)}
.det-ring-row{display:flex;align-items:center;gap:12px;margin-bottom:12px}
.det-ring-wrap{position:relative;width:64px;height:64px;flex-shrink:0}.det-ring-wrap svg{transform:rotate(-90deg)}
.det-ring-inner{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none}
.det-ring-num{font-family:'IBM Plex Mono',monospace;font-weight:900;font-size:17px;line-height:1;letter-spacing:-.5px}
.kc-red .det-ring-num{color:var(--red)}.kc-orange .det-ring-num{color:var(--orange)}.kc-teal .det-ring-num{color:var(--teal)}
.det-ring-info{flex:1;min-width:0}
.det-affected-badge{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;padding:3px 8px;border-radius:20px;margin-top:5px}
.kc-red .det-affected-badge{background:var(--red-l);color:var(--red-d);border:1px solid var(--red-b)}.kc-orange .det-affected-badge{background:var(--orange-l);color:var(--orange-d);border:1px solid var(--orange-b)}.kc-teal .det-affected-badge{background:var(--teal-l);color:var(--teal-d);border:1px solid var(--teal-b)}
.det-wh-list{display:flex;flex-direction:column;gap:5px;margin-bottom:10px;flex:1}
.det-wh-row{display:flex;align-items:center;gap:7px}
.det-wh-name{width:72px;font-size:10.5px;font-weight:600;color:var(--text-2);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex-shrink:0}
.det-wh-track{flex:1;height:5px;background:#f1f5f9;border-radius:3px;overflow:hidden}
.det-wh-fill{height:100%;border-radius:3px;transition:width .5s ease}
.det-wh-val{font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:800;width:26px;text-align:right;flex-shrink:0}
.kc-red .det-wh-val{color:var(--red)}.kc-orange .det-wh-val{color:var(--orange)}.kc-teal .det-wh-val{color:var(--teal)}
.det-wh-empty{font-size:11px;color:var(--muted);font-weight:600;padding:8px 0;text-align:center;flex:1}
.kpi-foot{padding-top:10px;border-top:1.5px solid var(--border);margin-top:auto}
.kpi-link{font-size:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:gap .14s}.kpi-link:hover{gap:7px;text-decoration:none}
.kc-blue .kpi-link{color:var(--blue)}.kc-red .kpi-link{color:var(--red)}.kc-orange .kpi-link{color:var(--orange)}.kc-teal .kpi-link{color:var(--teal)}

/* ── BTS + Devices tile ── */
.kpi-row-bottom{display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:18px}
.kpi-card-wide{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--sh-m);animation:fadeUp .38s ease both;overflow:hidden}
.kpi-card-wide-hdr{padding:14px 18px 10px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.kpi-card-wide-title{font-size:13.5px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
.kpi-card-wide-desc{font-size:11px;color:var(--muted);margin-top:2px;font-weight:500}
.kpi-card-wide-body{padding:14px 18px}

/* BTS stat rows */
.bts-stat-row{display:flex;align-items:center;justify-content:space-between;padding:7px 10px;border-radius:8px;background:var(--navy-l);border:1.5px solid var(--border);margin-bottom:7px}
.bts-stat-row:last-child{margin-bottom:0}
.bts-stat-lbl{font-size:11px;font-weight:600;color:var(--text-2);display:flex;align-items:center;gap:6px}
.bts-stat-val{font-family:'IBM Plex Mono',monospace;font-size:16px;font-weight:800;color:var(--text)}

/* Device status table */
.dev-status-tbl{width:100%;border-collapse:collapse}
.dev-status-tbl thead th{font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);padding:5px 8px;border-bottom:1.5px solid var(--border);text-align:left}
.dev-status-tbl tbody td{padding:7px 8px;font-size:11.5px;border-bottom:1px solid #f0f4f8;color:var(--text);vertical-align:middle}
.dev-status-tbl tbody tr:last-child td{border-bottom:none}
.dev-status-tbl tbody tr:hover td{background:#f8fafc}
.dev-status-tbl tr.row-off td{background:#fff5f5}
.dst-ico{width:24px;height:24px;border-radius:5px;display:inline-flex;align-items:center;justify-content:center;font-size:12px;margin-right:6px;vertical-align:middle}
.dst-type{font-size:9px;padding:1px 5px;border-radius:3px;font-weight:700;border:1px solid;display:inline-flex;align-items:center}
.dst-bar{width:44px;height:4px;background:#f1f5f9;border-radius:2px;overflow:hidden;display:inline-block;vertical-align:middle;margin-right:5px}
.dst-bar-fill{height:100%;border-radius:2px}

.chart-card{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--sh-m);animation:fadeUp .38s ease both;position:relative;overflow:hidden;margin-bottom:18px}
.chart-accent{height:0;width:100%}.ca-navy{background:none}.ca-green{background:none}
.chart-inner{padding:18px 20px 20px}
.chart-ttl{font-size:14px;font-weight:800;color:var(--text);letter-spacing:-.2px;display:flex;align-items:center;gap:8px;margin-bottom:14px}.chart-ttl i{font-size:15px;color:var(--muted)}
.sack-tiles{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:16px}
.sack-tile{border-radius:10px;padding:12px 14px;border:1.5px solid}
.st-in{background:var(--orange-l);border-color:var(--orange-b)}.st-out{background:var(--navy-l);border-color:var(--navy-b)}.st-net-p{background:var(--green-l);border-color:var(--green-b)}.st-net-n{background:var(--red-l);border-color:var(--red-b)}.st-reg{background:var(--blue-l);border-color:var(--blue-b)}
.sack-tile-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px}
.st-in .sack-tile-lbl{color:var(--orange-d)}.st-out .sack-tile-lbl{color:var(--navy)}.st-net-p .sack-tile-lbl{color:var(--green-d)}.st-net-n .sack-tile-lbl{color:var(--red-d)}.st-reg .sack-tile-lbl{color:var(--blue-d)}
.sack-tile-val{font-family:'IBM Plex Mono',monospace;font-size:20px;font-weight:800;line-height:1}
.st-in .sack-tile-val{color:var(--orange-d)}.st-out .sack-tile-val{color:var(--navy)}.st-net-p .sack-tile-val{color:var(--green-d)}.st-net-n .sack-tile-val{color:var(--red-d)}.st-reg .sack-tile-val{color:var(--blue-d)}
.iot-row{display:grid;grid-template-columns:repeat(3,1fr);gap:15px;margin-bottom:18px}
.iot-card{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--sh-m);transition:transform .18s,box-shadow .18s;animation:fadeUp .38s ease both;position:relative;cursor:pointer;display:flex;flex-direction:column;overflow:hidden}
.iot-card:hover{transform:translateY(-3px);box-shadow:var(--sh-l)}
.iot-banner{height:0}
.iot-inner{padding:18px 18px 16px;display:flex;flex-direction:column;flex:1}
.iot-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px}
.iot-hdr-l{display:flex;align-items:center;gap:11px}
.iot-ico{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:21px;flex-shrink:0}
.ic-co2 .iot-ico{background:var(--red-l);color:var(--red)}.ic-ph3 .iot-ico{background:var(--orange-l);color:var(--orange)}.ic-frs .iot-ico{background:var(--navy-l);color:var(--navy)}
.iot-eye{font-size:9.5px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;margin-bottom:3px}
.ic-co2 .iot-eye{color:var(--red)}.ic-ph3 .iot-eye{color:var(--orange)}.ic-frs .iot-eye{color:var(--navy)}
.iot-name{font-size:14px;font-weight:800;color:var(--text);letter-spacing:-.2px}
.sens-badge{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;border:1.5px solid;white-space:nowrap;flex-shrink:0}
.ic-co2 .sens-badge{background:var(--red-l);color:var(--red);border-color:var(--red-b)}.ic-ph3 .sens-badge{background:var(--orange-l);color:var(--orange);border-color:var(--orange-b)}.ic-frs .sens-badge{background:var(--navy-l);color:var(--navy);border-color:var(--navy-b)}
.sev-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
.sev-pill{border-radius:10px;padding:13px 10px;text-align:center;text-decoration:none;display:block;border:1.5px solid;transition:all .18s;position:relative;overflow:hidden}
.sev-pill::before{content:'';position:absolute;inset:0;opacity:0;transition:opacity .18s;border-radius:8px}
.sev-pill:hover::before{opacity:1}.sev-pill:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,.12);text-decoration:none}
.sp-severe{background:var(--orange-l);border-color:var(--orange-b)}.sp-severe::before{background:var(--orange)}
.sp-critical{background:var(--red-l);border-color:var(--red-b)}.sp-critical::before{background:var(--red)}
.sp-frs{background:var(--navy-l);border-color:var(--navy-b);grid-column:1/-1;padding:16px}.sp-frs::before{background:var(--navy)}
.sev-tag{font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;position:relative;z-index:1;transition:color .18s}
.sp-severe .sev-tag{color:var(--orange-d)}.sp-critical .sev-tag{color:var(--red-d)}.sp-frs .sev-tag{color:var(--navy)}.sev-pill:hover .sev-tag{color:rgba(255,255,255,.75)}
.sev-num{font-family:'IBM Plex Mono',monospace;font-weight:800;font-size:30px;line-height:1;letter-spacing:-1px;position:relative;z-index:1;transition:color .18s}
.sp-frs .sev-num{font-size:40px}.sp-severe .sev-num{color:var(--orange-d)}.sp-critical .sev-num{color:var(--red-d)}.sp-frs .sev-num{color:var(--navy)}.sev-pill:hover .sev-num{color:#fff}
.iot-foot{margin-top:auto;padding-top:11px;border-top:1.5px solid var(--border)}
.iot-lnk{font-size:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:gap .14s}.iot-lnk:hover{gap:7px;text-decoration:none}
.ic-co2 .iot-lnk{color:var(--red)}.ic-ph3 .iot-lnk{color:var(--orange)}.ic-frs .iot-lnk{color:var(--navy)}
.gas-w{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--sh-m);margin-bottom:18px;animation:fadeUp .38s ease both;overflow:hidden;position:relative}
.gas-accent{height:0;background:none}.gas-inner{padding:18px 20px 20px}
.gas-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px}
.gas-ttl{font-size:14px;font-weight:800;color:var(--text);letter-spacing:-.2px;display:flex;align-items:center;gap:8px;margin:0}.gas-ttl i{font-size:15px;color:#6366f1}
.gas-tabs{display:flex;background:var(--navy-l);border:1.5px solid var(--border);border-radius:8px;padding:3px;gap:3px}
.gas-tab-btn{padding:5px 16px;border-radius:6px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:transparent;color:var(--muted);font-family:'DM Sans',sans-serif;transition:all .18s}
.gas-tab-btn.co2-active{background:var(--red);color:#fff;box-shadow:0 2px 8px rgba(220,38,38,.3)}.gas-tab-btn.ph3-active{background:var(--orange);color:#fff;box-shadow:0 2px 8px rgba(217,119,6,.3)}
.gas-view-row{display:flex;gap:6px;margin-bottom:16px}
.gas-view-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 13px;font-size:12px;font-weight:600;border:1.5px solid var(--border);border-radius:var(--rs);background:#fff;color:var(--text-2);cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .16s}
.gas-view-btn.gas-active{background:var(--navy);color:#fff;border-color:var(--navy)}
.gas-stat-row{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:16px}
.gas-stat-pill{border-radius:10px;padding:12px 14px;border:1.5px solid}
.gsp-online{background:var(--blue-l);border-color:var(--blue-b)}.gsp-offline{background:var(--navy-l);border-color:var(--navy-b)}.gsp-normal{background:var(--green-l);border-color:var(--green-b)}.gsp-severe{background:var(--orange-l);border-color:var(--orange-b)}.gsp-critical{background:var(--red-l);border-color:var(--red-b)}
.gas-stat-lbl{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px}
.gsp-online .gas-stat-lbl{color:var(--blue-d)}.gsp-offline .gas-stat-lbl{color:var(--navy)}.gsp-normal .gas-stat-lbl{color:var(--green-d)}.gsp-severe .gas-stat-lbl{color:var(--orange-d)}.gsp-critical .gas-stat-lbl{color:var(--red-d)}
.gas-stat-val{font-family:'IBM Plex Mono',monospace;font-size:20px;font-weight:800;line-height:1}
.gsp-online .gas-stat-val{color:var(--blue-d)}.gsp-offline .gas-stat-val{color:var(--navy)}.gsp-normal .gas-stat-val{color:var(--green-d)}.gsp-severe .gas-stat-val{color:var(--orange-d)}.gsp-critical .gas-stat-val{color:var(--red-d)}
.gas-charts-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:4px}
.gas-chart-box h6{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin:0 0 8px;text-align:center}
.gas-chart-wrap{height:220px;position:relative}
.gas-loc-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;flex-wrap:wrap;gap:8px}
.gas-loc-count{font-size:11px;font-weight:700;color:var(--muted)}
.gas-search{height:36px;border:1.5px solid var(--border);border-radius:var(--rs);padding:0 12px;font-size:12px;font-family:'DM Sans',sans-serif;background:var(--navy-l);color:var(--text);min-width:200px;transition:all .16s}
.gas-search:focus{outline:none;border-color:#6366f1;background:#fff;box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.gas-loc-wrap{max-height:380px;overflow-y:auto;border:1.5px solid var(--border);border-radius:var(--rs)}
.gas-tbl{width:100%;border-collapse:collapse}
.gas-tbl thead th{background:#f8fafc;color:var(--muted);font-size:9.5px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;padding:10px 14px;border-bottom:1.5px solid var(--border);text-align:left;white-space:nowrap;position:sticky;top:0;z-index:1}
.gas-tbl tbody td{padding:11px 14px;font-size:12.5px;font-weight:500;border-bottom:1px solid #f0f4f8;color:var(--text);vertical-align:middle}
.gas-tbl tbody tr:last-child td{border-bottom:none}.gas-tbl tbody tr:hover{background:#f8fafc}
.gas-tbl .loc-name{font-weight:700;color:var(--text);font-size:13px}.gas-tbl .loc-state{font-size:10.5px;color:var(--muted);margin-top:1px}
.gsev{display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;border:1.5px solid}
.gsev-normal{background:var(--green-l);color:var(--green-d);border-color:var(--green-b)}.gsev-severe{background:var(--orange-l);color:var(--orange-d);border-color:var(--orange-b)}.gsev-critical{background:var(--red-l);color:var(--red-d);border-color:var(--red-b)}
.gas-loading-overlay{display:flex;align-items:center;justify-content:center;padding:52px 24px;gap:10px;color:var(--muted);font-size:13px;font-weight:600}
.gas-spinner{width:18px;height:18px;border:2.5px solid var(--border);border-top-color:#6366f1;border-radius:50%;animation:spin .7s linear infinite}
.gas-err{text-align:center;padding:40px 20px;color:var(--red);font-size:13px;font-weight:600}
.tbl-card{background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);overflow:hidden;box-shadow:var(--sh-m);margin-bottom:24px;position:relative}
.tbl-hdr{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1.5px solid var(--border);background:linear-gradient(90deg,#f8fafc,#fff)}
.tbl-hdr-title{font-size:14px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}.tbl-hdr-title i{color:var(--muted)}
.reg-tbl{width:100%;border-collapse:collapse}
.reg-tbl thead th{padding:11px 18px;font-size:9.5px;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;background:#f8fafc;border-bottom:1.5px solid var(--border);text-align:left;white-space:nowrap}
.reg-tbl tbody tr{border-bottom:1px solid #f0f4f8;transition:background .1s}.reg-tbl tbody tr:last-child{border-bottom:none}.reg-tbl tbody tr:hover{background:#f8fafc}
.reg-tbl tbody td{padding:12px 18px;font-size:13px;color:var(--text)}
.t-m{font-family:'IBM Plex Mono',monospace;font-weight:700;font-size:12.5px}.t-r{color:var(--red)}.t-g{color:var(--green)}.t-n{font-weight:800;font-size:13.5px}
.pct-bar{display:flex;align-items:center;gap:8px}.pct-track{width:68px;height:6px;background:#e9eef5;border-radius:3px;overflow:hidden}.pct-fill{height:100%;border-radius:3px;transition:width .6s ease}
.sbadge{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;border:1.5px solid}
.sb-ok{background:var(--green-l);color:var(--green-d);border-color:var(--green-b)}.sb-alert{background:var(--red-l);color:var(--red-d);border-color:var(--red-b)}.sb-dot{width:5px;height:5px;border-radius:50%;background:currentColor}
.view-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:var(--blue-l);color:var(--blue);border-radius:7px;font-size:11.5px;font-weight:700;text-decoration:none;transition:all .16s;border:1.5px solid var(--blue-b)}.view-btn:hover{background:var(--blue);color:#fff;text-decoration:none}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
@keyframes spin{to{transform:rotate(360deg)}}
@media(max-width:1200px){.kpi-row{grid-template-columns:repeat(2,1fr)}.kpi-row-bottom{grid-template-columns:1fr}.iot-row{grid-template-columns:1fr}.filter-grid{grid-template-columns:1fr 1fr}.sack-tiles{grid-template-columns:repeat(2,1fr)}.gas-stat-row{grid-template-columns:repeat(3,1fr)}.gas-charts-row{grid-template-columns:1fr}}
@media(max-width:640px){.kpi-row{grid-template-columns:1fr}.filter-grid{grid-template-columns:1fr}.sack-tiles{grid-template-columns:1fr 1fr}.gas-stat-row{grid-template-columns:repeat(2,1fr)}.gas-search{min-width:140px}}
</style>

<div class="ud">


<style>
.nms-strip{margin-bottom:18px}
.nms-strip-cells{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}
.nms-cell{background:linear-gradient(135deg,#ffffff 0%,var(--cell-bg,#f1f5f9) 100%);border:1.5px solid var(--cell-accent,#cbd5e1);border-opacity:.3;border-radius:12px;padding:16px 17px;position:relative;cursor:pointer;transition:transform .15s,box-shadow .15s;display:flex;flex-direction:column;box-shadow:0 1px 3px rgba(0,0,0,.04);min-width:0}
.nms-cell:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.09);background:linear-gradient(135deg,#ffffff 0%,var(--cell-bg,#f1f5f9) 60%)}
.nms-cell-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;gap:6px}
.nms-cell-top-l{display:flex;align-items:center;gap:9px;min-width:0;flex:1}
.nms-cell-ico{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;background:var(--cell-bg,#f1f5f9);color:var(--cell-accent,#64748b)}
.nms-cell-lbl{font-size:11.5px;font-weight:900;text-transform:uppercase;letter-spacing:.05em;color:var(--text);line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;min-width:0;-webkit-text-stroke:.3px currentColor}
.nms-cell-arrow{font-size:13px;color:var(--border-2);flex-shrink:0;transition:transform .15s,color .15s;margin-top:2px}
.nms-cell:hover .nms-cell-arrow{transform:translateX(2px);color:var(--cell-accent,#94a3b8)}
.nms-cell-val-row{display:flex;align-items:baseline;gap:6px;margin-bottom:8px}
.nms-cell-val{font-family:'IBM Plex Mono',monospace;font-size:30px;font-weight:800;line-height:1;color:var(--text)}
.nms-cell-statdot{width:7px;height:7px;border-radius:50%;flex-shrink:0;margin-bottom:3px}
.nms-cell-sub{font-size:11.5px;color:var(--muted);font-weight:600;min-height:15px;margin-bottom:10px;overflow-wrap:break-word}
.nms-cell-bar-track{display:none!important;height:5px;background:#eef0f4;border-radius:3px;overflow:hidden;margin-top:auto}
.nms-cell-bar-fill{height:100%;border-radius:3px;transition:width .6s ease;background:var(--cell-accent,#1a73e8)}
/* shimmer skeleton */
@keyframes shimmer{0%{background-position:-400px 0}100%{background-position:400px 0}}
.skel{display:inline-block;border-radius:4px;background:linear-gradient(90deg,#f1f5f9 25%,#e2e8f0 50%,#f1f5f9 75%);background-size:400px 100%;animation:shimmer 1.4s infinite;color:transparent!important}
.skel-num{height:26px;width:52px}
.skel-sub{height:10px;width:90px;margin-bottom:10px}
@media(max-width:1100px){.nms-strip-cells{grid-template-columns:repeat(3,1fr)}}
@media(max-width:680px){.nms-strip-cells{grid-template-columns:repeat(2,1fr)}}
@media(max-width:420px){.nms-strip-cells{grid-template-columns:1fr}}
</style>

<div class="nms-strip">
    <div class="nms-strip-cells" id="nmsStripCells">
        <div class="nms-cell" style="--cell-accent:#2563eb;--cell-bg:#eff6ff" onclick="openKpiModal('regions')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-map-pin-2-line"></i></div><div class="nms-cell-lbl">Regions</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-regions"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-regions-sub"></div>

        </div>
        <div class="nms-cell" style="--cell-accent:#7c3aed;--cell-bg:#f5f3ff" onclick="openKpiModal('warehouses')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-building-4-line"></i></div><div class="nms-cell-lbl">Warehouses</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-warehouses"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-warehouses-sub"></div>

        </div>
        <div class="nms-cell" style="--cell-accent:#0d9488;--cell-bg:#f0fdfa" onclick="openKpiModal('nvr')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-hard-drive-2-line"></i></div><div class="nms-cell-lbl">NVR</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-nvr-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-nvr-on"></div>
            <div class="nms-cell-bar-track" style="display:none"><div class="nms-cell-bar-fill" id="sc-nvr-total-bar" style="width:0%"></div></div>
        </div>
        <div class="nms-cell" style="--cell-accent:#4f46e5;--cell-bg:#eef2ff" onclick="openKpiModal('cam')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-camera-line"></i></div><div class="nms-cell-lbl">Cameras</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-cam-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-cam-on"></div>
            <div class="nms-cell-bar-track" style="display:none"><div class="nms-cell-bar-fill" id="sc-cam-total-bar" style="width:0%"></div></div>
        </div>
        <div class="nms-cell" style="--cell-accent:#059669;--cell-bg:#ecfdf5" onclick="openKpiModal('bts')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-router-line"></i></div><div class="nms-cell-lbl">BTS<span style="display:block;font-weight:600;font-size:9px;text-transform:none;letter-spacing:0;color:var(--muted);margin-top:1px">Base Transceiver Station</span></div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-bts-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-bts-on"></div>
            <div class="nms-cell-bar-track" style="display:none"><div class="nms-cell-bar-fill" id="sc-bts-total-bar" style="width:0%"></div></div>
        </div>
        <div class="nms-cell" style="--cell-accent:#0891b2;--cell-bg:#ecfeff" onclick="openKpiModal('cpe')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-wifi-line"></i></div><div class="nms-cell-lbl">CPE<span style="display:block;font-weight:600;font-size:9px;text-transform:none;letter-spacing:0;color:var(--muted);margin-top:1px">Customer Premises Equipment</span></div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-cpe-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-cpe-sub"></div>

        </div>
        <div class="nms-cell" style="--cell-accent:#7c3aed;--cell-bg:#ede9fe" onclick="openKpiModal('ws')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-cpu-line"></i></div><div class="nms-cell-lbl">Workstation</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-ws-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-ws-on"></div>
            <div class="nms-cell-bar-track" style="display:none"><div class="nms-cell-bar-fill" id="sc-ws-total-bar" style="width:0%"></div></div>
        </div>
        <div class="nms-cell" style="--cell-accent:#d97706;--cell-bg:#fffbeb" onclick="openKpiModal('epc')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-computer-line"></i></div><div class="nms-cell-lbl">Embedded PC</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-epc-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-epc-on"></div>
            <div class="nms-cell-bar-track" style="display:none"><div class="nms-cell-bar-fill" id="sc-epc-total-bar" style="width:0%"></div></div>
        </div>
        <div class="nms-cell" style="--cell-accent:#dc2626;--cell-bg:#fef2f2" onclick="openKpiModal('co2')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-temp-cold-line"></i></div><div class="nms-cell-lbl">CO₂ Sensors</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-co2-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-co2-on"></div>

        </div>
        <div class="nms-cell" style="--cell-accent:#ea580c;--cell-bg:#fff7ed" onclick="openKpiModal('ph3')">
            <div class="nms-cell-top">
                <div class="nms-cell-top-l"><div class="nms-cell-ico"><i class="ri-flask-line"></i></div><div class="nms-cell-lbl">PH₃ Sensors</div></div>
                <i class="ri-arrow-right-s-line nms-cell-arrow"></i>
            </div>
            <div class="nms-cell-val skel skel-num" id="sc-ph3-total"></div>
            <div class="nms-cell-sub skel skel-sub" id="sc-ph3-on"></div>

        </div>

    </div>
    <!-- <div class="nms-strip-foot">
        <div class="nms-strip-label">
            <span class="live-dot"></span>
            <span id="lastUpdated">Live</span>
            <span style="color:var(--border-2)">·</span>
            <span>Smart Warehouse — Unified Dashboard</span>
        </div>
        <button class="fbtn" id="refreshBtn" style="padding:4px 10px;font-size:11px;height:28px"><i class="ri-refresh-line"></i> Refresh</button>
    </div> -->
</div>


<div class="sec-div"><i class="ri-router-line"></i> Network Health <span class="sec-pill" style="background:var(--red);color:#fff;">LIVE NMS</span></div>
<div class="map-card card-loading" data-card="map">
    <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
    <div class="map-hdr">
        <div class="map-hdr-left">
            <div class="map-hdr-icon"><i class="ri-global-line"></i></div>
            <div><div class="map-title">Health Monitoring System</div><div class="map-subtitle">Live warehouse status based on average camera uptime, updated in real time</div></div>
        </div>
        <div class="map-legend">
            <div class="map-leg"><span class="map-dot" style="background:#10b981;"></span> Healthy <span style="color:var(--muted);font-weight:500">≥80%</span></div>
            <div class="map-leg"><span class="map-dot" style="background:#f59e0b;"></span> Partial <span style="color:var(--muted);font-weight:500">40–79%</span></div>
            <div class="map-leg"><span class="map-dot" style="background:#ef4444;"></span> Down <span style="color:var(--muted);font-weight:500">&lt;40%</span></div>
        </div>
        <a href="<?php echo e(route('nms.pages.map')); ?>" class="map-link">Full Map <i class="ri-arrow-right-up-line"></i></a>
    </div>
    <div class="map-filter-row" id="dashMapControls">
        <select class="map-filter-sel" id="dashMapFilter">
            <option value="">All</option>
            <option value="healthy">Healthy only</option>
            <option value="partial">Partial only</option>
            <option value="down">Down only</option>
        </select>
        <input type="text" class="map-filter-inp" id="dashMapSearch" placeholder="Search warehouse…">
        <span id="dashMapCount" class="map-filter-count"></span>
        <button class="map-filter-reset" id="dashMapReset" type="button"><i class="ri-refresh-line"></i> Reset</button>
    </div>
    <div id="dashMap"></div>
</div>


<div class="sec-div"><i class="ri-pulse-line"></i>AI Detection Overview</div>
<div class="kpi-row">
    <div class="kpi-card kc-blue card-loading" data-card="frs2" style="animation-delay:.00s;cursor:pointer" onclick="window.location.href='<?php echo e(route('frs.logs')); ?>'">
        <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        <div class="kpi-body">
            <div class="kpi-hdr">
                <div>
                    <div class="kpi-eye">FRS System</div>
                    <div class="kpi-name">Face Recognition</div>
                    <div style="font-size:10.5px;color:var(--muted);margin-top:2px;font-weight:500">Unidentified faces detected across warehouses</div>
                </div>
                <div class="kpi-icon" style="background:var(--navy-l);color:var(--navy)"><i class="ri-shield-user-line"></i></div>
            </div>
            <div class="cam-list">
                <div class="cam-row cr-total" style="background:var(--navy-l);border-color:var(--navy-b)">
                    <div class="cr-l"><span class="cr-pip" style="background:var(--navy)"></span><span class="cr-lbl" style="color:var(--navy)">Unknown Faces</span></div>
                    <span class="cr-val" style="color:var(--navy)" data-stat="frsUnknown">—</span>
                </div>

            </div>
            <div class="kpi-foot"><a href="<?php echo e(route('frs.logs')); ?>" class="kpi-link" style="color:var(--navy)" onclick="event.stopPropagation();">View FRS Logs <i class="ri-arrow-right-line"></i></a></div>
        </div>
    </div>
    <div class="kpi-card kc-red card-loading" data-card="fire" onclick="window.location.href='<?php echo e(route('alerts.fire')); ?>'"" style="animation-delay:.07s">
        <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        <div class="kpi-body">
            <div class="kpi-hdr">
                <div>
                    <div class="kpi-eye">AI Camera Detection</div>
                    <div class="kpi-name">Fire Detections</div>
                    <div style="font-size:10.5px;color:var(--muted);margin-top:2px;font-weight:500">Fire events detected by AI camera analysis</div>
                </div>
                <div class="kpi-icon"><i class="ri-fire-line"></i></div>
            </div>
            <div class="det-ring-row">
                <div class="det-ring-wrap"><svg width="64" height="64" viewBox="0 0 64 64"><circle cx="32" cy="32" r="26" fill="none" stroke="#f1f5f9" stroke-width="6"/><circle cx="32" cy="32" r="26" fill="none" stroke="#dc2626" stroke-width="6" stroke-dasharray="163.4" id="fireRingFill" stroke-dashoffset="0" stroke-linecap="round"/></svg><div class="det-ring-inner"><div class="det-ring-num" data-stat="fireDetected">—</div></div></div>
                <div class="det-ring-info"><div class="det-affected-badge"><i class="ri-building-2-line" style="font-size:11px;"></i><span data-stat="fireWarehouses">—</span> warehouses</div></div>
            </div>
            <div class="det-wh-list" id="fireWhList"><div class="det-wh-empty">Loading...</div></div>
            <div class="kpi-foot"><a href="<?php echo e(route('alerts.fire')); ?>" class="kpi-link" onclick="event.stopPropagation();">View Reports <i class="ri-arrow-right-line"></i></a></div>
        </div>
    </div>
    <div class="kpi-card kc-orange card-loading" data-card="smoke" onclick="window.location.href='<?php echo e(route('alerts.smoke')); ?>'"" style="animation-delay:.14s">
        <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        <div class="kpi-body">
            <div class="kpi-hdr">
                <div>
                    <div class="kpi-eye">AI Camera Detection</div>
                    <div class="kpi-name">Smoke Detections</div>
                    <div style="font-size:10.5px;color:var(--muted);margin-top:2px;font-weight:500">Smoke events detected by AI camera analysis</div>
                </div>
                <div class="kpi-icon"><i class="ri-mist-line"></i></div>
            </div>
            <div class="det-ring-row">
                <div class="det-ring-wrap"><svg width="64" height="64" viewBox="0 0 64 64"><circle cx="32" cy="32" r="26" fill="none" stroke="#f1f5f9" stroke-width="6"/><circle cx="32" cy="32" r="26" fill="none" stroke="#d97706" stroke-width="6" stroke-dasharray="163.4" id="smokeRingFill" stroke-dashoffset="0" stroke-linecap="round"/></svg><div class="det-ring-inner"><div class="det-ring-num" data-stat="smokeDetected">—</div></div></div>
                <div class="det-ring-info"><div class="det-affected-badge"><i class="ri-building-2-line" style="font-size:11px;"></i><span data-stat="smokeWarehouses">—</span> warehouses</div></div>
            </div>
            <div class="det-wh-list" id="smokeWhList"><div class="det-wh-empty">Loading...</div></div>
            <div class="kpi-foot"><a href="<?php echo e(route('alerts.smoke')); ?>" class="kpi-link" onclick="event.stopPropagation();">View Reports <i class="ri-arrow-right-line"></i></a></div>
        </div>
    </div>
    <div class="kpi-card kc-teal card-loading" data-card="rodent" onclick="window.location.href='<?php echo e(route('alerts.rodent')); ?>'"" style="animation-delay:.21s">
        <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        <div class="kpi-body">
            <div class="kpi-hdr">
                <div>
                    <div class="kpi-eye">AI Camera Detection</div>
                    <div class="kpi-name">Rodent Detections</div>
                    <div style="font-size:10.5px;color:var(--muted);margin-top:2px;font-weight:500">Rodent activity detected by AI camera analysis</div>
                </div>
                <div class="kpi-icon"><i class="ri-bug-2-line"></i></div>
            </div>
            <div class="det-ring-row">
                <div class="det-ring-wrap"><svg width="64" height="64" viewBox="0 0 64 64"><circle cx="32" cy="32" r="26" fill="none" stroke="#f1f5f9" stroke-width="6"/><circle cx="32" cy="32" r="26" fill="none" stroke="#0d9488" stroke-width="6" stroke-dasharray="163.4" id="rodentRingFill" stroke-dashoffset="0" stroke-linecap="round"/></svg><div class="det-ring-inner"><div class="det-ring-num" data-stat="rodentDetected">—</div></div></div>
                <div class="det-ring-info"><div class="det-affected-badge"><i class="ri-building-2-line" style="font-size:11px;"></i><span data-stat="rodentWarehouses">—</span> warehouses</div></div>
            </div>
            <div class="det-wh-list" id="rodentWhList"><div class="det-wh-empty">Loading...</div></div>
            <div class="kpi-foot"><a href="<?php echo e(route('alerts.rodent')); ?>" class="kpi-link" onclick="event.stopPropagation();">View Reports <i class="ri-arrow-right-line"></i></a></div>
        </div>
    </div>
</div>


<!-- <div class="kpi-row-bottom">
    
    <div class="kpi-card-wide card-loading" data-card="bts" style="animation-delay:.25s">
        <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        <div class="kpi-card-wide-hdr">
            <div>
                <div class="kpi-card-wide-title"><i class="ri-router-line" style="color:var(--green)"></i> BTS — Base Transceiver Station</div>
                <div class="kpi-card-wide-desc">Wireless point-to-point radio links providing last-mile internet connectivity to warehouse NVRs and IP cameras</div>
            </div>
            <div style="width:38px;height:38px;border-radius:10px;background:var(--green-l);border:1.5px solid var(--green-b);display:flex;align-items:center;justify-content:center;font-size:19px;color:var(--green);flex-shrink:0">
                <i class="ri-router-line"></i>
            </div>
        </div>
        <div class="kpi-card-wide-body">
            <div class="bts-stat-row">
                <div class="bts-stat-lbl"><i class="ri-radio-line" style="font-size:14px;color:var(--green)"></i> Total BTS Radios</div>
                <div class="bts-stat-val" id="btsTotalRadios">—</div>
            </div>
            <div class="bts-stat-row">
                <div class="bts-stat-lbl"><i class="ri-check-line" style="font-size:14px;color:var(--green)"></i> Online Radios</div>
                <div class="bts-stat-val" style="color:var(--green)" id="btsOnlineRadios">—</div>
            </div>
            <div class="bts-stat-row">
                <div class="bts-stat-lbl"><i class="ri-wifi-line" style="font-size:14px;color:var(--blue)"></i> Connected Clients</div>
                <div class="bts-stat-val" style="color:#1a73e8" id="btsTotalClients">—</div>
            </div>
            <div class="bts-stat-row">
                <div class="bts-stat-lbl"><i class="ri-close-circle-line" style="font-size:14px;color:var(--red)"></i> Offline Radios</div>
                <div class="bts-stat-val" style="color:var(--red)" id="btsOfflineRadios">—</div>
            </div>
            <div style="margin-top:12px;padding:10px 12px;background:var(--blue-l);border:1.5px solid var(--blue-b);border-radius:8px;">
                <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--blue-d);margin-bottom:4px">How it works</div>
                <div style="font-size:11.5px;color:var(--blue-d);line-height:1.5">Each BTS radio at a warehouse creates a wireless backhaul link. Cameras connect through NVRs which route traffic via BTS to the central monitoring server.</div>
            </div>
        </div>
    </div>

    
    <div class="kpi-card-wide card-loading" data-card="devices" style="animation-delay:.30s">
        <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
        <div class="kpi-card-wide-hdr">
            <div>
                <div class="kpi-card-wide-title"><i class="ri-server-line" style="color:var(--navy)"></i> Installed Devices</div>
                <div class="kpi-card-wide-desc">All device types deployed across warehouses — cameras, NVRs, BTS radios, workstations and storage</div>
            </div>
            <div style="width:38px;height:38px;border-radius:10px;background:var(--navy-l);border:1.5px solid var(--navy-b);display:flex;align-items:center;justify-content:center;font-size:19px;color:var(--navy);flex-shrink:0">
                <i class="ri-server-line"></i>
            </div>
        </div>
        <div class="kpi-card-wide-body">
            <table class="dev-status-tbl">
                <thead>
                    <tr>
                        <th>Device Type</th>
                        <th>Total</th>
                        <th>Online</th>
                        <th>Offline</th>
                        <th>Health</th>
                    </tr>
                </thead>
                <tbody id="devTypeTableBody">
                    <tr><td colspan="5" style="text-align:center;padding:20px;color:var(--muted);font-size:12px">Loading device data…</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div> -->


<div class="chart-card card-loading" data-card="barChart" style="animation-delay:.28s">
    <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
    <div class="chart-accent ca-navy"></div>
    <div class="chart-inner">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;gap:10px;flex-wrap:wrap;">
            <div>
                <div class="chart-ttl" style="margin-bottom:2px;"><i class="ri-bar-chart-box-line"></i><span id="barChartTitle">Top Regions — Offline Cameras</span></div>
                <div id="barChartBreadcrumb" style="display:none;font-size:11px;color:var(--muted);font-weight:600;padding-left:23px;"><i class="ri-map-pin-2-line" style="font-size:11px;"></i><span id="barChartRegionName"></span><span style="margin:0 4px;">›</span> Warehouse Breakdown</div>
            </div>
            <button id="barChartBackBtn" style="display:none;align-items:center;gap:5px;padding:5px 12px;font-size:12px;font-weight:700;background:var(--navy-l);color:var(--navy);border:1.5px solid var(--navy-b);border-radius:7px;cursor:pointer;transition:all .16s;" onmouseover="this.style.background='var(--navy)';this.style.color='#fff';" onmouseout="this.style.background='var(--navy-l)';this.style.color='var(--navy)';"><i class="ri-arrow-left-line"></i> All Regions</button>
        </div>
        <div id="barChartHint" style="font-size:10.5px;color:var(--muted);font-weight:600;margin-bottom:8px;display:flex;align-items:center;gap:5px;"><i class="ri-cursor-line"></i> Click any bar to drill into warehouse breakdown</div>
        <div style="overflow-x:auto;"><div id="regionBarChartWrap" style="height:300px;min-width:900px;"><canvas id="regionBarChart"></canvas></div></div>
    </div>
</div>


<div class="sec-div"><i class="ri-shopping-bag-3-line"></i> Region-wise Bag Movement</div>
<div class="chart-card card-loading" data-card="regionSack" style="animation-delay:.34s;">
    <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
    <div class="chart-accent ca-green"></div>
    <div class="chart-inner">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px;">
            <div>
                <div class="chart-ttl" style="margin-bottom:0;" id="sackChartTitle"><i class="ri-bar-chart-grouped-line"></i> Region-wise Bag Movement</div>
                <div id="sackBreadcrumb" style="display:none;font-size:11px;color:var(--muted);font-weight:600;padding-top:4px"><i class="ri-map-pin-2-line" style="font-size:11px"></i> <span id="sackBreadRegion"></span> › Warehouse Breakdown</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <button id="sackBackBtn" onclick="sackGoBack()" style="display:none;align-items:center;gap:4px;padding:5px 12px;border:1.5px solid var(--border);border-radius:8px;background:#fff;font-size:11px;font-weight:700;color:var(--muted);cursor:pointer"><i class="ri-arrow-left-s-line"></i> Back</button>
                <div id="regionSackStatus" style="font-size:10.5px;color:var(--muted);font-weight:600;display:flex;align-items:center;gap:4px;"><i class="ri-loader-4-line" style="animation:spin 1s linear infinite;"></i> Loading…</div>
            </div>
        </div>
        <div class="sack-tiles" id="sackTiles">
            <div class="sack-tile st-in"><div class="sack-tile-lbl">Total IN (All Time)</div><div class="sack-tile-val" id="sackTotalDayIn">—</div></div>
            <div class="sack-tile st-out"><div class="sack-tile-lbl">Total OUT (All Time)</div><div class="sack-tile-val" id="sackTotalDayOut">—</div></div>
            <div class="sack-tile st-net-p" id="sackNetTile"><div class="sack-tile-lbl">Net Movement</div><div class="sack-tile-val" id="sackNetDay">—</div></div>
            <div class="sack-tile st-reg"><div class="sack-tile-lbl">Active Regions</div><div class="sack-tile-val" id="sackActiveRegions">—</div></div>
        </div>
        <div style="height:380px;"><canvas id="regionSackChart"></canvas></div>
    </div>
</div>


<div class="sec-div"><i class="ri-bubble-chart-fill"></i> IoT Gas Monitoring <span class="sec-pill" style="background:#6366f1;color:#fff;">LIVE</span></div>
<div class="gas-w" id="gasWidget">
    <div class="gas-accent"></div>
    <div class="gas-inner">
        <div class="gas-hdr">
            <h5 class="gas-ttl"><i class="ri-bubble-chart-fill"></i> CO₂ &amp; PH₃ Monitoring</h5>
            <div class="gas-tabs">
                <button class="gas-tab-btn co2-active" id="gTabCO2" onclick="gSwitchGas('co2')">CO₂</button>
                <button class="gas-tab-btn" id="gTabPH3" onclick="gSwitchGas('ph3')">PH₃</button>
            </div>
        </div>
        <div class="gas-view-row">
            <button class="gas-view-btn gas-active" id="gBtnOverall" onclick="gShowView('overall')"><i class="ri-global-line"></i> Overall</button>
            <button class="gas-view-btn" id="gBtnLocation" onclick="gShowView('location')"><i class="ri-map-pin-line"></i> Location Wise</button>
        </div>
        <div id="gLoading" class="gas-loading-overlay"><div class="gas-spinner"></div> Fetching sensor data…</div>
        <div id="gError" class="gas-err" style="display:none;"><i class="ri-error-warning-line" style="font-size:22px;display:block;margin-bottom:6px;"></i>Failed to load CO₂ / PH₃ data.</div>
        <div id="gOverallView" style="display:none;">
            <div class="gas-stat-row">
                <div class="gas-stat-pill gsp-online"><div class="gas-stat-lbl" id="gLblOnline">Online CO₂</div><div class="gas-stat-val" id="gValOnline">—</div></div>
                <div class="gas-stat-pill gsp-offline"><div class="gas-stat-lbl" id="gLblOffline">Offline CO₂</div><div class="gas-stat-val" id="gValOffline">—</div></div>
                <div class="gas-stat-pill gsp-normal"><div class="gas-stat-lbl" id="gLblNormal">Normal</div><div class="gas-stat-val" id="gValNormal">—</div></div>
                <div class="gas-stat-pill gsp-severe"><div class="gas-stat-lbl">Severe</div><div class="gas-stat-val" id="gValSevere">—</div></div>
                <div class="gas-stat-pill gsp-critical"><div class="gas-stat-lbl">Critical</div><div class="gas-stat-val" id="gValCritical">—</div></div>
            </div>
            <div class="gas-charts-row">
                <div class="gas-chart-box"><h6 id="gChartStatusLbl">CO₂ Device Status</h6><div class="gas-chart-wrap"><canvas id="gStatusChart"></canvas></div></div>
                <div class="gas-chart-box"><h6 id="gChartSevLbl">CO₂ Alert Severity</h6><div class="gas-chart-wrap"><canvas id="gSeverityChart"></canvas></div></div>
            </div>
        </div>
        <div id="gLocationView" style="display:none;">
            <div class="gas-loc-hdr">
                <span class="gas-loc-count" id="gLocCount"></span>
                <input type="text" class="gas-search" id="gLocSearch" placeholder="Search location or state…" oninput="gFilterTable(this.value)">
            </div>
            <div class="gas-loc-wrap">
                <table class="gas-tbl">
                    <thead><tr><th>Location</th><th>Devices</th><th>Online</th><th>Normal</th><th>Severe</th><th>Critical</th></tr></thead>
                    <tbody id="gLocBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="sec-div"><i class="ri-building-2-line"></i> Region-wise Metrics</div>
<div class="tbl-card card-loading" data-card="table">
    <div class="card-loading-overlay"><div class="dots-loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>
    <div class="tbl-hdr">
        <div class="tbl-hdr-title"><i class="ri-table-2"></i> Aggregated Regional Data</div>
        <span style="font-size:11px;color:var(--muted);font-weight:600;" id="tableRegionCount"></span>
    </div>
    <div style="overflow-x:auto;">
        <table class="reg-tbl">
            <thead><tr><th>Region</th><th>NVRs</th><th>Total Cameras</th><th>Online</th><th>Offline</th><th>Health</th><th>Status</th><th style="text-align:center;">Action</th></tr></thead>
            <tbody id="regionTableBody"><tr><td colspan="8" style="text-align:center;padding:36px;color:var(--muted);">Loading data…</td></tr></tbody>
        </table>
    </div>
</div>


<div id="kpiModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.55);backdrop-filter:blur(4px);align-items:center;justify-content:center;" onclick="if(event.target===this)closeKpiModal()">
    <div style="background:#fff;border-radius:18px;box-shadow:0 24px 64px rgba(0,0,0,.18);width:95%;max-width:700px;max-height:92vh;overflow-y:auto;animation:kpiModalIn .22s ease;">
        <div id="kpiModalBanner" style="padding:18px 22px 16px;border-radius:18px 18px 0 0;background:linear-gradient(135deg,#1e293b,#334155);position:relative">
            <div style="display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:12px">
                    <div id="kpiModalIconWrap" style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff"></div>
                    <div>
                        <div id="kpiModalEye" style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(255,255,255,.6);margin-bottom:2px;"></div>
                        <div id="kpiModalTitle" style="font-size:19px;font-weight:800;color:#fff;letter-spacing:-.3px;"></div>
                    </div>
                </div>
                <button onclick="closeKpiModal()" style="width:32px;height:32px;border-radius:50%;border:1.5px solid rgba(255,255,255,.2);background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1">✕</button>
            </div>
            <div id="kpiModalSummaryRow" style="display:flex;gap:16px;margin-top:14px;flex-wrap:wrap"></div>
        </div>
        <div id="kpiModalBody" style="padding:18px 22px 22px;"></div>
    </div>
</div>
<style>
@keyframes kpiModalIn{from{opacity:0;transform:scale(.94) translateY(12px)}to{opacity:1;transform:scale(1) translateY(0)}}
.kpi-stat-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:20px}
.kpi-stat-box{border-radius:10px;padding:14px 16px;border:1.5px solid}
.kpi-stat-box-lbl{font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px}
.kpi-stat-box-val{font-family:'IBM Plex Mono',monospace;font-size:22px;font-weight:800;line-height:1}
.kpi-chart-wrap{height:200px;position:relative;margin-bottom:20px}
.kpi-bar-row{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.kpi-bar-lbl{font-size:11px;font-weight:600;color:#475569;min-width:70px;flex-shrink:0}
.kpi-bar-track{flex:1;height:8px;background:#f1f5f9;border-radius:4px;overflow:hidden}
.kpi-bar-fill{height:100%;border-radius:4px;transition:width .6s}
.kpi-bar-val{font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:700;min-width:36px;text-align:right}
</style>

</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const API_HEADERS = {'Accept':'application/json','X-CSRF-TOKEN':CSRF_TOKEN,'X-Requested-With':'XMLHttpRequest'};
let dashData = {}, barChart = null, regionSackChart = null;
window.dashData = dashData;
let lastUpdate = new Date(), mapInst = null;
let dashAllPins = [], dashPinMarkers = [], dashFallbackMarkers = [], dashMapRef = null;
const SACK_REGION_URL = '/api/sack/region-summary';
const NMS_API     = 'https://new.cwcnewcctv.in/api/v1/cameras';
const CAM_BY_WH   = 'https://new.cwcnewcctv.in/api/v1/cameras/by-warehouse';
const NMS_BASE    = 'https://nms.cwcnewcctv.in/api/nms/v1';
function fmtN(n) { return new Intl.NumberFormat('en-IN').format(Math.round(n||0)); }
function fmtDt(ts) {
    if (!ts) return '—';
    const d = new Date(ts); if (isNaN(d)) return ts;
    const p = n => String(n).padStart(2,'0');
    return `${p(d.getDate())}-${p(d.getMonth()+1)}-${d.getFullYear()} ${p(d.getHours())}:${p(d.getMinutes())}:${p(d.getSeconds())}`;
}
function hideL(name) {
    const c = document.querySelector(`[data-card="${name}"]`);
    if (!c) return;
    const o = c.querySelector('.card-loading-overlay');
    if (o) { o.classList.add('loaded'); setTimeout(()=>c.classList.remove('card-loading'),400); }
}
function tick() {
    const s = Math.floor((Date.now()-lastUpdate)/1000);
    const el = document.getElementById('lastUpdated');
    if (!el) return;
    el.textContent = s<60?'Live · just updated':s<3600?`Updated ${Math.floor(s/60)}m ago`:`Updated ${Math.floor(s/3600)}h ago`;
}/* ── Summary Strip ── */
async function renderNmsStrip() {
    const sc = (id, val) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = val;
        el.classList.remove('skel','skel-num','skel-sub');
    };
    const sb  = (id, pct) => {
        const el = document.getElementById(id);
        if (!el) return;
        const w = Math.min(100, pct);
        el.style.width = w + '%';
        el.style.background = w>=80 ? '#059669' : w>=50 ? '#d97706' : '#dc2626';
    };
    const p   = (on, tot) => tot > 0 ? Math.min(100, Math.round(on / tot * 100)) : 0;
    const fn  = n => new Intl.NumberFormat('en-IN').format(Math.round(n || 0));
    const col = '#1a73e8';
    const setSub = (id, html) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('skel','skel-sub');
        el.innerHTML = html;
    };
    const num = (v) => `<span style="color:${col};font-weight:700">${fn(v)}</span>`;
    const lbl = (t) => `<span style="color:var(--muted)">${t}</span>`;

    try {
        // Single Laravel AJAX call — cached server-side, no CORS, fast
        const r = await fetch('/api/nms/strip-summary', { headers: API_HEADERS });
        if (!r.ok) throw new Error('HTTP ' + r.status);
        const d = await r.json();
        if (!d.success) throw new Error(d.message || 'error');
        const s = d.data;
        _stripCache = s; // share with BTS tile + devices tile

        sc('sc-regions',   s.regions   ?? '—');
        setSub('sc-regions-sub', lbl('active regions'));

        sc('sc-warehouses', s.warehouses ?? '—');
        setSub('sc-warehouses-sub', lbl('monitored'));

        sc('sc-nvr-total', s.nvr_total ? fn(s.nvr_total) : '—');
        setSub('sc-nvr-on', num(s.nvr_online) + lbl(' on · ') + num(s.nvr_offline) + lbl(' off'));
        sb('sc-nvr-total-bar', p(s.nvr_online, s.nvr_total));

        /* Camera KPI — use cameras/by-warehouse API for accurate counts */
        fetch('<?php echo e(config("external-apis.nms_cam_base", "https://new.cwcnewcctv.in")); ?>/api/v1/cameras/by-warehouse')
            .then(r=>r.ok?r.json():null).catch(()=>null).then(camR=>{
                if(!camR?.data) return;
                const rows = camR.data;
                const totCam = rows.reduce((s,r)=>s+(r.total_cameras||0),0);
                const onCam  = rows.reduce((s,r)=>s+(r.online_cameras||0),0);
                const offCam = rows.reduce((s,r)=>s+(r.offline_cameras||0),0);
                sc('sc-cam-total', fn(totCam)||'—');
                setSub('sc-cam-on', num(onCam)+lbl(' on · ')+num(offCam)+lbl(' off'));
                sb('sc-cam-total-bar', p(onCam, totCam));
            });

        sc('sc-bts-total', s.bts_total ? fn(s.bts_total) : '—');
        setSub('sc-bts-on', num(s.bts_online) + lbl(' on · ') + num(s.bts_offline ?? 0) + lbl(' off'));
        sb('sc-bts-total-bar', p(s.bts_online, s.bts_total));

        sc('sc-cpe-total', '913');
        setSub('sc-cpe-sub', num(s.bts_clients||0)+lbl(' on · ')+num(913-(s.bts_clients||0))+lbl(' off'));

        sc('sc-epc-total', s.epc_total ? fn(s.epc_total) : '—');
        setSub('sc-epc-on', num(s.epc_online ?? 0) + lbl(' on · ') + num(s.epc_offline ?? 0) + lbl(' off'));
        sb('sc-epc-total-bar', p(s.epc_online, s.epc_total));

        sc('sc-ws-total', s.ws_total ? fn(s.ws_total) : '—');
        setSub('sc-ws-on', num(s.ws_online ?? 0) + lbl(' on · ') + num(s.ws_offline ?? 0) + lbl(' off'));
        sb('sc-ws-total-bar', p(s.ws_online, s.ws_total));

        sc('sc-co2-total', s.co2_total ? fn(s.co2_total) : '—');
        setSub('sc-co2-on', num(s.co2_online??0) + lbl(' on · ') + num(s.co2_alerts??0) + lbl(' offline'));

        sc('sc-ph3-total', s.ph3_total ? fn(s.ph3_total) : '—');
        setSub('sc-ph3-on', num(s.ph3_online??0) + lbl(' on · ') + num(s.ph3_alerts??0) + lbl(' offline'));

        // Update BTS tile and devices tile with the freshly loaded strip data
        renderBtsTile(s);
        if (Object.keys(dashData).length) renderDevicesTile(dashData, s);

    } catch (e) {
        console.warn('Strip AJAX error, falling back to direct fetch:', e.message);
        await renderNmsStripDirect();
    }
}

// Fallback: direct NMS calls if Laravel endpoint not yet available
async function renderNmsStripDirect() {
    const sc = (id, val) => { const el = document.getElementById(id); if (el) { el.textContent = val; el.classList.remove('skel','skel-num','skel-sub'); } };
    const sb = (id, pct) => { const el = document.getElementById(id); if (el) el.style.width = Math.min(100, pct) + '%'; };
    const p  = (on, tot) => tot > 0 ? Math.min(100, Math.round(on / tot * 100)) : 0;
    const fn = n => new Intl.NumberFormat('en-IN').format(Math.round(n || 0));
    const col = '#1a73e8';
    const setSub = (id, html) => { const el = document.getElementById(id); if (!el) return; el.classList.remove('skel','skel-sub'); el.innerHTML = html; };
    const num = v => `<span style="color:${col};font-weight:700">${fn(v)}</span>`;
    const lbl = t => `<span style="color:var(--muted)">${t}</span>`;
    try {
        const [regR, whR, statsR, gasR] = await Promise.all([
            fetch(NMS_BASE+'/regions').then(r=>r.ok?r.json():null).catch(()=>null),
            fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null),
            fetch(NMS_BASE+'/stats/by-type').then(r=>r.ok?r.json():null).catch(()=>null),
            fetch('<?php echo e(config("external-apis.co2_summary")); ?>').then(r=>r.ok?r.json():null).catch(()=>null).then(r => { if(!r){ console.warn('[Gas] co2_summary config empty/failed, trying direct'); return fetch('https://co2ph3master.ajeevi.in/api/summary').then(x=>x.ok?x.json():null).catch(()=>null); } return r; }),
        ]);
        const reg = Array.isArray(regR?.data)?regR.data:(Array.isArray(regR)?regR:[]);
        sc('sc-regions', reg.length||'—'); setSub('sc-regions-sub', lbl('active regions'));
        const wh = Array.isArray(whR?.data)?whR.data:(Array.isArray(whR)?whR:[]);
        const whH=wh.filter(w=>(w.status||'').toLowerCase()==='healthy').length;
        const whD=wh.filter(w=>(w.status||'').toLowerCase()==='down').length;
        sc('sc-warehouses', wh.length||'—');
        setSub('sc-warehouses-sub', lbl('monitored'));
        const types=statsR?.data||[];
        const find=(...k)=>types.find(t=>k.map(x=>x.toLowerCase()).includes((t.type||'').toLowerCase()))||{total:0,online:0};
        const nvr=find('NVR','DVR'), cam=find('Camera','IP Camera');
        const camTot=dashData.cameraTotal||cam.total||0, camOn=dashData.cameraOnline||cam.online||0;

        sc('sc-nvr-total', nvr.total?fn(nvr.total):'—'); setSub('sc-nvr-on', num(nvr.online)+lbl(' on · ')+num(nvr.total-nvr.online)+lbl(' off'));

        /* CO₂ / PH₃ — fetch from Ajeevi IoT API directly */
        fetch('https://co2ph3master.ajeevi.in/api/master-alerts?pageNumber=1&pageSize=1000')
            .then(r=>r.ok?r.json():null).catch(()=>null)
            .then(function(iotR){
                if(!iotR){
                    /* try cache */
                    try{var _gc2=JSON.parse(localStorage.getItem('cwc_gas_kpi')||'null');if(_gc2)gFillKpiStripDirect(_gc2);}catch(_){}
                    return;
                }
                const items = Array.isArray(iotR)?iotR:(iotR.data||[]);
                const co2 = items.filter(x=>x.deviceTypeId===30000||x.deviceTypeId==='30000');
                const ph3 = items.filter(x=>x.deviceTypeId===30001||x.deviceTypeId==='30001');
                const kd = {
                    co2Total:  co2.length,
                    co2Online: co2.filter(x=>/online/i.test(x.deviceStatus||'')).length,
                    co2Off:    co2.filter(x=>!/online/i.test(x.deviceStatus||'')).length,
                    ph3Total:  ph3.length,
                    ph3Online: ph3.filter(x=>/online/i.test(x.deviceStatus||'')).length,
                    ph3Off:    ph3.filter(x=>!/online/i.test(x.deviceStatus||'')).length,
                };
                try{localStorage.setItem('cwc_gas_kpi',JSON.stringify(kd));}catch(_){}
                gFillKpiStripDirect(kd);
            });

    } catch(e) { console.warn('Strip fallback error',e); }
}

async function loadStats() {
    const btn = document.getElementById('refreshBtn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="ri-loader-4-line" style="animation:spin 1s linear infinite;"></i>'; }
    const p = new URLSearchParams();
    const days = '30';
    p.append('days', days);
    try {
        const resp = await fetch(`/api/dashboard/stats?${p}`, { headers: API_HEADERS });
        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
        const json = await resp.json();
        if (json.success) {
            dashData = json.data; window.dashData = dashData;
            renderAll(dashData); lastUpdate = new Date(); tick();
        } else throw new Error(json.message || 'API returned success:false');
    } catch (e) {
        console.warn('Dashboard stats unavailable:', e.message);
        ['frs2','camera','fire','smoke','rodent','co2','ph3','frs','barChart','table','map','regionSack','bts','devices'].forEach(hideL);
    } finally {
        if (btn) { btn.disabled = false; btn.innerHTML = '<i class="ri-refresh-line"></i>'; }
    }
}
const DETECTION_STATS = new Set(['fireDetected','fireWarehouses','fireLastSeen','smokeDetected','smokeWarehouses','smokeLastSeen','rodentDetected','rodentWarehouses','rodentLastSeen']);
function renderAll(data) {
    document.querySelectorAll('[data-stat]').forEach(el=>{
        const k=el.getAttribute('data-stat');
        if (DETECTION_STATS.has(k)) return;
        const v=data[k]; el.textContent=(v===undefined||v===null)?'—':fmtN(v);
    });
    ['frs2','camera','fire','smoke','rodent','co2','ph3','frs'].forEach(hideL);
    renderDetectionCards(data);
    renderCharts(data);
    renderTable(data.regionData||[]);
    renderMap(data.mapData||[]);
    renderRegionSackChart();
    renderBtsTile(_stripCache);
    renderDevicesTile(data, _stripCache);
}
function pickVal(data,keys) {
    for (const k of keys) { let v=k.includes('.')?k.split('.').reduce((o,p)=>o!=null?o[p]:undefined,data):data[k]; if(v!==undefined&&v!==null&&v!=='')return v; } return null;
}
function renderDetectionCards(data) {
    const totalAll=(Number(pickVal(data,['fireDetected'])||0))+(Number(pickVal(data,['smokeDetected'])||0))+(Number(pickVal(data,['rodentDetected'])||0));
    const CIRC=163.4;
    const cfg=[
        {key:'fire',ringEl:'fireRingFill',whListEl:'fireWhList',color:'#dc2626',colorMid:'#ef4444',colorLight:'#fca5a5',totalK:['fireDetected'],whK:['fireWarehouses'],lastK:['fireLastSeen'],topWhK:['topFireWarehouses'],locationKey:'fire'},
        {key:'smoke',ringEl:'smokeRingFill',whListEl:'smokeWhList',color:'#d97706',colorMid:'#f59e0b',colorLight:'#fcd34d',totalK:['smokeDetected'],whK:['smokeWarehouses'],lastK:['smokeLastSeen'],topWhK:['topSmokeWarehouses'],locationKey:'smoke'},
        {key:'rodent',ringEl:'rodentRingFill',whListEl:'rodentWhList',color:'#0d9488',colorMid:'#14b8a6',colorLight:'#5eead4',totalK:['rodentDetected'],whK:['rodentWarehouses'],lastK:['rodentLastSeen'],topWhK:['topRodentWarehouses'],locationKey:'rodent'},
    ];
    cfg.forEach(({key,ringEl,whListEl,color,colorMid,colorLight,totalK,whK,lastK,topWhK,locationKey})=>{
        const total=Number(pickVal(data,totalK)||0);
        const numEl=document.querySelector(`[data-stat="${key}Detected"]`); if(numEl)numEl.textContent=fmtN(total);
        const ring=document.getElementById(ringEl); if(ring){ring.style.strokeDashoffset=CIRC*(1-(totalAll>0?total/totalAll:0));ring.style.transition='stroke-dashoffset .8s ease';}
        const wh=pickVal(data,whK); document.querySelectorAll(`[data-stat="${key}Warehouses"]`).forEach(el=>{el.textContent=wh!==null?fmtN(wh):'—';});
        const ls=pickVal(data,lastK); document.querySelectorAll(`[data-stat="${key}LastSeen"]`).forEach(el=>{if(ls){try{const d=new Date(ls);const diff=Math.floor((Date.now()-d)/60000);el.textContent=diff<1?'Just now':diff<60?diff+'m ago':diff<1440?Math.floor(diff/60)+'h ago':Math.floor(diff/1440)+'d ago';}catch{el.textContent='—';}}else el.textContent='—';});
        const listEl=document.getElementById(whListEl); if(!listEl)return;
        let topWH=pickVal(data,topWhK);
        if(!topWH&&data.locationWise)topWH=data.locationWise.map(l=>({name:l.locationName||'Unknown',count:Number(l[locationKey]||0)})).filter(w=>w.count>0).sort((a,b)=>b.count-a.count).slice(0,4);
        if(Array.isArray(topWH)&&topWH.length){const max=Math.max(...topWH.map(w=>Number(w.count||0)),1);const colors=[color,colorMid,colorLight,colorLight+'bb'];listEl.innerHTML=topWH.slice(0,4).map((w,i)=>{const name=w.name||w.locationName||'—';const count=Number(w.count||0);const pct=Math.round(count/max*100);const short=name.length>12?name.substring(0,11)+'…':name;return`<div class="det-wh-row"><div class="det-wh-name" title="${name}">${short}</div><div class="det-wh-track"><div class="det-wh-fill" style="width:${pct}%;background:${colors[i]||colorLight}"></div></div><div class="det-wh-val">${count}</div></div>`;}).join('');}
        else if(total>0){listEl.innerHTML=`<div class="det-wh-empty"><i class="ri-information-line"></i> No warehouse breakdown available</div>`;}
        else{listEl.innerHTML=`<div class="det-wh-empty">No detections this period</div>`;}
    });
}

/* ── BTS tile — pulls from NMS map pins to count BTS devices ── */
/* ── BTS tile — data comes from strip cache, no extra NMS call ── */
let _stripCache = null; // shared between renderNmsStrip, renderBtsTile, renderDevicesTile

function renderBtsTile(stripData) {
    try {
        const s  = stripData || _stripCache;
        const el = id => document.getElementById(id);
        if (s && el('btsTotalRadios')) {
            el('btsTotalRadios').textContent   = s.bts_total   ? fmtN(s.bts_total)   : '—';
            el('btsOnlineRadios').textContent  = s.bts_online  ? fmtN(s.bts_online)  : '—';
            el('btsOfflineRadios').textContent = s.bts_offline ? fmtN(s.bts_offline) : '—';
            el('btsTotalClients').textContent  = fmtN(s.bts_clients || 0);
        }
    } catch(e) { console.warn('BTS tile error', e); }
    hideL('bts');
}

/* ── Devices tile — shows all device types with on/off counts ── */
function renderDevicesTile(data, stripData) {
    try {
        const s = stripData || _stripCache;
        let types = (s && s.device_types) ? s.device_types : [];

        if (!types.length && data.regionData?.length) {
            const total  = data.regionData.reduce((s,r)=>s+(r.nvr_count||0),0);
            const online = data.regionData.reduce((s,r)=>s+(r.online_percent>=80?(r.nvr_count||0):0),0);
            types = [
                { type:'NVR',    total, online },
                { type:'Camera', total:data.cameraTotal||0, online:data.cameraOnline||0 },
                { type:'BTS',    total:s?.bts_total||0, online:s?.bts_online||0 },
            ];
        }

        const meta = {
            'NVR':         { label:'NVR',             desc:'Network Video Recorder',        icon:'ri-hard-drive-2-line', color:'#3b82f6' },
            'DVR':         { label:'DVR',             desc:'Digital Video Recorder',        icon:'ri-hard-drive-line',   color:'#6366f1' },
            'BTS':         { label:'BTS Radio',       desc:'Base Transceiver Station',      icon:'ri-router-line',       color:'#10b981' },
            'Embedded PC': { label:'Embedded PC',     desc:'Edge computing unit',           icon:'ri-computer-line',     color:'#f59e0b' },
            'EPC':         { label:'Embedded PC',     desc:'Edge computing unit',           icon:'ri-computer-line',     color:'#f59e0b' },
            'Workstation': { label:'Workstation',     desc:'Operator workstation / PC',     icon:'ri-cpu-line',      color:'#8b5cf6' },
            'Router':      { label:'Internet Router', desc:'WAN / internet gateway router', icon:'ri-router-fill',       color:'#0ea5e9' },
            'HDD':         { label:'HDD / Storage',   desc:'Hard disk / storage device',   icon:'ri-database-2-line',   color:'#64748b' },
            'Camera':      { label:'IP Camera',       desc:'IP surveillance camera',        icon:'ri-camera-line',       color:'#059669' },
        };

        const camRow = { type:'Camera', total:data.cameraTotal||0, online:data.cameraOnline||0 };
        const merged = [...types];
        if (!merged.find(t=>t.type==='Camera')) merged.unshift(camRow);

        const tbody = document.getElementById('devTypeTableBody');
        if (!tbody) { hideL('devices'); return; }
        if (!merged.length) { tbody.innerHTML='<tr><td colspan="5" style="text-align:center;padding:20px;color:var(--muted)">No device data</td></tr>'; hideL('devices'); return; }

        tbody.innerHTML = merged.map(t => {
            const m   = meta[t.type] || { label:t.type, desc:'', icon:'ri-server-line', color:'#64748b' };
            const tot = t.total  || 0;
            const on  = t.online || 0;
            const off = tot - on;
            const p   = tot>0 ? Math.min(100,Math.round(on/tot*100)) : 0;
            const col = p>=80?'var(--green)':p>=50?'var(--orange)':'var(--red)';
            return `<tr class="${off===tot&&tot>0?'row-off':''}">
                <td>
                    <span class="dst-ico" style="background:${m.color}22;border:1px solid ${m.color}44;color:${m.color}">
                        <i class="${m.icon}" style="font-size:12px"></i>
                    </span>
                    <span style="font-weight:700;font-size:12px">${m.label}</span>
                    ${m.desc?`<div style="font-size:10px;color:var(--muted);margin-left:30px;margin-top:1px">${m.desc}</div>`:''}
                </td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:700">${tot?fmtN(tot):'—'}</td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:700;color:var(--green)">${on?fmtN(on):'—'}</td>
                <td style="font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:700;color:${off>0?'var(--red)':'var(--muted)'}">${off?fmtN(off):'—'}</td>
                <td>
                    ${tot>0?`<div style="display:flex;align-items:center;gap:6px">
                        <div class="dst-bar"><div class="dst-bar-fill" style="width:${p}%;background:${col}"></div></div>
                        <span style="font-size:10px;font-weight:700;color:${col}">${p}%</span>
                    </div>`:'<span style="color:var(--muted);font-size:11px">—</span>'}
                </td>
            </tr>`;
        }).join('');
    } catch(e) { console.warn('Devices tile error',e); }
    hideL('devices');
}

let barChartMode='region', barChartRegion=null;
async function renderCharts(data) {
    barChartMode='region'; barChartRegion=null;
    try {
        const res=await fetch(`${NMS_API}/by-region-grouped`); const json=await res.json();
        if(json.success&&Array.isArray(json.data)&&json.data.length){const norm=json.data.map(r=>({region:r.region,nvr_count:r.nvr_count||0,total_cameras:r.total_cameras||0,online_cameras:r.online_cameras||0,offline_cameras:r.offline_cameras||0,online_percent:parseFloat(r.online_percent)||0,status:r.status||'ok'}));dashData.nmsRegionData=norm;renderRegionBar(norm);return;}
    } catch(e){console.warn('NMS region API failed',e);}
    renderRegionBar(data.regionData||[]);
}
function renderRegionBar(regions) {
    const top=[...regions].sort((a,b)=>(b.offline_cameras||0)-(a.offline_cameras||0));
    setBarChartUI('region',null); if(barChart)barChart.destroy();
    barChart=new Chart(document.getElementById('regionBarChart').getContext('2d'),{type:'bar',data:{labels:top.map(r=>r.region),datasets:[{label:'Online',data:top.map(r=>r.online_cameras||0),backgroundColor:'rgba(5,150,105,.72)',hoverBackgroundColor:'rgba(5,150,105,.95)',borderRadius:{topLeft:4,topRight:4},stack:'cams'},{label:'Offline',data:top.map(r=>r.offline_cameras||0),backgroundColor:'rgba(220,38,38,.82)',hoverBackgroundColor:'rgba(220,38,38,1)',borderRadius:{topLeft:4,topRight:4},stack:'cams'}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:true,position:'top',align:'end',labels:{font:{family:'DM Sans',size:11,weight:'600'},boxWidth:10,boxHeight:10,borderRadius:3,useBorderRadius:true,padding:12}},tooltip:{backgroundColor:'#0f172a',titleFont:{family:'DM Sans',weight:'800',size:12},bodyFont:{family:'IBM Plex Mono',size:12},padding:12,cornerRadius:8,callbacks:{title:items=>top[items[0].dataIndex]?.region||'',afterBody:items=>{const r=top[items[0].dataIndex];if(!r)return[];return['','  Total  : '+fmtN(r.total_cameras||0),'  Online : '+fmtN(r.online_cameras||0),'  Offline: '+fmtN(r.offline_cameras||0),'  Health : '+(parseFloat(r.online_percent)||0).toFixed(1)+'%','','  🖱 Click to see warehouses'];}}}},scales:{x:{stacked:true,grid:{display:false},ticks:{font:{family:'DM Sans',size:9,weight:'700'},color:'#64748b',maxRotation:45,autoSkip:false}},y:{stacked:true,grid:{color:'#f1f5f9'},ticks:{font:{family:'IBM Plex Mono',size:10},color:'#94a3b8'},beginAtZero:true}},onClick:(evt,elements)=>{if(!elements.length)return;const region=top[elements[0].index]?.region;if(region)drillIntoRegion(region);},onHover:(evt,elements)=>{evt.native.target.style.cursor=elements.length?'pointer':'default';}}});
    hideL('barChart');
}
async function drillIntoRegion(regionName) {
    barChartMode='warehouse'; barChartRegion=regionName; setBarChartUI('warehouse',regionName);
    if(barChart){barChart.destroy();barChart=null;}
    if(dashData.warehouseData?.[regionName]){renderWarehouseBar(dashData.warehouseData[regionName],regionName);return;}
    let warehouses=[];
    try {
        const res=await fetch(`${NMS_API}/by-warehouse-grouped`); const json=await res.json();
        if(json.success&&Array.isArray(json.data)&&json.data.length){const filtered=json.data.filter(w=>(w.region||'').toUpperCase()===regionName.toUpperCase());if(filtered.length)warehouses=filtered.map(w=>({warehouse_name:w.warehouse||w.area||'Warehouse',nvr_count:w.nvr_count||0,total_cameras:w.total_cameras||0,online_cameras:w.online_cameras||0,offline_cameras:w.offline_cameras||0,online_percent:parseFloat(w.online_percent)||0,status:w.status||'ok',last_synced_at:w.last_synced_at||null}));}
    } catch(e){console.warn('NMS warehouse API failed',e);}
    if(!dashData.warehouseData)dashData.warehouseData={};
    dashData.warehouseData[regionName]=warehouses; renderWarehouseBar(warehouses,regionName);
}
function renderWarehouseBar(warehouses,regionName) {
    if(barChart){barChart.destroy();barChart=null;}
    const sorted=[...warehouses].sort((a,b)=>(b.offline_cameras||0)-(a.offline_cameras||0)).slice(0,12);
    const hasCameraData=sorted.some(w=>(w.offline_cameras||0)+(w.online_cameras||0)>0);
    if(!sorted.length||!hasCameraData){const canvas=document.getElementById('regionBarChart');const ctx=canvas.getContext('2d');ctx.clearRect(0,0,canvas.width,canvas.height);ctx.textAlign='center';ctx.textBaseline='middle';ctx.font='700 13px DM Sans';ctx.fillStyle='#334155';ctx.fillText('No warehouse-level data for '+regionName,canvas.width/2,canvas.height/2);return;}
    const getBg=r=>{const p=r.online_percent||0;return p>=70?'rgba(5,150,105,.78)':p>=40?'rgba(217,119,6,.84)':'rgba(220,38,38,.84)';};
    const getHover=r=>{const p=r.online_percent||0;return p>=70?'rgba(5,150,105,1)':p>=40?'rgba(217,119,6,1)':'rgba(220,38,38,1)';};
    barChart=new Chart(document.getElementById('regionBarChart').getContext('2d'),{type:'bar',data:{labels:sorted.map(w=>{const n=w.warehouse_name||'WH';return n.length>18?n.substring(0,16)+'…':n;}),datasets:[{label:'Online',data:sorted.map(w=>w.online_cameras||0),backgroundColor:'rgba(5,150,105,.72)',hoverBackgroundColor:'rgba(5,150,105,1)',borderRadius:{topLeft:4,topRight:4},stack:'cameras'},{label:'Offline',data:sorted.map(w=>w.offline_cameras||0),backgroundColor:'rgba(220,38,38,.82)',hoverBackgroundColor:'rgba(220,38,38,1)',borderRadius:{topLeft:4,topRight:4},stack:'cameras'}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:true,position:'top',align:'end',labels:{font:{family:'DM Sans',size:11,weight:'600'},boxWidth:10,boxHeight:10,borderRadius:3,useBorderRadius:true,padding:14}},tooltip:{backgroundColor:'#0f172a',titleFont:{family:'DM Sans',weight:'800',size:12},bodyFont:{family:'IBM Plex Mono',size:12},padding:12,cornerRadius:8,callbacks:{title:items=>sorted[items[0].dataIndex]?.warehouse_name||items[0].label,afterBody:items=>{const row=sorted[items[0].dataIndex];if(!row)return[];return['','  NVRs   : '+fmtN(row.nvr_count||0),'  Total  : '+fmtN(row.total_cameras||0),'  Online : '+fmtN(row.online_cameras||0),'  Offline: '+fmtN(row.offline_cameras||0),'  Health : '+(parseFloat(row.online_percent)||0).toFixed(1)+'%'];}}}},scales:{x:{stacked:true,grid:{display:false},ticks:{font:{family:'DM Sans',size:9,weight:'700'},color:'#64748b',maxRotation:40}},y:{stacked:true,grid:{color:'#f1f5f9'},ticks:{font:{family:'IBM Plex Mono',size:10},color:'#94a3b8'},beginAtZero:true}},onHover:evt=>{evt.native.target.style.cursor='default';}}});
}
function setBarChartUI(mode,regionName) {
    const title=document.getElementById('barChartTitle'),breadcrumb=document.getElementById('barChartBreadcrumb'),backBtn=document.getElementById('barChartBackBtn'),hint=document.getElementById('barChartHint'),regionSpan=document.getElementById('barChartRegionName');
    if(mode==='region'){title.textContent='Top Regions — Offline Cameras';breadcrumb.style.display='none';backBtn.style.display='none';hint.style.display='flex';}
    else{title.textContent=`${regionName} — Warehouse Breakdown`;regionSpan.textContent=regionName;breadcrumb.style.display='block';backBtn.style.display='inline-flex';hint.style.display='none';}
}
async function renderRegionSackChart() {
    const statusEl=document.getElementById('regionSackStatus');
    ['sackTotalDayIn','sackTotalDayOut','sackNetDay','sackActiveRegions'].forEach(id=>{const el=document.getElementById(id);if(el)el.textContent='—';});
    try {
        if(statusEl)statusEl.innerHTML=`<i class="ri-loader-4-line" style="animation:spin 1s linear infinite;"></i> Loading…`;
        /* Use new region-sack-count API directly */
        const resp = await fetch('/api/sack/region-summary', {headers:{'Accept':'application/json','X-CSRF-TOKEN':CSRF_TOKEN}});
        if(!resp.ok) throw new Error(`HTTP ${resp.status}`);
        const json = await resp.json();
        if(!json.success) throw new Error(json.error||'API error');
        const regions = Array.isArray(json.data) ? json.data : [];
        const sorted = regions
            .filter(r=>r.region&&r.region!=='Default_Region'&&(r.total_in_bags||0)+(r.total_out_bags||0)>0)
            .map(r=>({
                region_name: r.region,
                region_id:   r.region_id,
                dayIn:  Number(r.total_in_bags||0),
                dayOut: Number(r.total_out_bags||0),
                net:    Number(r.total_in_bags||0)-Number(r.total_out_bags||0),
                last_action_at: r.last_action_at||null,
                warehouses: r.warehouses||[],
            }))
            .sort((a,b)=>(b.dayIn+b.dayOut)-(a.dayIn+a.dayOut));

        if(!sorted.length){if(statusEl)statusEl.innerHTML=`<i class="ri-information-line"></i> No bag movement data`;hideL('regionSack');return;}

        const labels=sorted.map(r=>r.region_name);
        const dayIns=sorted.map(r=>r.dayIn);
        const dayOuts=sorted.map(r=>r.dayOut);
        const totalIn=dayIns.reduce((s,v)=>s+v,0), totalOut=dayOuts.reduce((s,v)=>s+v,0), net=totalIn-totalOut;

        const setTile=(id,val)=>{const el=document.getElementById(id);if(el)el.textContent=val;};
        setTile('sackTotalDayIn',fmtN(totalIn));
        setTile('sackTotalDayOut',fmtN(totalOut));
        setTile('sackActiveRegions',sorted.length);
        const netEl=document.getElementById('sackNetDay'),netTile=document.getElementById('sackNetTile');
        if(netEl)netEl.textContent=(net>=0?'+':'')+fmtN(Math.abs(net));
        if(netTile){netTile.className='sack-tile '+(net>=0?'st-net-p':'st-net-n');const lbl=netTile.querySelector('.sack-tile-lbl');if(lbl)lbl.style.color=net>=0?'var(--green-d)':'var(--red-d)';if(netEl)netEl.style.color=net>=0?'var(--green-d)':'var(--red-d)';}
        if(statusEl)statusEl.innerHTML=`<i class="ri-check-line" style="color:var(--green);"></i> ${sorted.length} regions loaded`;

        /* Store regions globally and render */
        sackAllRegions = sorted;
        sackMode = 'region';
        renderSackRegionChart(sorted);
        hideL('regionSack');
    } catch(err){console.error('Region sack chart error',err);if(statusEl)statusEl.innerHTML=`<i class="ri-alert-line" style="color:var(--red);"></i> ${err.message}`;hideL('regionSack');}
}

/* ── Sack chart drill — same canvas, same pattern as offline cameras ── */
let sackWhChart = null, sackAllRegions = [], sackMode = 'region';

function sackGoBack() {
    sackMode = 'region';
    document.getElementById('sackBackBtn').style.display    = 'none';
    document.getElementById('sackBreadcrumb').style.display = 'none';
    document.getElementById('sackChartTitle').innerHTML     = '<i class="ri-bar-chart-grouped-line"></i> Region-wise Bag Movement';
    document.getElementById('sackTiles').style.display      = '';
    if (sackWhChart) { sackWhChart.destroy(); sackWhChart = null; }
    renderSackRegionChart(sackAllRegions);
}

function renderSackRegionChart(sorted) {
    const ctx = document.getElementById('regionSackChart').getContext('2d');
    if (regionSackChart) { regionSackChart.destroy(); regionSackChart = null; }
    const gradIn  = ctx.createLinearGradient(0,0,0,380);
    gradIn.addColorStop(0,'rgba(249,115,22,1)'); gradIn.addColorStop(1,'rgba(234,88,12,0.55)');
    const gradOut = ctx.createLinearGradient(0,0,0,380);
    gradOut.addColorStop(0,'rgba(30,58,138,1)'); gradOut.addColorStop(1,'rgba(37,99,235,0.55)');

    regionSackChart = new Chart(ctx, {
        type:'bar',
        data:{
            labels: sorted.map(r=>r.region_name),
            datasets:[
                {label:'Total IN',  data:sorted.map(r=>r.dayIn),  backgroundColor:gradIn,  hoverBackgroundColor:'rgba(249,115,22,1)', borderRadius:{topLeft:5,topRight:5},borderSkipped:false,barPercentage:0.65,categoryPercentage:0.8},
                {label:'Total OUT', data:sorted.map(r=>r.dayOut), backgroundColor:gradOut, hoverBackgroundColor:'rgba(30,58,138,1)',  borderRadius:{topLeft:5,topRight:5},borderSkipped:false,barPercentage:0.65,categoryPercentage:0.8},
            ]
        },
        options:{
            responsive:true, maintainAspectRatio:false,
            onClick:(e,els)=>{ if(!els.length) return; showSackWarehouseDrill(sorted[els[0].index]); },
            onHover:(e,els)=>{ e.native.target.style.cursor = els.length?'pointer':'default'; },
            plugins:{
                legend:{display:true,position:'top',align:'end',labels:{font:{family:'DM Sans',size:11,weight:'600'},boxWidth:10,boxHeight:10,borderRadius:3,useBorderRadius:true,padding:14}},
                tooltip:{backgroundColor:'#0f172a',titleFont:{family:'DM Sans',weight:'800',size:12},bodyFont:{family:'IBM Plex Mono',size:12},padding:12,cornerRadius:8,callbacks:{
                    title:items=>sorted[items[0].dataIndex]?.region_name+' (click to drill)',
                    afterBody:items=>{const r=sorted[items[0].dataIndex];const n=r.dayIn-r.dayOut;return['','  IN:  '+fmtN(r.dayIn),'  OUT: '+fmtN(r.dayOut),'  Net: '+(n>=0?'+':'')+fmtN(n)];}
                }}
            },
            scales:{
                x:{grid:{display:false},ticks:{font:{family:'DM Sans',size:10,weight:'700'},color:'#64748b',maxRotation:45,autoSkip:false}},
                y:{type:'logarithmic',grid:{color:'#f1f5f9'},min:1,ticks:{callback:v=>{const log=Math.log10(v);if(log%1!==0&&![1,2,5].includes(v/Math.pow(10,Math.floor(log))))return'';return v>=1e6?(v/1e6).toFixed(1)+'M':v>=1e3?(v/1e3).toFixed(0)+'K':v;},font:{family:'IBM Plex Mono',size:10},color:'#94a3b8'}}
            }
        }
    });
}

function showSackWarehouseDrill(reg) {
    sackMode = 'warehouse';
    const whs = (reg.warehouses||[])
        .filter(w=>(w.total_in_bags||0)+(w.total_out_bags||0)>0)
        .sort((a,b)=>(b.total_in_bags||0)-(a.total_in_bags||0))
        .slice(0,20)
        .map(w=>({...w, region_name: reg.region_name, region_id: reg.region_id}));

    document.getElementById('sackBackBtn').style.display    = 'flex';
    document.getElementById('sackBreadcrumb').style.display = 'block';
    document.getElementById('sackBreadRegion').textContent  = reg.region_name;
    document.getElementById('sackChartTitle').innerHTML     = `<i class="ri-building-2-line"></i> ${reg.region_name} — Warehouse Breakdown`;
    document.getElementById('sackTiles').style.display      = 'none';

    if (regionSackChart) { regionSackChart.destroy(); regionSackChart = null; }
    if (sackWhChart)     { sackWhChart.destroy(); sackWhChart = null; }

    if (!whs.length) {
        document.getElementById('regionSackChart').parentElement.innerHTML =
            '<div style="height:380px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px">No warehouse data available</div>';
        return;
    }

    const ctx = document.getElementById('regionSackChart').getContext('2d');
    const gIn=ctx.createLinearGradient(0,0,0,380);gIn.addColorStop(0,'rgba(249,115,22,1)');gIn.addColorStop(1,'rgba(234,88,12,.55)');
    const gOut=ctx.createLinearGradient(0,0,0,380);gOut.addColorStop(0,'rgba(30,58,138,1)');gOut.addColorStop(1,'rgba(37,99,235,.55)');
    sackWhChart = new Chart(ctx, {
        type:'bar',
        data:{
            labels: whs.map(w=>{const n=w.warehouse_name||'—';return n.length>16?n.substring(0,14)+'…':n;}),
            datasets:[
                {label:'Total IN',  data:whs.map(w=>w.total_in_bags||0),  backgroundColor:gIn,  hoverBackgroundColor:'rgba(249,115,22,1)', borderRadius:{topLeft:5,topRight:5},borderSkipped:false,barPercentage:0.65,categoryPercentage:0.8},
                {label:'Total OUT', data:whs.map(w=>w.total_out_bags||0), backgroundColor:gOut, hoverBackgroundColor:'rgba(30,58,138,1)',  borderRadius:{topLeft:5,topRight:5},borderSkipped:false,barPercentage:0.65,categoryPercentage:0.8},
            ]
        },
        options:{
            responsive:true, maintainAspectRatio:false,
            onHover:(e,els)=>{ e.native.target.style.cursor = els.length?'pointer':'default'; },
            onClick:(e,els)=>{
                if(!els.length) return;
                const w = whs[els[0].index];
                if (w.warehouse_id) {
                    window.location.href = '<?php echo e(route("sack.count")); ?>?region_id='+encodeURIComponent(w.region_id||'')+'&warehouse_id='+encodeURIComponent(w.warehouse_id)+'&warehouse_name='+encodeURIComponent(w.warehouse_name||'')+'&region_name='+encodeURIComponent(w.region_name||'');
                }
            },
            plugins:{
                legend:{display:true,position:'top',align:'end',labels:{font:{family:'DM Sans',size:11,weight:'600'},boxWidth:10,boxHeight:10,borderRadius:3,useBorderRadius:true,padding:14}},
                tooltip:{backgroundColor:'#0f172a',titleFont:{family:'DM Sans',weight:'800',size:12},bodyFont:{family:'IBM Plex Mono',size:11},padding:10,cornerRadius:8,callbacks:{
                    title:items=>whs[items[0].dataIndex]?.warehouse_name||'',
                    afterBody:items=>{const w=whs[items[0].dataIndex];const net=Number(w.net_bags||0);return['  IN:  '+fmtN(w.total_in_bags||0),'  OUT: '+fmtN(w.total_out_bags||0),'  Net: '+(net>=0?'+':'')+fmtN(net)];}
                }}
            },
            scales:{
                x:{grid:{display:false},ticks:{font:{family:'DM Sans',size:9,weight:'700'},color:'#64748b',maxRotation:45,autoSkip:false}},
                y:{grid:{color:'#f1f5f9'},ticks:{font:{family:'IBM Plex Mono',size:10},color:'#94a3b8',callback:v=>v>=1e6?(v/1e6).toFixed(1)+'M':v>=1e3?(v/1e3).toFixed(0)+'K':v},beginAtZero:true}
            }
        }
    });
}
function renderTable(regions) {
    const el=document.getElementById('tableRegionCount');if(el)el.textContent=regions.length?`${regions.length} regions`:'';
    const tbody=document.getElementById('regionTableBody');
    if(!regions.length){tbody.innerHTML='<tr><td colspan="8" style="text-align:center;padding:36px;color:var(--muted);">No data</td></tr>';hideL('table');return;}
    tbody.innerHTML=regions.map(r=>{const pct=r.online_percent||0,col=pct>=70?'var(--green)':pct>=40?'var(--orange)':'var(--red)',badge=r.status==='alert'?'<span class="sbadge sb-alert"><span class="sb-dot"></span> Alert</span>':'<span class="sbadge sb-ok"><span class="sb-dot"></span> OK</span>';return`<tr style="cursor:pointer" onclick="window.location.href='/cameras/region/${encodeURIComponent(r.region)}'"><td class="t-n">${r.region}</td><td class="t-m">${r.nvr_count||0}</td><td class="t-m">${fmtN(r.total_cameras||0)}</td><td class="t-m t-g">${fmtN(r.online_cameras||0)}</td><td class="t-m t-r">${fmtN(r.offline_cameras||0)}</td><td><div class="pct-bar"><div class="pct-track"><div class="pct-fill" style="width:${pct}%;background:${col}"></div></div><span class="t-m" style="font-size:11.5px;color:${col}">${pct}%</span></div></td><td>${badge}</td><td style="text-align:center"><a href="/cameras/region/${encodeURIComponent(r.region)}" class="view-btn" onclick="event.stopPropagation()"><i class="ri-eye-line"></i> View</a></td></tr>`;}).join('');
    hideL('table');
}

/* ── Map ── */
function dashMapRadius(map) { const z=map.getZoom(); if(z>=10)return 10; if(z>=7)return 7; return 5; }
const dashColorMap={healthy:'#10b981',partial:'#f59e0b',down:'#ef4444'};
const dashLabelMap={healthy:'Healthy',partial:'Partial',down:'Down'};
/* status now derived from camera online % — 80%+ healthy, 40-79% partial, 0-39% down */
function camStatus(pin) {
    const tot = pin.cam_total ?? 0, on = pin.cam_online ?? 0;
    if (tot <= 0) return pin.status || 'down'; // fallback if no cameras at this warehouse
    const p = (on / tot) * 100;
    if (p >= 80) return 'healthy';
    if (p >= 40) return 'partial';
    return 'down';
}
function buildDashTooltip(pin) {
    const st=camStatus(pin);
    const color=dashColorMap[st]||'#ef4444', label=dashLabelMap[st]||'Unknown';
    const hasCams=(pin.cam_total??0)>0, camOnline=pin.cam_online??0, camTotal=pin.cam_total??0;
    const camPct = camTotal>0 ? Math.round(camOnline/camTotal*100) : null;
    const camColor=camOnline===camTotal?'#10b981':camOnline===0?'#ef4444':'#f59e0b';
    const camRow=hasCams?`<div style="background:#f8fafc;border-radius:6px;padding:5px 8px;"><div style="color:#1a73e8;font-weight:700;text-transform:uppercase;font-size:8.5px;letter-spacing:.07em;margin-bottom:2px;">Cameras</div><div style="font-weight:800;color:${camColor};font-family:'IBM Plex Mono',monospace;">${camOnline}<span style="color:#94a3b8;font-weight:500;">/${camTotal}</span>${camPct!==null?` <span style="color:${camColor};font-weight:600">(${camPct}%)</span>`:''}</div></div>`:'';
    const btsRow=(pin.bts_clients>0)?`<div style="background:#f8fafc;border-radius:6px;padding:5px 8px;grid-column:1/-1;"><div style="color:#1a73e8;font-weight:700;text-transform:uppercase;font-size:8.5px;letter-spacing:.07em;margin-bottom:2px;">BTS Clients</div><div style="font-weight:800;color:#0f172a;font-family:'IBM Plex Mono',monospace;">${fmtN(pin.bts_clients)}</div></div>`:'';
    return`<div style="font-family:'DM Sans',sans-serif;min-width:200px;"><div style="font-weight:800;font-size:13px;color:#0f172a;margin-bottom:2px;">${pin.warehouse_name}</div><div style="font-size:11px;color:#64748b;margin-bottom:7px;">${pin.region_name}</div><div style="font-weight:700;font-size:11.5px;color:${color};margin-bottom:8px;">● ${label}${hasCams?` (${camPct}% cameras online)`:''}</div><div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:10.5px;"><div style="background:#f8fafc;border-radius:6px;padding:5px 8px;"><div style="color:#1a73e8;font-weight:700;text-transform:uppercase;font-size:8.5px;letter-spacing:.07em;margin-bottom:2px;">NVR</div><div style="font-weight:800;color:#0f172a;font-family:'IBM Plex Mono',monospace;">${pin.nvr_online??0}<span style="color:#94a3b8;font-weight:500;">/${pin.nvr_total??0}</span></div></div>${camRow}${btsRow}</div><div style="margin-top:8px;font-size:10px;color:#94a3b8;text-align:center;">Click to open detail</div></div>`;
}
function renderDashPins(pins) {
    if(!dashMapRef) return;
    dashPinMarkers.forEach(m=>dashMapRef.removeLayer(m)); dashPinMarkers=[];
    pins.forEach(pin=>{
        const color=dashColorMap[camStatus(pin)]||'#ef4444';
        const m=L.circleMarker([pin.lat,pin.lng],{radius:dashMapRadius(dashMapRef),fillColor:color,color:'#fff',weight:1.5,opacity:1,fillOpacity:.9}).addTo(dashMapRef);
        m.bindTooltip(buildDashTooltip(pin),{className:'tip-marker',direction:'top',offset:[0,-12],permanent:false});
        m.on('click',()=>{window.location.href=`/nms/warehouses/${pin.warehouse_id}`;});
        m.on('mouseover',()=>m.openTooltip());
        dashPinMarkers.push(m);
    });
    const c=document.getElementById('dashMapCount'); if(c) c.textContent=pins.length+' shown';
}
function getFilteredDashPins() {
    const status=document.getElementById('dashMapFilter')?.value||'';
    const search=(document.getElementById('dashMapSearch')?.value||'').toLowerCase().trim();
    return dashAllPins.filter(p=>{
        if(status&&camStatus(p)!==status)return false;
        if(search&&!(p.warehouse_name||'').toLowerCase().includes(search)&&!(p.region_name||'').toLowerCase().includes(search))return false;
        return true;
    });
}
function filterDashPins(){const f=getFilteredDashPins();renderDashPins(f);if(f.length===1&&dashMapRef)dashMapRef.setView([f[0].lat,f[0].lng],10);}
function resetDashMapView(){const sel=document.getElementById('dashMapFilter'),srch=document.getElementById('dashMapSearch');if(sel)sel.value='';if(srch)srch.value='';renderDashPins(dashAllPins);if(dashMapRef)dashMapRef.setView([23.5,82],5);}
async function renderMap(mapData) {
    if(mapInst){mapInst.remove();mapInst=null;}
    const map=L.map('dashMap',{zoomControl:true,scrollWheelZoom:false,attributionControl:false}).setView([23.5,82],5);
    mapInst=map; dashMapRef=map; dashAllPins=[]; dashPinMarkers=[]; dashFallbackMarkers=[];
    const controls=document.getElementById('dashMapControls'); if(controls)controls.style.display='none';
    const [geo,nmsResp]=await Promise.all([
        fetch('/geojson/india_states.geojson').then(r=>r.ok?r.json():null).catch(()=>null),
        fetch(NMS_BASE+'/map').then(r=>r.ok?r.json():null).catch(()=>null),
    ]);
    if(geo){const layer=L.geoJSON(geo,{style:()=>({color:'#d1d5db',weight:1,fillColor:'#f8fafc',fillOpacity:1}),onEachFeature:(f,l)=>{const n=f.properties.NAME_1||f.properties.name||f.properties.ST_NM||f.properties.State_Name||'';if(n)l.bindTooltip(n,{sticky:true,className:'tip-state',direction:'center'});l.on('mouseover',function(){this.setStyle({fillColor:'#f1f5f9'});});l.on('mouseout',function(){layer.resetStyle(this);});}}).addTo(map);map.fitBounds(layer.getBounds(),{padding:[20,20]});}
    const pins=(nmsResp&&nmsResp.data&&nmsResp.data.length)?nmsResp.data.filter(p=>p.lat&&p.lng&&p.status!=='no_devices'):null;
    if(pins&&pins.length){
        dashAllPins=pins; renderDashPins(dashAllPins);
        if(controls)controls.style.display='flex';
        map.on('zoomend',()=>renderDashPins(getFilteredDashPins()));
    } else if(mapData&&mapData.length){
        const cM={Healthy:'#10b981',Partial:'#f59e0b',Down:'#ef4444'};
        mapData.forEach(item=>{if(!item.lat||!item.lng)return;const color=cM[item.status]||'#ef4444';const m=L.circleMarker([item.lat,item.lng],{radius:dashMapRadius(map),fillColor:color,color:'#fff',weight:1.5,opacity:1,fillOpacity:.9}).addTo(map);m.bindTooltip(`<div style="font-weight:800;font-size:13px;margin-bottom:3px;">${item.area}</div><div style="font-size:11px;color:#64748b;">${item.city}, ${item.state}</div><div style="margin-top:5px;font-size:11px;font-weight:700;color:${color};">● ${item.status}</div>`,{className:'tip-marker',direction:'top',offset:[0,-8]});m.on('click',()=>{window.location.href=`/nms/area/${encodeURIComponent(item.state)}/${encodeURIComponent(item.city)}/${encodeURIComponent(item.area)}`;});dashFallbackMarkers.push(m);});
        map.on('zoomend',()=>dashFallbackMarkers.forEach(m=>m.setRadius(dashMapRadius(map))));
    }
    hideL('map');
}

/* ── CO2/PH3 Widget ── */
(function(){
    var gData=null,gGas='co2',gView='overall',gStatusChart=null,gSevChart=null,gAllRows=[];
    window.__gData = null; /* global accessor */
    var GAS_API='<?php echo e(config("external-apis.co2_summary")); ?>';
    var C={online:'#2563eb',offline:'#1e293b',normal:'#059669',severe:'#d97706',critical:'#dc2626'};
    function fmt(n){return new Intl.NumberFormat('en-IN').format(Math.round(n||0));}
    function esc(s){return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}
    function gFetch(){fetch(GAS_API).then(function(r){if(!r.ok)throw new Error('HTTP '+r.status);return r.json();}).then(function(data){
        gData=data; window.__gData=data;
        /* cache for offline/slow fallback */
        try{ localStorage.setItem('cwc_gas_cache', JSON.stringify({ts:Date.now(),data:data})); }catch(_){}
        document.getElementById('gLoading').style.display='none';
        gRenderOverall();gBuildLocRows();gShowView(gView);
        /* populate KPI strip CO₂ / PH₃ cells */
        gFillKpiStrip(data.overall||{});
    }).catch(function(e){
        document.getElementById('gLoading').style.display='none';
        console.error('CO2/PH3:',e);
        /* try to load from cache */
        try{
            var cached = JSON.parse(localStorage.getItem('cwc_gas_cache')||'null');
            if(cached && cached.data){
                gData = cached.data;
                gRenderOverall(); gBuildLocRows(); gShowView(gView);
                gFillKpiStrip(cached.data.overall||{});
                /* show stale badge */
                var age = Math.round((Date.now()-cached.ts)/60000);
                var el = document.getElementById('sc-co2-on');
                if(el) el.innerHTML += '<span style="color:var(--orange);font-size:9px;margin-left:4px">(cached '+age+'m ago)</span>';
                return;
            }
        }catch(_){}
        /* no cache — show error */
        document.getElementById('gError').style.display='block';
        var el;
        el=document.getElementById('sc-co2-total'); if(el){ el.textContent='N/A'; el.classList.remove('skel','skel-num'); }
        el=document.getElementById('sc-co2-on');    if(el){ el.innerHTML='<span style="color:var(--red);font-size:10px">API unavailable</span>'; el.classList.remove('skel','skel-sub'); }
        el=document.getElementById('sc-ph3-total'); if(el){ el.textContent='N/A'; el.classList.remove('skel','skel-num'); }
        el=document.getElementById('sc-ph3-on');    if(el){ el.innerHTML='<span style="color:var(--red);font-size:10px">API unavailable</span>'; el.classList.remove('skel','skel-sub'); }
    });}

    function gFillKpiStrip(o){
        var co2Tot=(o.totalOnlineCO2||0)+(o.totalOfflineCO2||0);
        var ph3Tot=(o.totalOnlinePH3||0)+(o.totalOfflinePH3||0);
        var _n = function(v){ return '<span style="font-family:IBM Plex Mono,monospace;font-weight:700;color:var(--text)">'+fmtN(v||0)+'</span>'; };
        var _l = function(v){ return '<span style="color:var(--muted)">'+v+'</span>'; };
        var el;
        el=document.getElementById('sc-co2-total'); if(el){ el.textContent=co2Tot?fmtN(co2Tot):'—'; el.classList.remove('skel','skel-num'); }
        el=document.getElementById('sc-co2-on');    if(el){ el.innerHTML=_n(o.totalOnlineCO2||0)+_l(' on · ')+_n(o.totalOfflineCO2||0)+_l(' off'); el.classList.remove('skel','skel-sub'); }
        el=document.getElementById('sc-ph3-total'); if(el){ el.textContent=ph3Tot?fmtN(ph3Tot):'—'; el.classList.remove('skel','skel-num'); }
        el=document.getElementById('sc-ph3-on');    if(el){ el.innerHTML=_n(o.totalOnlinePH3||0)+_l(' on · ')+_n(o.totalOfflinePH3||0)+_l(' off'); el.classList.remove('skel','skel-sub'); }
    }

    function gFillKpiStripDirect(kd){
        var _n = function(v){ return '<span style="font-family:IBM Plex Mono,monospace;font-weight:700;color:var(--text)">'+fmtN(v||0)+'</span>'; };
        var _l = function(v){ return '<span style="color:var(--muted)">'+v+'</span>'; };
        var el;
        el=document.getElementById('sc-co2-total'); if(el){ el.textContent=kd.co2Total?fmtN(kd.co2Total):'—'; el.classList.remove('skel','skel-num'); }
        el=document.getElementById('sc-co2-on');    if(el){ el.innerHTML=_n(kd.co2Online)+_l(' on · ')+_n(kd.co2Off)+_l(' off'); el.classList.remove('skel','skel-sub'); }
        el=document.getElementById('sc-ph3-total'); if(el){ el.textContent=kd.ph3Total?fmtN(kd.ph3Total):'—'; el.classList.remove('skel','skel-num'); }
        el=document.getElementById('sc-ph3-on');    if(el){ el.innerHTML=_n(kd.ph3Online)+_l(' on · ')+_n(kd.ph3Off)+_l(' off'); el.classList.remove('skel','skel-sub'); }
    }
    /* pre-fill KPI from cache on page load so values show instantly */
    try{ var _gc=JSON.parse(localStorage.getItem('cwc_gas_cache')||'null'); if(_gc&&_gc.data) gFillKpiStrip(_gc.data.overall||{}); }catch(_){}
    try{ var _gcd=JSON.parse(localStorage.getItem('cwc_gas_kpi')||'null'); if(_gcd&&_gcd.co2Total) gFillKpiStripDirect(_gcd); }catch(_){}
    window.gSwitchGas=function(gas){gGas=gas;document.getElementById('gTabCO2').className='gas-tab-btn'+(gas==='co2'?' co2-active':'');document.getElementById('gTabPH3').className='gas-tab-btn'+(gas==='ph3'?' ph3-active':'');if(gData){gRenderOverall();gBuildLocRows();}};
    window.gShowView=function(view){gView=view;document.getElementById('gBtnOverall').className='gas-view-btn'+(view==='overall'?' gas-active':'');document.getElementById('gBtnLocation').className='gas-view-btn'+(view==='location'?' gas-active':'');document.getElementById('gOverallView').style.display=view==='overall'?'block':'none';document.getElementById('gLocationView').style.display=view==='location'?'block':'none';};
    function gRenderOverall(){var o=gData.overall||{},isCO2=gGas==='co2',lbl=isCO2?'CO₂':'PH₃';var online=isCO2?(o.totalOnlineCO2||0):(o.totalOnlinePH3||0);var offline=isCO2?(o.totalOfflineCO2||0):(o.totalOfflinePH3||0);var normal=isCO2?(o.totalNormalCO2||0):(o.totalNormalPH3||0);var severe=isCO2?(o.totalSevereCO2||0):(o.totalSeverePH3||0);var critical=isCO2?(o.totalCriticalCO2||0):(o.totalCriticalPH3||0);document.getElementById('gLblOnline').textContent='Online '+lbl;document.getElementById('gLblOffline').textContent='Offline '+lbl;document.getElementById('gLblNormal').textContent='Normal '+lbl;document.getElementById('gChartStatusLbl').textContent=lbl+' Device Status';document.getElementById('gChartSevLbl').textContent=lbl+' Alert Severity';document.getElementById('gValOnline').textContent=fmt(online);document.getElementById('gValOffline').textContent=fmt(offline);document.getElementById('gValNormal').textContent=fmt(normal);document.getElementById('gValSevere').textContent=fmt(severe);document.getElementById('gValCritical').textContent=fmt(critical);gUpdateChart('status',['Online','Offline'],[online,offline],[C.online,C.offline]);gUpdateChart('severity',['Normal','Severe','Critical'],[normal,severe,critical],[C.normal,C.severe,C.critical]);}
    function gUpdateChart(which,labels,data,colors){var canvasId=which==='status'?'gStatusChart':'gSeverityChart';var ctx=document.getElementById(canvasId).getContext('2d');var existing=which==='status'?gStatusChart:gSevChart;if(existing){existing.data.labels=labels;existing.data.datasets[0].data=data;existing.data.datasets[0].backgroundColor=colors;existing.update();return;}var chart=new Chart(ctx,{type:'doughnut',data:{labels:labels,datasets:[{data:data,backgroundColor:colors,borderWidth:2,borderColor:'#fff',hoverOffset:8}]},options:{responsive:true,maintainAspectRatio:false,cutout:'65%',plugins:{legend:{position:'bottom',labels:{font:{family:'DM Sans',size:11,weight:'700'},padding:14,usePointStyle:true,pointStyleWidth:9}},tooltip:{backgroundColor:'#0f172a',titleFont:{family:'DM Sans',weight:'800',size:12},bodyFont:{family:'IBM Plex Mono',size:12},padding:10,cornerRadius:8,callbacks:{label:function(c){var total=c.dataset.data.reduce(function(a,b){return a+b;},0);var pct=total>0?((c.parsed/total)*100).toFixed(1):0;return' '+c.label+': '+fmt(c.parsed)+' ('+pct+'%)';}}}}}});if(which==='status')gStatusChart=chart;if(which==='severity')gSevChart=chart;}
    function gBuildLocRows(){var isCO2=gGas==='co2',lw=gData.locationWise||{};gAllRows=[];Object.entries(lw).forEach(function(entry){var key=entry[0],loc=entry[1];var gasTotal=isCO2?((loc.onlineCO2||0)+(loc.offlineCO2||0)):((loc.onlinePH3||0)+(loc.offlinePH3||0));if(!gasTotal)return;gAllRows.push({name:loc.locationName||key,state:loc.state||'—',iot:gasTotal,online:isCO2?(loc.onlineCO2||0):(loc.onlinePH3||0),offline:isCO2?(loc.offlineCO2||0):(loc.offlinePH3||0),normal:isCO2?(loc.normalCO2||0):(loc.normalPH3||0),severe:isCO2?(loc.severeCO2||0):(loc.severePH3||0),critical:isCO2?(loc.criticalCO2||0):(loc.criticalPH3||0)});});gAllRows.sort(function(a,b){return(b.critical-a.critical)||(b.severe-a.severe);});window.__gasAllRows=gAllRows;var cnt=document.getElementById('gLocCount');if(cnt)cnt.textContent=gAllRows.length+' locations';gRenderRows(gAllRows);}
    function gRenderRows(rows){var body=document.getElementById('gLocBody');if(!rows.length){body.innerHTML='<tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted);font-size:12px;">No locations found.</td></tr>';return;}body.innerHTML=rows.map(function(r){return'<tr><td><div class="loc-name">'+esc(r.name)+'</div><div class="loc-state">'+esc(r.state)+'</div></td><td class="t-m">'+fmt(r.iot)+'</td><td class="t-m" style="color:var(--blue-d);">'+fmt(r.online)+'</td><td><span class="gsev gsev-normal">'+fmt(r.normal)+'</span></td><td><span class="gsev gsev-severe">'+fmt(r.severe)+'</span></td><td><span class="gsev gsev-critical">'+fmt(r.critical)+'</span></td></tr>';}).join('');}
    window.gFilterTable=function(q){q=q.toLowerCase().trim();gRenderRows(q?gAllRows.filter(function(r){return r.name.toLowerCase().includes(q)||r.state.toLowerCase().includes(q);}):gAllRows);};
    gFetch(); setInterval(gFetch,5*60*1000);
})();

/* ── KPI Modal ── */
let _kpiChart = null;

const _KPI_META = {
    regions:    { eye:'NMS',   title:'Region',       icon:'ri-map-pin-2-line',    banner:'#1e3a5f,#1e40af' },
    warehouses: { eye:'NMS',   title:'Warehouses',    icon:'ri-building-4-line',   banner:'#3b0764,#6d28d9' },
    nvr:        { eye:'NMS Devices',   title:'NVR',          icon:'ri-hard-drive-2-line', banner:'#1e3a5f,#1d4ed8' },
    cam:        { eye:'CCTV Network',  title:'Cameras',       icon:'ri-camera-line',       banner:'#1e1b4b,#4338ca' },
    bts:        { eye:'NMS Devices',   title:'BTS',          icon:'ri-router-line',       banner:'#064e3b,#047857' },
    cpe:        { eye:'NMS Network',   title:'CPE Clients',   icon:'ri-wifi-line',         banner:'#134e4a,#0f766e' },
    epc:        { eye:'NMS Devices',   title:'Embedded PC',  icon:'ri-computer-line',     banner:'#78350f,#b45309' },
    ws:         { eye:'NMS Devices',   title:'Workstations',  icon:'ri-cpu-line',      banner:'#4c1d95,#7c3aed' },
    co2:        { eye:'IoT Sensors',   title:'CO₂ Sensors',   icon:'ri-temp-cold-line',    banner:'#7f1d1d,#b91c1c' },
    ph3:        { eye:'IoT Sensors',   title:'PH₃ Sensors',   icon:'ri-flask-line',        banner:'#7c2d12,#c2410c' },
};

function openKpiModal(key) {
    if (_kpiChart) { _kpiChart.destroy(); _kpiChart = null; }
    document.querySelectorAll('[id^="_km"]').forEach(cv => { try { Chart.getChart(cv)?.destroy(); } catch(e){} });

    const m = _KPI_META[key]; if (!m) return;
    const s = _stripCache || {}, d = dashData || {};

    /* set banner */
    const banner = document.getElementById('kpiModalBanner');
    const iconWrap = document.getElementById('kpiModalIconWrap');
    const sumRow = document.getElementById('kpiModalSummaryRow');
    document.getElementById('kpiModalEye').textContent   = m.eye;
    document.getElementById('kpiModalTitle').textContent = m.title;
    iconWrap.innerHTML = `<i class="${m.icon}" style="font-size:22px;color:#fff"></i>`;
    if (banner) banner.style.background = `linear-gradient(135deg,#${m.banner.split(',')[0].replace('#','')},#${m.banner.split(',')[1].replace('#','')})`;

    const fmt = v => new Intl.NumberFormat('en-IN').format(Math.round(v||0));
    const pct = (a,b) => b>0 ? Math.round(a/b*100) : 0;
    const uC  = p => p>=80?'#4ade80':p>=50?'#fbbf24':'#f87171';

    /* summary pill in banner */
    function sumPill(lbl, val, sub, onClick) {
        const clickStyle = onClick ? 'cursor:pointer;transition:background .15s;' : '';
        const hoverAttr  = onClick
            ? `onmouseover="this.style.background='rgba(255,255,255,.22)'" onmouseout="this.style.background='rgba(255,255,255,.12)'" onclick="${onClick}"`
            : '';
        return `<div style=" ${lbl === 'Configured' ? 'display:none;' : ''}background:rgba(255,255,255,.12);border-radius:10px;padding:8px 14px;min-width:90px;${clickStyle}" ${hoverAttr}>
            <div style="font-size:9px;color:rgba(255,255,255,.65);font-weight:700;text-transform:uppercase;letter-spacing:.07em;margin-bottom:3px">${lbl}</div>
            <div style="font-family:'IBM Plex Mono',monospace;font-size:20px;font-weight:800;color:#fff;line-height:1">${val}${onClick?'<span style="font-size:11px;opacity:.6;margin-left:4px">›</span>':''}</div>
            ${sub?`<div style="font-size:10px;color:rgba(255,255,255,.55);margin-top:3px">${sub}</div>`:''}
        </div>`;
    }

    /* stat card in body */
    function card(lbl, val, pctVal, color) {
        const p = typeof pctVal==='number' ? pctVal : null;
        const fillW = p !== null ? p : 0;
        const barC = p!==null ? (p>=80?'#22c55e':p>=50?'#f59e0b':'#ef4444') : color;
        return `<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px 14px 12px;flex:1;min-width:100px">
            <div style="font-size:10px;color:#64748b;font-weight:600;margin-bottom:6px;text-transform:uppercase;letter-spacing:.06em">${lbl}</div>
            <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;font-weight:800;color:${color};line-height:1">${val}</div>
            ${p!==null?`<div style="margin-top:8px;height:4px;background:#e2e8f0;border-radius:2px;overflow:hidden"><div style="height:100%;border-radius:2px;background:${barC};width:${fillW}%"></div></div><div style="font-size:10px;color:${barC};margin-top:4px;font-weight:600">${p}%</div>`:''}
        </div>`;
    }

    /* donut chart */
    function donut(id, labels, data, colors, title, height, deviceKey) {
        const tot = data.reduce((a,b)=>a+b,0);
        const lgd = labels.map((l,i) => {
            const isOnline  = /online/i.test(l);
            const isOffline = /offline/i.test(l);
            const clickable = deviceKey && (isOnline || isOffline);
            const statusVal = isOnline ? 'online' : 'offline';
            const drill = clickable
                ? ` style="cursor:pointer;padding:3px 6px;border-radius:6px;transition:background .15s"
                   onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
                   onclick="drillStatus('${deviceKey}','${statusVal}')"`
                : '';
            return `<span${drill} style="display:flex;align-items:center;gap:4px;font-size:11px;color:#475569;${clickable?'cursor:pointer':''}">
                <span style="width:8px;height:8px;border-radius:2px;flex-shrink:0;background:${colors[i]}"></span>
                ${l} <b style="color:#0f172a;margin-left:2px">${fmt(data[i])}</b>

                ${clickable?`<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6;margin-left:2px"></i>`:''}
            </span>`;
        }).join('');
        setTimeout(()=>{
            const cv=document.getElementById(id); if(!cv) return;
            const chart = new Chart(cv.getContext('2d'),{
                type:'doughnut',
                data:{labels,datasets:[{data,backgroundColor:colors,borderWidth:2,borderColor:'#fff',hoverOffset:6}]},
                options:{responsive:true,maintainAspectRatio:false,cutout:'68%',
                    plugins:{legend:{display:false},tooltip:{backgroundColor:'#0f172a',padding:9,cornerRadius:8,callbacks:{label:ctx=>` ${ctx.label}: ${fmt(ctx.raw)}`}}},
                    onClick: deviceKey ? (evt, elements) => {
                        if (!elements.length) return;
                        const idx = elements[0].index;
                        const lbl = labels[idx];
                        const statusVal = /online/i.test(lbl)?'online':'offline';
                        if (/online|offline/i.test(lbl)) drillStatus(deviceKey, statusVal);
                    } : undefined
                }
            });
        },50);
        return `<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:14px">
            <div style="font-size:11px;font-weight:700;color:#334155;margin-bottom:10px;text-transform:uppercase;letter-spacing:.06em">${title}</div>
            <div style="position:relative;height:${height||150}px"><canvas id="${id}" role="img" aria-label="${title}"></canvas></div>
            <div style="display:flex;flex-direction:column;gap:5px;margin-top:10px">${lgd}</div>
        </div>`;
    }

    /* location bar list */

    const body = document.getElementById('kpiModalBody');
    const modal = document.getElementById('kpiModal');

    /* ═══════════ REGIONS ═══════════ */
    if (key==='regions') {
        const wh=s.warehouses||0, whH=s.wh_healthy||0, whD=s.wh_down||0, whO=Math.max(0,wh-whH-whD);
        const hp=pct(whH,wh);
        const allOn  = (s.nvr_online||0)+(s.cam_online||0)+(s.bts_online||0)+(s.epc_online||0)+(s.ws_online||0);
        const allOff = (s.nvr_offline||0)+(s.cam_offline||0)+(s.bts_offline||0)+(s.epc_offline||0)+(s.ws_offline||0);
        sumRow.innerHTML = sumPill('Regions',fmt(s.regions??0),null)+sumPill('Warehouses',fmt(wh),null)+sumPill('NVR offline',fmt(s.nvr_offline||0),null)+sumPill('BTS offline',fmt(s.bts_offline||0),null);
        body.innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
            ${donut('_km1',['Healthy','Down','Partial'],[whH,whD,whO],['#22c55e','#ef4444','#d1d5db'],'Warehouse health')}
            ${donut('_km2',['NVR','Camera','BTS','Embedded PC','Workstation'],[s.nvr_total||0,s.cam_total||0,s.bts_total||0,s.epc_total||0,s.ws_total||0],['#3b82f6','#6366f1','#10b981','#f59e0b','#a855f7'],'Devices by type')}
        </div>
        <div style="font-size:10.5px;color:#94a3b8;margin:-6px 0 14px;line-height:1.5">"Partial" = warehouses that are neither fully healthy nor fully down (some devices online, some offline). Total devices online across all types: ${fmt(allOn)} · offline: ${fmt(allOff)}.</div>
        ${locCard('Offline devices by region','_kmList')}`;
        fetch(NMS_BASE+'/regions').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
            const regs=(res?.data||res||[]).sort((a,b)=>(b.offline_devices||0)-(a.offline_devices||0));
            const mx=Math.max(...regs.map(r=>r.offline_devices||0),1);
            if(!regs.length){fill('_kmList','<div style="padding:14px;text-align:center;color:#22c55e;font-size:12px">All regions online</div>');return;}
            fill('_kmList', locTable(regs.map(r=>({
                lbl:r.region_name||'—',
                tot:(r.total_devices||0),
                on: (r.online_devices||0),
                off:(r.offline_devices||0),
                sub:(r.total_warehouses||0)+' warehouses',
                regionId:r.region_id||r.id||'',
            })),'nvr'));
        });
        modal.style.display='flex'; document.body.style.overflow='hidden'; return;
    }

    /* ═══════════ WAREHOUSES ═══════════ */
    if (key==='warehouses') {
        const nP=pct(s.nvr_online||0,s.nvr_total||0), bP=pct(s.bts_online||0,s.bts_total||0);
        sumRow.innerHTML = sumPill('Warehouses',fmt(s.warehouses||0),null)
            + sumPill('NVR online', fmt(s.nvr_online||0), null, "drillStatus('nvr','online')")
            + sumPill('BTS online', fmt(s.bts_online||0), null, "drillStatus('bts','online')")
            + sumPill('Total offline',fmt((s.nvr_offline||0)+(s.bts_offline||0)),'NVR+BTS');
        body.innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
            ${donut('_km1',['NVR online','NVR offline'],[s.nvr_online||0,s.nvr_offline||0],['#3b82f6','#f87171'],'NVR status',150,'nvr')}
            ${donut('_km2',['BTS online','BTS offline'],[s.bts_online||0,s.bts_offline||0],['#22c55e','#f87171'],'BTS status',150,'bts')}
        </div>
        ${locCard('Warehouses with offline devices','_kmList')}`;
        /* Use warehouse list to group offline devices by region — accurate counts */
        fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
            const whs=res?.data||[];
            const fieldOff={nvr:'nvr_offline',bts:'bts_offline',epc:'epc_offline',ws:'ws_offline'};
            /* Group by region */
            const regMap={};
            whs.forEach(w=>{
                const rn=w.region_name||'—', rid=w.region_id||'';
                const offCount=Object.values(fieldOff).reduce((s,f)=>s+(w[f]||0),0);
                if(!regMap[rn]) regMap[rn]={r:rn,rid,wh:new Set(),n:0};
                regMap[rn].wh.add(w.warehouse_name);
                regMap[rn].n+=offCount;
            });
            const sorted=Object.values(regMap).filter(r=>r.n>0).sort((a,b)=>b.n-a.n);
            const mx=Math.max(...sorted.map(r=>r.n),1);
            if(!sorted.length){fill('_kmList','<div style="padding:14px;text-align:center;color:#22c55e;font-size:12px">All devices online</div>');return;}
            fill('_kmList',locList(sorted.map(r=>({lbl:r.r,val:r.n,sub:`${r.wh.size} warehouse${r.wh.size!==1?'s':''}`,color:r.n>=10?'#ef4444':r.n>=5?'#f59e0b':'#fb923c',region:r.r,regionId:r.rid})),mx,'nvr'));
        });
        modal.style.display='flex'; document.body.style.overflow='hidden'; return;
    }

    /* ═══════════ DEVICE KPIs ═══════════ */
    const DC={
        nvr:{tot:s.nvr_total||0,on:s.nvr_online||0,off:s.nvr_offline||0,c1:'#3b82f6',type:'nvr',lbl:'NVR'},
        cam:{tot:s.cam_total||0,on:s.cam_online||0,off:s.cam_offline||0,c1:'#6366f1',type:'camera',lbl:'camera'},
        bts:{tot:s.bts_total||0,on:s.bts_online||0,off:s.bts_offline||0,c1:'#22c55e',type:'bts',lbl:'BTS'},
        epc:{tot:s.epc_total||0,on:s.epc_online||0,off:s.epc_offline||0,c1:'#f59e0b',type:'embedded pc',lbl:'Embedded PC'},
        ws: {tot:s.ws_total||0, on:s.ws_online||0,  off:s.ws_offline||0, c1:'#a78bfa',type:'workstation',lbl:'Workstation'},
    };
    const dc=DC[key];
    if (dc) {
        const hp=pct(dc.on,dc.tot), hc=uC(hp);
        const ex=key==='ws' ?sumPill('Configured','…',null,"openConfiguredWh()")
              :'';
        sumRow.innerHTML = sumPill('Total',fmt(dc.tot),null)
            + sumPill('Online', fmt(dc.on),  null, `drillStatus('${key}','online')`)
            + sumPill('Offline',fmt(dc.off), null,      `drillStatus('${key}','offline')`)
            + ex;
        body.innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
            ${donut('_km1',['Online','Offline'],[dc.on,dc.off],[dc.c1,'#f87171'],dc.lbl+' status',150,key)}
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;display:flex;flex-direction:column;gap:10px;justify-content:center">
                <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:4px">${dc.lbl} Summary</div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Total</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#1e293b">${fmt(dc.tot)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Online</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#059669">${fmt(dc.on)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Offline</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#dc2626">${fmt(dc.off)}</span>
                </div>
            </div>
        </div>
        ${locCard(key==='ws' ? 'Workstation Status by Warehouse' : dc.lbl+' by region','_kmList')}`;

        /* Pre-load configured warehouse count for WS pill */
        if (key==='ws') {
            fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
                const count = (res?.data||[]).filter(w=>w.is_active===true||w.is_active===1).length;
                document.querySelectorAll('#kpiModalSummaryRow > div').forEach(pill=>{
                    const divs=pill.querySelectorAll('div');
                    if(divs[0]&&divs[0].textContent.trim()==='Configured'&&divs[1]) divs[1].textContent=fmtN(count);
                });
            });
        }

        if (key==='cam') {
            /* Use CAM_BY_WH for accurate per-region camera counts */
            fetch(CAM_BY_WH).then(r=>r.ok?r.json():null).catch(()=>null).then(camJ=>{
                const rows = camJ?.data||[];
                /* Group by region */
                const regMap={};
                rows.forEach(row=>{
                    const rn=row.region||'—';
                    if(!regMap[rn]) regMap[rn]={region:rn,total:0,online:0,offline:0};
                    regMap[rn].total   += row.total_cameras  ||0;
                    regMap[rn].online  += row.online_cameras ||0;
                    regMap[rn].offline += row.offline_cameras||0;
                });
                const regions=Object.values(regMap).sort((a,b)=>b.offline-a.offline);
                const mx=Math.max(...regions.map(r=>r.offline),1);
                if(!regions.length){fill('_kmList','<div style="padding:14px;text-align:center;color:#22c55e;font-size:12px">No camera data</div>');return;}
                fill('_kmList', locTable(regions.map(r=>({
                    lbl:r.region, tot:r.total, on:r.online, off:r.offline, regionId:r.region,
                })),'cam'));
            });
        } else if (key==='ws') {
            fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
                const whs = res?.data||[];
                const wsWhs = whs.filter(w=>(w.ws_total||0)>0);

                const tsAgo = ts => {
                    if (!ts) return null;
                    const h = (new Date() - new Date(ts)) / 36e5;
                    if (h < 1)  return Math.round(h*60)+'m ago';
                    if (h < 24) return Math.round(h)+'h ago';
                    return Math.floor(h/24)+'d ago';
                };

                /* Recently went OFFLINE — all with ws_offline>0, sorted by timestamp then by count */
                const recentOff = wsWhs
                    .filter(w => (w.ws_offline||0) > 0)
                    .sort((a,b) => {
                        const ta = a.ws_last_offline_at ? new Date(a.ws_last_offline_at) : new Date(0);
                        const tb = b.ws_last_offline_at ? new Date(b.ws_last_offline_at) : new Date(0);
                        return tb - ta;
                    })
                    ;

                /* Recently came ONLINE — all with ws_online>0, sorted by timestamp */
                const recentOn = wsWhs
                    .filter(w => (w.ws_online||0) > 0)
                    .sort((a,b) => {
                        const ta = a.ws_last_online_at ? new Date(a.ws_last_online_at) : new Date(0);
                        const tb = b.ws_last_online_at ? new Date(b.ws_last_online_at) : new Date(0);
                        return tb - ta;
                    })
                    ;

                const secStyle = 'font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;padding:10px 12px 6px;display:flex;align-items:center;gap:6px';

                const mkRows = (arr, tsKey) => {
                    if (!arr.length) return '<div style="padding:10px 12px;color:#94a3b8;font-size:12px">No data</div>';
                    const thStyle = 'background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:';
                    const tsLabel = tsKey==='ws_last_online_at'?'Last Online':tsKey==='ws_last_offline_at'?'Last Offline':'Status Changed At';
                    return `<table style="width:100%;border-collapse:collapse;font-size:12px">
                        <thead><tr>
                            <th style="${thStyle}left">Warehouse</th>
                            <th style="${thStyle}center">Total</th>
                            <th style="${thStyle}center">Online</th>
                            <th style="${thStyle}center">Offline</th>
                            <th style="${thStyle}left">${tsLabel}</th>
                        </tr></thead>
                        <tbody>${arr.map(w=>`<tr onclick="window.location.href='/nms/warehouses/${w.warehouse_id}';closeKpiModal()"
                            onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
                            style="cursor:pointer;transition:background .12s">
                            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8">
                                <div style="font-weight:700;display:flex;align-items:center;gap:3px">${w.warehouse_name}<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6"></i></div>
                                <div style="font-size:10px;color:#94a3b8">${w.region_name||'—'}</div>
                            </td>
                            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${w.ws_total||0}</td>
                            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${w.ws_online||0}</td>
                            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w.ws_offline||0)>0?'#dc2626':'#94a3b8'}">${w.ws_offline||0}</td>
                            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-size:11px;color:#475569;font-family:'IBM Plex Mono',monospace">${w[tsKey]?fmtDt(w[tsKey]):'—'}</td>
                        </tr>`).join('')}</tbody>
                    </table>`;
                };

                const el = document.getElementById('_kmList');
                if (el) el.innerHTML = `
                    <div style="display:flex;border-bottom:1.5px solid #e2e8f0;background:#f8fafc">
                        <button id="wsTabOff" onclick="wsShowTab('off')" style="flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#dc2626;border-bottom:2.5px solid #dc2626;cursor:pointer">
                            <i class="ri-close-circle-line"></i> Offline (${recentOff.length})
                        </button>
                        <button id="wsTabOn" onclick="wsShowTab('on')" style="flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer">
                            <i class="ri-checkbox-circle-line"></i> Online (${recentOn.length})
                        </button>
                    </div>
                    <div id="wsContentOff" style="max-height:280px;overflow-y:auto">${mkRows(recentOff,'ws_last_offline_at')}</div>
                    <div id="wsContentOn"  style="max-height:280px;overflow-y:auto;display:none">${mkRows(recentOn,'ws_last_online_at')}</div>`;

                const hdrEl = document.getElementById('_kmList_hdr');
                if (hdrEl) hdrEl.textContent = 'Recent Workstation Status Changes';
            });
        } else if (key==='epc') {
            fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
                const whs = res?.data||[];
                const epcWhs = whs.filter(w=>(w.epc_total||0)>0);
                const tsAgo = ts => { if(!ts)return null; const h=(new Date()-new Date(ts))/36e5; return h<1?Math.round(h*60)+'m ago':h<24?Math.round(h)+'h ago':Math.floor(h/24)+'d ago'; };
                const recentOff = epcWhs.filter(w=>(w.epc_offline||0)>0).sort((a,b)=>{const ta=a.epc_last_offline_at?new Date(a.epc_last_offline_at):new Date(0),tb=b.epc_last_offline_at?new Date(b.epc_last_offline_at):new Date(0);return tb-ta;});
                const recentOn  = epcWhs.filter(w=>(w.epc_online||0)>0).sort((a,b)=>{const ta=a.epc_last_online_at?new Date(a.epc_last_online_at):new Date(0),tb=b.epc_last_online_at?new Date(b.epc_last_online_at):new Date(0);return tb-ta;}).slice(0,50);
                const secStyle='font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;padding:10px 12px 6px;display:flex;align-items:center;gap:6px';
                const thS='background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:';
const mkRows=arr=>{if(!arr.length)return'<div style="padding:10px 12px;color:#94a3b8;font-size:12px">No data</div>';
return`<table style="width:100%;border-collapse:collapse;font-size:12px"><thead><tr>
<th style="${thS}left">Warehouse</th><th style="${thS}center">Total</th><th style="${thS}center">Online</th><th style="${thS}center">Offline</th><th style="${thS}left">Status Changed At</th>
</tr></thead><tbody>${arr.map(w=>`<tr onclick="window.location.href='/nms/warehouses/${w.warehouse_id}';closeKpiModal()" onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''" style="cursor:pointer;transition:background .12s">
<td style="padding:8px 12px;border-bottom:1px solid #f0f4f8"><div style="font-weight:700;display:flex;align-items:center;gap:3px">${w.warehouse_name}<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6"></i></div><div style="font-size:10px;color:#94a3b8">${w.region_name||'—'}</div></td>
<td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${w.epc_total||0}</td>
<td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${w.epc_online||0}</td>
<td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w.epc_offline||0)>0?'#dc2626':'#94a3b8'}">${w.epc_offline||0}</td>
<td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-size:11px;color:#475569;font-family:'IBM Plex Mono',monospace">${w.epc_status_changed_at?fmtDt(w.epc_status_changed_at):'—'}</td>
</tr>`).join('')}</tbody></table>`;};
                const el=document.getElementById('_kmList');
                const epcThStyle='background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:';
                const mkEpcRows=arr=>{if(!arr.length)return'<div style="padding:10px 12px;color:#94a3b8;font-size:12px">No data</div>';
                return`<table style="width:100%;border-collapse:collapse;font-size:12px"><thead><tr>
                <th style="${epcThStyle}left">Warehouse</th><th style="${epcThStyle}center">Total</th><th style="${epcThStyle}center">Online</th><th style="${epcThStyle}center">Offline</th><th style="${epcThStyle}left">Status Changed At</th>
                </tr></thead><tbody>${arr.map(w=>`<tr onclick="window.location.href='/nms/warehouses/${w.warehouse_id}';closeKpiModal()" onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''" style="cursor:pointer;transition:background .12s">
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8"><div style="font-weight:700;display:flex;align-items:center;gap:3px">${w.warehouse_name}<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6"></i></div><div style="font-size:10px;color:#94a3b8">${w.region_name||'—'}</div></td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${w.epc_total||0}</td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${w.epc_online||0}</td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w.epc_offline||0)>0?'#dc2626':'#94a3b8'}">${w.epc_offline||0}</td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-size:11px;color:#475569;font-family:'IBM Plex Mono',monospace">${w.epc_status_changed_at?fmtDt(w.epc_status_changed_at):'—'}</td>
                </tr>`).join('')}</tbody></table>`;};
                if(el) el.innerHTML=`<div style="display:flex;border-bottom:1.5px solid #e2e8f0;background:#f8fafc"><button id="epcTabOff" onclick="epcShowTab('off')" style="flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#dc2626;border-bottom:2.5px solid #dc2626;cursor:pointer"><i class="ri-close-circle-line"></i> Offline (${recentOff.length})</button><button id="epcTabOn" onclick="epcShowTab('on')" style="flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer"><i class="ri-checkbox-circle-line"></i> Online (${recentOn.length})</button></div><div id="epcContentOff" style="max-height:280px;overflow-y:auto">${mkEpcRows(recentOff)}</div><div id="epcContentOff" style="max-height:280px;overflow-y:auto;display:none">${mkEpcRows(recentOn)}</div>`;
                const hdrEl=document.getElementById('_kmList_hdr'); if(hdrEl) hdrEl.textContent='Recent EPC Status Changes';
            });
        } else {
            fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
                const whs=res?.data||[];
                const fTot={nvr:'nvr_total',bts:'bts_total',epc:'epc_total',ws:'ws_total',cam:'total_cameras'}[key]||'nvr_total';
                const fOn ={nvr:'nvr_online',bts:'bts_online',epc:'epc_online',ws:'ws_online',cam:'online_cameras'}[key]||'nvr_online';
                const fOff={nvr:'nvr_offline',bts:'bts_offline',epc:'epc_offline',ws:'ws_offline',cam:'offline_cameras'}[key]||'nvr_offline';
                const map={}; whs.forEach(w=>{
                    const rn=w.region_name||'?', rid=w.region_id||'';
                    const tot=w[fTot]||0; if(!tot) return;
                    if(!map[rn]) map[rn]={r:rn,rid,wh:new Set(),tot:0,on:0,off:0};
                    map[rn].tot+=tot; map[rn].on+=w[fOn]||0; map[rn].off+=w[fOff]||0;
                    map[rn].wh.add(w.warehouse_name||'');
                });
                const sorted=Object.values(map).sort((a,b)=>b.off-a.off);
                if(!sorted.length){fill('_kmList',`<div style="padding:14px;text-align:center;color:#22c55e;font-size:12px">No ${dc.lbl} data</div>`);return;}
                fill('_kmList', locTable(sorted.map(x=>({lbl:x.r,tot:x.tot,on:x.on,off:x.off,sub:x.wh.size+' warehouse'+(x.wh.size!==1?'s':''),regionId:x.rid||''})),key));
            });
        }
        modal.style.display='flex'; document.body.style.overflow='hidden'; return;
    }

    /* ═══════════ CPE ═══════════ */
    if (key==='cpe') {
        const bC  = s.bts_clients||0;
        const cpeOff = Math.max(0, 913 - bC);
        sumRow.innerHTML = sumPill('Total CPE','913',null)
            + sumPill('Connected', fmt(bC),    null)
            + sumPill('Offline',   fmt(cpeOff), null);
        body.innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
            ${donut('_km1',['Connected','Offline'],[bC,cpeOff],['#0891b2','#f87171'],'CPE Status')}
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;display:flex;flex-direction:column;gap:10px;justify-content:center">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:4px">CPE Summary</div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Total CPE</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#1e293b">913</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Connected</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#059669">${fmt(bC)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Offline CPE</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#dc2626">${fmt(cpeOff)}</span>
                </div>
            </div>
        </div>
        `; /* CPE location table hidden */
        fetch(NMS_BASE+'/warehouses').then(r=>r.ok?r.json():null).catch(()=>null).then(res=>{
            const whs = res?.data || res || [];
            /* sum bts_clients per region from warehouse list */
            const regMap = {};
            whs.forEach(w => {
                const rn = w.region_name||'?', rid = w.region_id||'';
                if (!regMap[rn]) regMap[rn] = {lbl:rn, rid, wh:0, btsC:0, btsT:0};
                regMap[rn].wh++;
                regMap[rn].btsC += w.bts_clients||0;
                regMap[rn].btsT += w.bts_total||0;
            });
            const regs = Object.values(regMap).filter(r=>r.btsC>0).sort((a,b)=>b.btsC-a.btsC).slice(0,14);
            const mx = Math.max(...regs.map(r=>r.btsC),1);
            fill('_kmList', regs.length
                ? locTable(regs.map(r=>({lbl:r.lbl,tot:r.btsC,on:r.btsC,off:0,sub:r.wh+' WH · '+r.btsT+' BTS',regionId:r.rid})),'cpe')
                : '<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No BTS client data</div>');
        });
        modal.style.display='flex'; document.body.style.overflow='hidden'; return;
    }

    /* ═══════════ CO2 / PH3 ═══════════ */
    if (key==='co2'||key==='ph3') {
        const isCO2 = key==='co2';
        const gas   = isCO2?'CO₂':'PH₃';

        /* Counts from gData (Ajeevi) */
        let tot=0, on=0, off=0;
        if (window.__gData?.overall) {
            const o=window.__gData.overall;
            on  = isCO2?(o.totalOnlineCO2||0)  :(o.totalOnlinePH3||0);
            off = isCO2?(o.totalOfflineCO2||0) :(o.totalOfflinePH3||0);
            tot = on + off;
        } else {
            try{ const kd=JSON.parse(localStorage.getItem('cwc_gas_kpi')||'null');
                if(kd){tot=isCO2?kd.co2Total:kd.ph3Total;on=isCO2?kd.co2Online:kd.ph3Online;off=isCO2?kd.co2Off:kd.ph3Off;}}catch(_){}
        }

        sumRow.innerHTML = sumPill('Total Sensors',fmt(tot),null)
            + sumPill('Online', fmt(on), null)
            + sumPill('Offline',fmt(off),null);

        body.innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
            ${donut('_km1',['Online','Offline'],[on,off],['#3b82f6','#f87171'],gas+' Sensor Status')}
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;display:flex;flex-direction:column;gap:10px;justify-content:center">
                <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:4px">${gas} Sensors</div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Total Sensors</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#1e293b">${fmt(tot)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Online</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#059669">${fmt(on)}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;background:#fff;border-radius:8px;border:1px solid #e2e8f0">
                    <span style="font-size:12px;font-weight:600;color:#475569">Offline</span>
                    <span style="font-family:'IBM Plex Mono',monospace;font-size:18px;font-weight:800;color:#dc2626">${fmt(off)}</span>
                </div>
            </div>
        </div>
        ${locCard(gas+' sensors by location','_kmList')}`;

        /* Build location-wise sensor table from gData */
        const renderSensorLocs = function(res) {
            if (!res?.locationWise) { fill('_kmList','<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No location data</div>'); return; }
            const rows = Object.entries(res.locationWise).map(([k,loc])=>{
                const on  = isCO2?(loc.onlineCO2||0) :(loc.onlinePH3||0);
                const off = isCO2?(loc.offlineCO2||0):(loc.offlinePH3||0);
                const tot = on+off;
                return {name:loc.locationName||k, state:loc.state||'—', on, off, tot};
            }).filter(r=>r.tot>0).sort((a,b)=>b.tot-a.tot);
            if(!rows.length){fill('_kmList',`<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No ${gas} sensor locations found</div>`);return;}
            fill('_kmList', locTable(rows.map(r=>({lbl:r.name,sub:r.state,tot:r.tot,on:r.on,off:r.off})), key));
        };
        if (window.__gData) { renderSensorLocs(window.__gData); }
        else { fetch('<?php echo e(config("external-apis.co2_summary")); ?>').then(r=>r.ok?r.json():null).catch(()=>null).then(renderSensorLocs); }
        modal.style.display='flex'; document.body.style.overflow='hidden'; return;
    }

    modal.style.display='flex'; document.body.style.overflow='hidden';
}


function locList(rows, maxV, deviceKey) {
    const mx = maxV || Math.max(...rows.map(r=>r.val||0), 1);
    return rows.map(r => {
        const w = Math.round((r.val||0)/mx*100);
        const drillable = !!r.region;
        const dattr = drillable ? ` data-region="${r.region.replace(/"/g,'&quot;')}" data-dkey="${deviceKey||''}"` : '';
        const dclick = drillable ? ` onclick="drillRegion(this.dataset.region,this.dataset.dkey)" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background=''"` : '';
        return `<div style="padding:8px 14px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;cursor:${drillable?'pointer':'default'};transition:background .12s"${dattr}${dclick}>
            <div style="min-width:120px;flex-shrink:0">
                <div style="font-size:12px;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:4px">
                    ${r.lbl}${drillable?`<i class="ri-arrow-right-s-line" style="font-size:13px;color:#3b82f6"></i>`:''}
                </div>
                ${r.sub?`<div style="font-size:10px;color:#94a3b8;margin-top:1px">${r.sub}</div>`:''}
            </div>
            <div style="flex:1;height:8px;background:#f1f5f9;border-radius:4px;overflow:hidden">
                <div style="height:100%;border-radius:4px;background:${r.color||'#3b82f6'};width:${w}%;transition:width .4s"></div>
            </div>
            <span style="font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:800;color:${r.color||'#3b82f6'};min-width:42px;text-align:right">${fmtN(r.val||0)}</span>
        </div>`;
    }).join('');
}

function locTable(rows, deviceKey) {
    if (!rows.length) return '<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No data</div>';
    const esc = s => (s||'').replace(/'/g,"&#39;");
    return `<table style="width:100%;border-collapse:collapse;font-size:12px">
        <thead><tr>
            <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:left">Location</th>
            <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:center">Total</th>
            <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:center">Online</th>
            <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:center">Offline</th>
        </tr></thead>
        <tbody>
        ${rows.map(r => {
            const isReg = r.regionId !== undefined && !r.id;
            const isWH  = !!r.id;
            let attr = '';
            if (isReg && r.regionId) {
                attr = `data-rname="${esc(r.lbl)}" data-dkey="${deviceKey||''}" data-rid="${r.regionId}"
                    onclick="drillRegion(this.dataset.rname,this.dataset.dkey,this.dataset.rid)"
                    onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
                    style="cursor:pointer;transition:background .12s"`;
            } else if (isWH) {
                attr = `data-wid="${r.id}"
                    onclick="window.location.href='/nms/warehouses/'+this.dataset.wid;closeKpiModal()"
                    onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
                    style="cursor:pointer;transition:background .12s"`;
            }
            const arrow = (isReg||isWH) ? '<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6;margin-left:3px;vertical-align:middle"></i>' : '';
            return `<tr ${attr}>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8">
                    <div style="font-weight:700;display:flex;align-items:center">${r.lbl||'—'}${arrow}</div>
                    ${r.sub ? `<div style="font-size:10px;color:#94a3b8">${r.sub}</div>` : ''}
                </td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${fmtN(r.tot||0)}</td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${fmtN(r.on||0)}</td>
                <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(r.off||0)>0?'#dc2626':'#94a3b8'}">${fmtN(r.off||0)}</td>
            </tr>`;
        }).join('')}
        </tbody>
    </table>`;
}

async function drillStatus(deviceKey, status) {
    const listEl = document.getElementById('_kmList');
    if (!listEl) return;
    const label = status === 'online' ? 'Online' : 'Offline';
    const deviceLabel = {nvr:'NVR',cam:'Camera',bts:'BTS',epc:'Embedded PC',ws:'Workstation',cpe:'BTS'}[deviceKey] || deviceKey.toUpperCase();
    listEl.innerHTML = `<div style="padding:16px;text-align:center;color:#94a3b8;font-size:12px"><i class="ri-loader-4-line" style="animation:spin 1s linear infinite;margin-right:4px"></i>Loading ${label} ${deviceLabel} warehouses…</div>`;
    const hdrEl = document.getElementById('_kmList_hdr');
    if (hdrEl) {
        hdrEl.innerHTML = '<div style="display:flex;align-items:center;gap:8px">'
            + `<button data-key="${deviceKey}" onclick="openKpiModal(this.dataset.key)" style="display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border:1.5px solid #e2e8f0;border-radius:6px;background:#fff;font-size:11px;font-weight:700;color:#475569;cursor:pointer"><i class="ri-arrow-left-s-line"></i> Back</button>`
            + `<span style="font-size:11px;font-weight:800;color:${status==='online'?'#059669':'#dc2626'};text-transform:uppercase;letter-spacing:.06em">${label} ${deviceLabel}</span>`
            + '</div>';
    }
    try {
        /* For cameras use CAM_BY_WH + NMS list to get warehouse_id */
        let whs = [];
        if (deviceKey === 'cam') {
            /* Use CAM_BY_WH — uuid field maps to NMS warehouse_id */
            const camR  = await fetch(CAM_BY_WH);
            const camRows = (await camR.json()).data || [];
            const whMap={};
            camRows.forEach(row=>{
                const k=row.warehouse||'—';
                if(!whMap[k]) whMap[k]={warehouse_name:k,region_name:row.region||'—',warehouse_id:row.uuid||null,total_cameras:0,online_cameras:0,offline_cameras:0,last_synced_at:null};
                whMap[k].total_cameras   +=row.total_cameras  ||0;
                whMap[k].online_cameras  +=row.online_cameras ||0;
                whMap[k].offline_cameras +=row.offline_cameras||0;
                if(row.last_synced_at&&(!whMap[k].last_synced_at||row.last_synced_at>whMap[k].last_synced_at))
                    whMap[k].last_synced_at=row.last_synced_at;
            });
            whs=Object.values(whMap);
        } else {
            const r = await fetch(`${NMS_BASE}/warehouses`);
            whs = (await r.json()).data || [];
        }
        const fieldOn  = {nvr:'nvr_online',cam:'online_cameras',bts:'bts_online',epc:'epc_online',ws:'ws_online',cpe:'bts_online'}[deviceKey]||'nvr_online';
        const fieldTot = {nvr:'nvr_total', cam:'total_cameras', bts:'bts_total', epc:'epc_total', ws:'ws_total', cpe:'bts_total'}[deviceKey]||'nvr_total';
        const fieldOff = {nvr:'nvr_offline',cam:'offline_cameras',bts:'bts_offline',epc:'epc_offline',ws:'ws_offline',cpe:'bts_offline'}[deviceKey]||'nvr_offline';
        const col  = {nvr:'#3b82f6',cam:'#6366f1',bts:'#22c55e',epc:'#f59e0b',ws:'#a78bfa',cpe:'#0891b2'}[deviceKey]||'#3b82f6';

        const filtered = whs.filter(w => {
            const tot = w[fieldTot]||0, on = w[fieldOn]||0, off = w[fieldOff]||0;
            if (tot === 0) return false;
            return status === 'online' ? on > 0 : off > 0;
        }).sort((a,b) => {
            /* For WS/EPC sort by status_changed_at latest first, others by count */
            if (deviceKey==='ws')  { const ta=new Date(a.ws_status_changed_at||0),tb=new Date(b.ws_status_changed_at||0); return tb-ta; }
            if (deviceKey==='epc') { const ta=new Date(a.epc_status_changed_at||0),tb=new Date(b.epc_status_changed_at||0); return tb-ta; }
            return status==='online' ? (b[fieldOn]||0)-(a[fieldOn]||0) : (b[fieldOff]||0)-(a[fieldOff]||0);
        });

        if (!filtered.length) {
            listEl.innerHTML = `<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No ${label.toLowerCase()} ${deviceLabel} found</div>`;
            return;
        }

        if (deviceKey==='ws' || deviceKey==='epc') {
            const tsField   = deviceKey==='ws' ? 'ws_status_changed_at'  : 'epc_status_changed_at';
            const lastOnF   = deviceKey==='ws' ? 'ws_last_online_at'     : 'epc_last_online_at';
            const lastOffF  = deviceKey==='ws' ? 'ws_last_offline_at'    : 'epc_last_offline_at';
            listEl.innerHTML = `<table style="width:100%;border-collapse:collapse;font-size:12px">
                <thead><tr>
                    <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:left">Warehouse</th>
                    <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:center">Total</th>
                    <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:center">Online</th>
                    <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:center">Offline</th>
                    <th style="background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:left">Status Changed At</th>
                </tr></thead>
                <tbody>${filtered.map(w=>{
                    const ts = w[tsField] || '—';
                    return `<tr data-wid="${w.warehouse_id}"
                        onclick="window.location.href='/nms/warehouses/${w.warehouse_id}';closeKpiModal()"
                        onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
                        style="cursor:pointer;transition:background .12s">
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8">
                            <div style="font-weight:700;display:flex;align-items:center;gap:4px">${w.warehouse_name}<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6"></i></div>
                            <div style="font-size:10px;color:#94a3b8">${w.region_name||'—'}</div>
                        </td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${fmtN(w[fieldTot]||0)}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${fmtN(w[fieldOn]||0)}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w[fieldOff]||0)>0?'#dc2626':'#94a3b8'}">${fmtN(w[fieldOff]||0)}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-size:11px;color:#475569;font-family:'IBM Plex Mono',monospace">${ts!=='—'?fmtDt(ts):'—'}</td>
                    </tr>`;
                }).join('')}</tbody>
            </table>`;
        } else {
            listEl.innerHTML = locTable(filtered.map(w=>({
                lbl: w.warehouse_name,
                sub: w.region_name||'—',
                tot: w[fieldTot]||0,
                on:  w[fieldOn]||0,
                off: w[fieldOff]||0,
                id:  deviceKey==='cam' ? undefined : w.warehouse_id,
            })), deviceKey);
        }
    } catch(e) {
        console.error('[drillStatus] error:', e);
        listEl.innerHTML = `<div style="padding:14px;text-align:center;color:#ef4444;font-size:12px">Error: ${e.message}</div>`;
    }
}

async function drillRegion(regionName, deviceKey, regionId) {
    const listEl = document.getElementById('_kmList');
    if (!listEl) return;
    listEl.innerHTML = `<div style="padding:16px;text-align:center;color:#94a3b8;font-size:12px"><i class="ri-loader-4-line" style="animation:spin 1s linear infinite;margin-right:4px"></i>Loading warehouses in ${regionName}…</div>`;
    const hdrEl = document.getElementById('_kmList_hdr');
    if (hdrEl) {
        hdrEl.innerHTML = '<div style="display:flex;align-items:center;gap:8px">'
            + '<button data-key="'+deviceKey+'" onclick="openKpiModal(this.dataset.key)" style="display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border:1.5px solid #e2e8f0;border-radius:6px;background:#fff;font-size:11px;font-weight:700;color:#475569;cursor:pointer">'
            + '<i class="ri-arrow-left-s-line"></i> Back</button>'
            + '<span style="font-size:11px;font-weight:800;color:#334155;text-transform:uppercase;letter-spacing:.06em">'
            + '<i class="ri-map-pin-2-line" style="color:#3b82f6;font-size:12px"></i> ' + regionName
            + '</span></div>';
    }
    try {
        /* Resolve region_id — use passed value or look up from regions API */
        let rid = regionId && String(regionId).trim() !== '' ? regionId : null;
        if (!rid && deviceKey !== 'cam') {
            const rr = await fetch(`${NMS_BASE}/regions`);
            const rj = await rr.json();
            const regs = rj.data || [];
            const match = regs.find(r => (r.region_name||'').toLowerCase() === regionName.toLowerCase());
            rid = match?.region_id || match?.id || null;
        }
        if (!rid && deviceKey !== 'cam') { listEl.innerHTML=`<div style="padding:14px;text-align:center;color:#ef4444;font-size:12px">Could not resolve region ID for "${regionName}"</div>`; return; }

        let whs = [];
        if (deviceKey === 'cam') {
            /* Camera drill uses CAM_BY_WH filtered by region */
            const cr = await fetch(CAM_BY_WH);
            const cj = await cr.json();
            console.log('[CAM drill] regionName:', regionName, '| sample regions:', [...new Set((cj.data||[]).map(r=>r.region))].slice(0,5));
            const camRows = (cj.data||[]).filter(row=>(row.region||'').toUpperCase().trim() === (regionName||'').toUpperCase().trim());
            const whMap = {};
            camRows.forEach(row=>{
                const k=row.warehouse||'—';
                if(!whMap[k]) whMap[k]={warehouse_name:k,region_name:row.region||'—',warehouse_id:k,total_cameras:0,online_cameras:0,offline_cameras:0,last_synced_at:row.last_synced_at||null};
                whMap[k].total_cameras   +=row.total_cameras  ||0;
                whMap[k].online_cameras  +=row.online_cameras ||0;
                whMap[k].offline_cameras +=row.offline_cameras||0;
                if(row.last_synced_at&&(!whMap[k].last_synced_at||row.last_synced_at>whMap[k].last_synced_at)) whMap[k].last_synced_at=row.last_synced_at;
            });
            whs = Object.values(whMap);
            /* Camera — show non-navigating table and return early */
            whs.sort((a,b)=>(b.offline_cameras||0)-(a.offline_cameras||0));
            const thS='background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:';
            listEl.innerHTML = whs.length
                ? `<table style="width:100%;border-collapse:collapse;font-size:12px">
                    <thead><tr>
                        <th style="${thS}left">Warehouse</th>
                        <th style="${thS}center">Total</th>
                        <th style="${thS}center">Online</th>
                        <th style="${thS}center">Offline</th>
                    </tr></thead>
                    <tbody>${whs.map(w=>`<tr>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-weight:700">${w.warehouse_name}<div style="font-size:10px;color:#94a3b8">${w.region_name||'—'}</div></td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${w.total_cameras}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${w.online_cameras}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w.offline_cameras||0)>0?'#dc2626':'#94a3b8'}">${w.offline_cameras}</td>
                    </tr>`).join('')}</tbody>
                </table>`
                : `<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No camera data for ${regionName}</div>`;
            return;
        } else {
            const r = await fetch(`${NMS_BASE}/warehouses?region_id=${rid}`);
            const j = await r.json();
            whs = Array.isArray(j.data)?j.data:(Array.isArray(j)?j:[]);
        }
        if (!whs.length) { listEl.innerHTML=`<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">No warehouses found</div>`; return; }

        const noPerWhNote = '';

        const rows = whs.map(w => {
            const camT=w.total_cameras||0,camOn=w.online_cameras||0,camOff=w.offline_cameras||0;
            const nvrT=w.nvr_total||0,nvrOn=w.nvr_online||0,nvrOff=w.nvr_offline||0;
            const btsT=w.bts_total||0,btsOn=w.bts_online||0,btsOff=w.bts_offline||0,btsC=w.bts_clients||0;
            const epcT=w.epc_total||0,epcOn=w.epc_online||0,epcOff=w.epc_offline||0;
            const wsT=w.ws_total||0,wsOn=w.ws_online||0,wsOff=w.ws_offline||0;
            let tot,on,off,sub='';
            if      (deviceKey==='cam') {tot=camT;on=camOn;off=camOff;}
            else if (deviceKey==='nvr') {tot=nvrT;on=nvrOn;off=nvrOff;}
            else if (deviceKey==='bts') {tot=btsT;on=btsOn;off=btsOff;sub=btsC+' clients';}
            else if (deviceKey==='cpe') {tot=btsC;on=btsC;off=0;sub=btsT+' BTS radios';}
            else if (deviceKey==='epc') {tot=epcT;on=epcOn;off=epcOff;}
            else if (deviceKey==='ws')  {tot=wsT; on=wsOn; off=wsOff;}
            else                        {tot=nvrT;on=nvrOn;off=nvrOff;}
            return {lbl:w.warehouse_name||'—',tot:tot||0,on:on||0,off:off||0,sub,id:w.warehouse_id};
        }).sort((a,b)=>(b.off||0)-(a.off||0));

        listEl.innerHTML = locTable(rows, deviceKey);
    } catch(e) {
        listEl.innerHTML=`<div style="padding:14px;text-align:center;color:#ef4444;font-size:12px">Failed to load warehouses</div>`;
    }
}

function filterLocTable(id, q) {
    const el = document.getElementById(id);
    if (!el) return;
    const ql = q.toLowerCase().trim();
    /* Search all tr in the container (handles nested tab divs too) */
    el.querySelectorAll('tbody tr').forEach(tr => {
        tr.style.display = !ql || tr.textContent.toLowerCase().includes(ql) ? '' : 'none';
    });
    /* Also search inside tab content divs (ws/epc/cw tabs) */
    ['wsContentOff','wsContentOn','epcContentOff','epcContentOn','cwContentOff','cwContentOn'].forEach(tabId => {
        const tab = document.getElementById(tabId);
        if (!tab || !el.contains(tab)) return;
        tab.querySelectorAll('tbody tr').forEach(tr => {
            tr.style.display = !ql || tr.textContent.toLowerCase().includes(ql) ? '' : 'none';
        });
    });
}

function exportLocTable(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const hdrEl = document.getElementById(id+'_hdr');
    const title = hdrEl ? hdrEl.textContent.trim() : 'Export';

    /* Find the visible table — check active tab first */
    let tbl = null;
    ['wsContentOff','wsContentOn','epcContentOff','epcContentOn','cwContentOff','cwContentOn'].forEach(tabId => {
        const tab = document.getElementById(tabId);
        if (tab && tab.style.display !== 'none' && el.contains(tab)) {
            const t = tab.querySelector('table');
            if (t) tbl = t;
        }
    });
    if (!tbl) tbl = el.querySelector('table');
    if (!tbl) { alert('No table data to export.'); return; }

    const rows = [];
    tbl.querySelectorAll('thead tr').forEach(tr => {
        const hdrs = [...tr.querySelectorAll('th')].map(th=>th.textContent.trim());
        // If first col is Location/Warehouse and has sub-divs, add Region column after it
        const firstTd = tbl.querySelector('tbody tr td:first-child');
        if (firstTd && firstTd.querySelector('div:nth-child(2)')) {
            hdrs.splice(1, 0, 'Region');
        }
        rows.push(hdrs);
    });
    tbl.querySelectorAll('tbody tr').forEach(tr => {
        if (tr.style.display === 'none') return;
        const cells = [...tr.querySelectorAll('td')].map((td, i) => {
            if (i === 0) {
                const main = td.querySelector('div:first-child');
                const sub  = td.querySelector('div:nth-child(2)');
                if (sub) return [main ? main.textContent.trim() : td.textContent.trim(), sub.textContent.trim()];
                return [td.textContent.trim()];
            }
            return [td.textContent.trim()];
        }).flat();
        rows.push(cells);
    });
    const csv = rows.map(r => r.map(v => '"'+String(v).replace(/"/g,'""')+'"').join(',')).join('\n');
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob(['\uFEFF'+csv], {type:'text/csv;charset=utf-8;'}));
    a.download = title.replace(/[^a-z0-9]/gi,'_')+'_'+new Date().toISOString().slice(0,10)+'.csv';
    a.click();
    URL.revokeObjectURL(a.href);
}

function locCard(title, loaderId) {
    return `<div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden">
        <div style="padding:10px 14px;background:#f8fafc;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap">
            <div id="${loaderId}_hdr" style="font-size:11px;font-weight:700;color:#334155;text-transform:uppercase;letter-spacing:.06em">${title}</div>
            <div style="display:flex;align-items:center;gap:6px">
                <div style="position:relative">
                    <i class="ri-search-line" style="position:absolute;left:8px;top:50%;transform:translateY(-50%);font-size:12px;color:#94a3b8;pointer-events:none"></i>
                    <input type="text" placeholder="Search…" oninput="filterLocTable('${loaderId}',this.value)"
                        style="padding:5px 10px 5px 26px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:11px;color:#1e293b;outline:none;width:150px;font-family:inherit"
                        onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <button onclick="exportLocTable('${loaderId}')"
                    style="display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:linear-gradient(135deg,#1e3a8a,#2563eb);color:#fff;border:none;border-radius:7px;font-size:11px;font-weight:600;cursor:pointer">
                    <i class="ri-file-excel-line"></i> Export
                </button>
            </div>
        </div>
        <div id="${loaderId}" style="max-height:300px;overflow-y:auto">
            <div style="padding:20px;text-align:center;color:#94a3b8;font-size:12px"><i class="ri-loader-4-line" style="animation:spin 1s linear infinite;margin-right:4px"></i>Loading…</div>
        </div>
    </div>`;
}
function fill(id, html) { const el=document.getElementById(id); if(el) el.innerHTML=html; }



async function openConfiguredWh() {
    const hdrEl = document.getElementById('_kmList_hdr');
    if (hdrEl) hdrEl.textContent = 'Configured Warehouses';
    const listEl = document.getElementById('_kmList');
    if (!listEl) return;
    listEl.innerHTML = '<div style="padding:16px;text-align:center;color:#94a3b8;font-size:12px"><i class="ri-loader-4-line" style="animation:spin 1s linear infinite;margin-right:4px"></i>Loading\u2026</div>';
    try {
        const r   = await fetch(`${NMS_BASE}/warehouses`);
        const whs = (await r.json()).data || [];
        const active   = whs.filter(w => w.is_active === true  || w.is_active === 1);
        const inactive = whs.filter(w => w.is_active === false || w.is_active === 0);

        /* Update Configured pill count */
        document.querySelectorAll('#kpiModalSummaryRow > div').forEach(pill => {
            const divs = pill.querySelectorAll('div');
            if (divs[0] && divs[0].textContent.trim() === 'Configured' && divs[1]) {
                divs[1].textContent = fmtN(active.length);
            }
        });
        const thS = 'background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:';
        const mkTable = (arr) => {
            if (!arr.length) return '<div style="padding:14px;text-align:center;color:#94a3b8;font-size:12px">None</div>';
            return `<table style="width:100%;border-collapse:collapse;font-size:12px">
                <thead><tr>
                    <th style="${thS}left">Warehouse</th>
                    <th style="${thS}center">Total</th>
                    <th style="${thS}center">Online</th>
                    <th style="${thS}center">Offline</th>
                    <th style="${thS}left">Status Changed At</th>
                </tr></thead>
                <tbody>${arr.map(w=>`<tr onclick="window.location.href='/nms/warehouses/${w.warehouse_id}';closeKpiModal()"
                    onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
                    style="cursor:pointer;transition:background .12s">
                    <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8">
                        <div style="font-weight:700;display:flex;align-items:center;gap:3px">${w.warehouse_name}<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6"></i></div>
                        <div style="font-size:10px;color:#94a3b8">${w.region_name||'—'}</div>
                    </td>
                    <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${w.ws_total||0}</td>
                    <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${w.ws_online||0}</td>
                    <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w.ws_offline||0)>0?'#dc2626':'#94a3b8'}">${w.ws_offline||0}</td>
                    <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-size:11px;color:#475569;font-family:'IBM Plex Mono',monospace">${w.ws_status_changed_at?fmtDt(w.ws_status_changed_at):'—'}</td>
                </tr>`).join('')}</tbody>
            </table>`;
        };
        const activeOff = active.filter(w=>(w.ws_offline||0)>0).sort((a,b)=>new Date(b.ws_last_offline_at||0)-new Date(a.ws_last_offline_at||0));
        const activeOn  = active.filter(w=>(w.ws_online||0)>0&&(w.ws_offline||0)===0).sort((a,b)=>new Date(b.ws_last_online_at||0)-new Date(a.ws_last_online_at||0));
        const thS2 = 'background:#f8fafc;color:#94a3b8;font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;padding:8px 12px;border-bottom:1.5px solid #e2e8f0;text-align:';
        const mkRow = (w) => `<tr onclick="window.location.href='/nms/warehouses/${w.warehouse_id}';closeKpiModal()"
            onmouseover="this.style.background='#f0f6ff'" onmouseout="this.style.background=''"
            style="cursor:pointer;transition:background .12s">
            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-weight:700;display:flex;align-items:center;gap:3px">${w.warehouse_name}<i class="ri-arrow-right-s-line" style="font-size:12px;color:#3b82f6"></i></td>
            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;color:#64748b;font-size:11px">${w.region_name||'—'}</td>
            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700">${w.ws_total||0}</td>
            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#059669">${w.ws_online||0}</td>
            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;text-align:center;font-family:'IBM Plex Mono',monospace;font-weight:700;color:${(w.ws_offline||0)>0?'#dc2626':'#94a3b8'}">${w.ws_offline||0}</td>
            <td style="padding:8px 12px;border-bottom:1px solid #f0f4f8;font-size:11px;color:#475569;font-family:'IBM Plex Mono',monospace">${w.ws_status_changed_at?fmtDt(w.ws_status_changed_at):'—'}</td>
        </tr>`;

        const allRows = [...activeOn, ...activeOff];
        listEl.innerHTML = `<div style="max-height:400px;overflow-y:auto">
            <table style="width:100%;border-collapse:collapse;font-size:12px">
                <thead><tr>
                    <th style="${thS2}left">Warehouse</th>
                    <th style="${thS2}left">Region</th>
                    <th style="${thS2}center">Total</th>
                    <th style="${thS2}center">Online</th>
                    <th style="${thS2}center">Offline</th>
                    <th style="${thS2}left">Status Changed At</th>
                </tr></thead>
                <tbody>
                    ${allRows.length ? allRows.map(w=>mkRow(w)).join('') : '<tr><td colspan="6" style="padding:20px;text-align:center;color:#94a3b8">No active warehouses</td></tr>'}
                </tbody>
            </table>
        </div>`;
    } catch(e) {
        if (listEl) listEl.innerHTML = `<div style="padding:14px;text-align:center;color:#ef4444;font-size:12px">Error: ${e.message}</div>`;
    }
}
function cwTab(t) {
    document.getElementById('cwContentOff').style.display = t==='off'?'':'none';
    document.getElementById('cwContentOn').style.display  = t==='on'?'':'none';
    document.getElementById('cwTabOff').style.cssText = t==='off'?'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#dc2626;border-bottom:2.5px solid #dc2626;cursor:pointer':'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer';
    document.getElementById('cwTabOn').style.cssText  = t==='on'?'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#059669;border-bottom:2.5px solid #059669;cursor:pointer':'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer';
}
function wsShowTab(t) {
    document.getElementById('wsContentOff').style.display = t==='off'?'':'none';
    document.getElementById('wsContentOn').style.display  = t==='on'?'':'none';
    document.getElementById('wsTabOff').style.cssText = t==='off'?'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#dc2626;border-bottom:2.5px solid #dc2626;cursor:pointer':'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer';
    document.getElementById('wsTabOn').style.cssText  = t==='on'?'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#059669;border-bottom:2.5px solid #059669;cursor:pointer':'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer';
}
function epcShowTab(t) {
    document.getElementById('epcContentOff').style.display = t==='off'?'':'none';
    document.getElementById('epcContentOn').style.display  = t==='on'?'':'none';
    document.getElementById('epcTabOff').style.cssText = t==='off'?'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#dc2626;border-bottom:2.5px solid #dc2626;cursor:pointer':'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer';
    document.getElementById('epcTabOn').style.cssText  = t==='on'?'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#fff;color:#059669;border-bottom:2.5px solid #059669;cursor:pointer':'flex:1;padding:10px;font-size:12px;font-weight:700;border:none;background:#f8fafc;color:#94a3b8;border-bottom:2.5px solid transparent;cursor:pointer';
}

function closeKpiModal() {
    document.getElementById('kpiModal').style.display = 'none';
    document.body.style.overflow = '';
    if (_kpiChart) { _kpiChart.destroy(); _kpiChart = null; }
    document.querySelectorAll('[id^="_km"]').forEach(cv => { try { Chart.getChart(cv)?.destroy(); } catch(e){} });
}

document.addEventListener('keydown', e => { if (e.key==='Escape') closeKpiModal(); });

document.addEventListener('DOMContentLoaded',()=>{
    loadStats();
    renderNmsStrip();
    document.getElementById('refreshBtn')?.addEventListener('click', () => { loadStats(); renderNmsStrip(); });
    document.getElementById('barChartBackBtn')?.addEventListener('click',()=>{barChartMode='region';barChartRegion=null;renderRegionBar(dashData.nmsRegionData||dashData.regionData||[]);});
    document.getElementById('dashMapFilter')?.addEventListener('change',filterDashPins);
    document.getElementById('dashMapSearch')?.addEventListener('input',filterDashPins);
    document.getElementById('dashMapReset')?.addEventListener('click',resetDashMapView);
    setInterval(loadStats,5*60*1000);
    setInterval(renderNmsStrip, 5*60*1000);
    setInterval(tick,30*1000);
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>