

<style>
/* ── Chatbot Widget ── */
#cwcChatBtn {
    position: fixed;
    bottom: 1.25rem;
    right: 1.25rem;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 24px rgba(37,99,235,.45);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    z-index: 9998;
    transition: transform .2s, box-shadow .2s;
}
#cwcChatBtn:hover { transform: scale(1.08); box-shadow: 0 8px 28px rgba(37,99,235,.55); }

/* Ripple ring around button */
#cwcChatBtn::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 2px solid rgba(37,99,235,.3);
    animation: cwcRipple 2.5s ease-out infinite;
}
@keyframes cwcRipple {
    0%   { transform: scale(1);   opacity: .6; }
    100% { transform: scale(1.5); opacity: 0;  }
}

.cwc-chat-badge {
    position: absolute;
    top: -3px; right: -3px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #dc2626;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    animation: cwcPop .3s ease;
}
@keyframes cwcPop { from{transform:scale(0);}to{transform:scale(1);} }

/* ── Chat Window ── */
#cwcChatWindow {
    position: fixed;
    bottom: 4.5rem;
    right: 1.5rem;
    z-index: 9999;
    width: 400px;
    max-width: calc(100vw - 2rem);
    max-height: calc(100vh - 5.5rem);
    height: 560px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 20px 70px rgba(0,0,0,.14), 0 4px 20px rgba(37,99,235,.08);
    display: none;
    flex-direction: column;
    font-family: 'DM Sans', -apple-system, sans-serif;
    overflow: hidden;
    transform: translateY(12px);
    opacity: 0;
    transition: transform .26s cubic-bezier(.34,1.56,.64,1), opacity .2s;
}

@media (max-width: 600px) {
    #cwcChatWindow {
        width: calc(100vw - 1.5rem);
        right: .75rem;
        bottom: 4rem;
        height: calc(100vh - 5rem);
        max-height: calc(100vh - 5rem);
        border-radius: 14px;
    }
}

/* ── Header ── */
.cwc-chat-hdr {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
    padding: 13px 16px;
    display: flex;
    align-items: center;
    gap: 11px;
    flex-shrink: 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
}

.cwc-chat-avatar {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(37,99,235,.4);
    position: relative;
}

/* Animated pulse ring on avatar */
.cwc-chat-avatar::after {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 13px;
    border: 1.5px solid rgba(59,130,246,.5);
    animation: cwcAvatarPulse 2s ease-in-out infinite;
}
@keyframes cwcAvatarPulse {
    0%,100% { opacity: .5; transform: scale(1);    }
    50%      { opacity: 1;  transform: scale(1.06); }
}

.cwc-chat-hdr-info { flex: 1; min-width: 0; }
.cwc-chat-hdr-name { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.01em; }
.cwc-chat-hdr-status {
    font-size: 11px; color: #94a3b8;
    display: flex; align-items: center; gap: 5px; margin-top: 2px;
}
.cwc-online-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #10b981;
    animation: cwcBlink 2.2s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes cwcBlink { 0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(16,185,129,.4);}50%{opacity:.5;box-shadow:0 0 0 4px rgba(16,185,129,0);} }

.cwc-chat-close {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.1);
    color: #94a3b8;
    width: 30px; height: 30px;
    border-radius: 8px;
    cursor: pointer; font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    transition: all .16s;
    flex-shrink: 0;
}
.cwc-chat-close:hover { background: rgba(255,255,255,.15); color: #fff; }

/* ── Quick topics ── */
.cwc-topics {
    padding: 9px 12px 8px;
    display: flex;
    gap: 5px;
    flex-wrap: nowrap;
    overflow-x: auto;
    flex-shrink: 0;
    border-bottom: 1px solid #f1f5f9;
    scrollbar-width: none;
}
.cwc-topics::-webkit-scrollbar { display: none; }

.cwc-topic-btn {
    padding: 4px 10px;
    border-radius: 20px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #64748b;
    font-size: 10.5px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all .18s;
    white-space: nowrap;
    letter-spacing: .01em;
}
.cwc-topic-btn:hover  { border-color: #93c5fd; color: #2563eb; background: #eff6ff; }
.cwc-topic-btn.active { border-color: #2563eb; color: #fff; background: #2563eb; }

/* ── Messages ── */
.cwc-messages {
    flex: 1;
    overflow-y: auto;
    padding: 12px 12px 4px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-height: 0;
}
.cwc-messages::-webkit-scrollbar { width: 3px; }
.cwc-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

.cwc-msg {
    display: flex;
    gap: 8px;
    animation: cwcFadeIn .22s ease;
}
@keyframes cwcFadeIn { from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);} }

.cwc-msg-bot  { align-items: flex-start; }
.cwc-msg-user { align-items: flex-end; flex-direction: row-reverse; }

.cwc-msg-icon {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #fff; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(37,99,235,.3);
}

.cwc-bubble {
    max-width: 84%;
    padding: 10px 13px;
    border-radius: 13px;
    font-size: 13px;
    line-height: 1.55;
    font-weight: 500;
    color: #0f172a;
}

.cwc-msg-bot  .cwc-bubble {
    background: #f1f5f9;
    border-bottom-left-radius: 4px;
    border: 1px solid #e9eef5;
}
.cwc-msg-user .cwc-bubble {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    border-bottom-right-radius: 4px;
    box-shadow: 0 3px 12px rgba(37,99,235,.3);
}

.cwc-bubble strong { font-weight: 800; }

/* Stat table rows */
.cwc-stat-title {
    display: block;
    font-size: 10px;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .07em;
    margin-bottom: 8px;
}

.cwc-stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 0;
    border-bottom: 1px solid rgba(0,0,0,.05);
    font-size: 12.5px;
    gap: 8px;
}
.cwc-stat-row:last-child { border-bottom: none; }
.cwc-stat-label { color: #64748b; flex: 1; }
.cwc-stat-val   {
    font-weight: 700;
    color: #0f172a;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 12px;
    flex-shrink: 0;
}

/* Severity badge */
.cwc-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 2px 7px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
    font-family: 'IBM Plex Mono', monospace;
}
.cwc-badge-ok       { background: #dcfce7; color: #166534; }
.cwc-badge-warn     { background: #fef3c7; color: #92400e; }
.cwc-badge-critical { background: #fee2e2; color: #991b1b; }
.cwc-badge-info     { background: #dbeafe; color: #1e40af; }
.cwc-badge-neutral  { background: #f1f5f9; color: #475569; }

/* Animated bar for health % */
.cwc-health-bar-wrap {
    height: 5px;
    background: #e2e8f0;
    border-radius: 99px;
    margin-top: 8px;
    overflow: hidden;
}
.cwc-health-bar {
    height: 100%;
    border-radius: 99px;
    transition: width .6s ease;
    animation: cwcBarGrow .7s ease forwards;
}
@keyframes cwcBarGrow { from{width:0!important;} }
.cwc-health-bar.green  { background: linear-gradient(90deg, #10b981, #34d399); }
.cwc-health-bar.orange { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.cwc-health-bar.red    { background: linear-gradient(90deg, #ef4444, #f87171); }

/* ── Quick replies ── */
.cwc-quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    padding: 6px 12px 8px;
    flex-shrink: 0;
    min-height: 0;
}
.cwc-quick-replies:empty { padding: 0; }

.cwc-qr {
    padding: 5px 12px;
    border-radius: 20px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #2563eb;
    font-size: 11.5px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all .16s;
    letter-spacing: .01em;
}
.cwc-qr:hover { background: #2563eb; color: #fff; border-color: #2563eb; transform: translateY(-1px); box-shadow: 0 3px 10px rgba(37,99,235,.25); }

/* ── Export bar ── */
.cwc-export-bar {
    padding: 8px 12px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 5px;
    background: #fafbfc;
    flex-shrink: 0;
}
.cwc-export-label {
    font-size: 10px;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-right: 2px;
}
.cwc-export-btn {
    padding: 5px 10px;
    border-radius: 7px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    font-size: 10.5px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all .16s;
    color: #64748b;
    letter-spacing: .02em;
}
.cwc-export-btn:hover         { border-color: #2563eb; color: #2563eb; background: #eff6ff; transform: translateY(-1px); }
.cwc-export-btn.pdf:hover     { border-color: #dc2626; color: #dc2626; background: #fef2f2; }
.cwc-export-btn.excel:hover   { border-color: #059669; color: #059669; background: #ecfdf5; }
.cwc-export-btn.csv:hover     { border-color: #d97706; color: #d97706; background: #fffbeb; }

/* ── Input ── */
.cwc-input-row {
    padding: 10px 12px 12px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 7px;
    flex-shrink: 0;
    background: #fff;
}
.cwc-input {
    flex: 1;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 9px 13px;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    color: #0f172a;
    background: #f8fafc;
    transition: all .18s;
}
.cwc-input::placeholder { color: #94a3b8; }
.cwc-input:focus {
    border-color: #2563eb;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}

.cwc-send-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .18s;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(37,99,235,.35);
}
.cwc-send-btn:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); transform: scale(1.06); box-shadow: 0 5px 16px rgba(37,99,235,.45); }

/* ── Typing indicator ── */
.cwc-typing { display: flex; gap: 4px; padding: 6px 4px; align-items: center; }
.cwc-typing span {
    width: 7px; height: 7px; border-radius: 50%;
    background: #94a3b8;
    animation: cwcTyping 1.3s infinite;
}
.cwc-typing span:nth-child(2) { animation-delay: .18s; }
.cwc-typing span:nth-child(3) { animation-delay: .36s; }
@keyframes cwcTyping { 0%,60%,100%{transform:translateY(0);opacity:.5;}30%{transform:translateY(-6px);opacity:1;} }

/* Divider line in bubble */
.cwc-divider {
    height: 1px;
    background: rgba(0,0,0,.07);
    margin: 6px 0;
}

@media (max-width: 480px) {
    #cwcChatWindow { width: calc(100vw - 24px); right: 12px; bottom: 80px; }
}
</style>


<button id="cwcChatBtn" onclick="cwcToggleChat()" title="CWC Assistant">
    <i class="ri-customer-service-2-line" id="cwcChatIcon"></i>
    <span class="cwc-chat-badge" id="cwcChatBadge">1</span>
</button>


<div id="cwcChatWindow">

    
    <div class="cwc-chat-hdr">
        <div class="cwc-chat-avatar"><i class="ri-robot-2-line"></i></div>
        <div class="cwc-chat-hdr-info">
            <div class="cwc-chat-hdr-name">CWC Assistant</div>
            <div class="cwc-chat-hdr-status">
                <span class="cwc-online-dot"></span> Online · Smart Warehouse AI
            </div>
        </div>
        <button class="cwc-chat-close" onclick="cwcToggleChat()">
            <i class="ri-close-line"></i>
        </button>
    </div>

    
    <div class="cwc-topics">
        <button class="cwc-topic-btn active" onclick="cwcSetTopic('all',this)">All</button>
        <button class="cwc-topic-btn" onclick="cwcSetTopic('camera',this)">📷 Camera</button>
        <button class="cwc-topic-btn" onclick="cwcSetTopic('fire',this)">🔥 Fire/Smoke</button>
        <button class="cwc-topic-btn" onclick="cwcSetTopic('iot',this)">🌡️ IoT</button>
        <button class="cwc-topic-btn" onclick="cwcSetTopic('sack',this)">🛄 Bags</button>
        <button class="cwc-topic-btn" onclick="cwcSetTopic('nms',this)">📡 NMS</button>
        <button class="cwc-topic-btn" onclick="cwcSetTopic('warehouse',this)">🏭 Warehouse</button>
    </div>

    
    <div class="cwc-messages" id="cwcMessages"></div>

    
    <div class="cwc-quick-replies" id="cwcQuickReplies"></div>

    
    <div class="cwc-export-bar">
        <span class="cwc-export-label"><i class="ri-download-2-line"></i> Export</span>
        <button class="cwc-export-btn pdf"   onclick="cwcExport('pdf')">  <i class="ri-file-pdf-line"></i>   PDF</button>
        <button class="cwc-export-btn excel" onclick="cwcExport('excel')"><i class="ri-file-excel-line"></i> Excel</button>
        <button class="cwc-export-btn csv"   onclick="cwcExport('csv')">  <i class="ri-file-text-line"></i>  CSV</button>
    </div>

    
    <div class="cwc-input-row">
        <input class="cwc-input" id="cwcInput"
               placeholder="Ask about cameras, alerts, IoT…"
               onkeydown="if(event.key==='Enter')cwcSend()">
        <button class="cwc-send-btn" onclick="cwcSend()">
            <i class="ri-send-plane-fill"></i>
        </button>
    </div>

</div>

<script>
(function () {

/* ══════════════════════════════════════════════════════
   STATE
══════════════════════════════════════════════════════ */
var isOpen       = false;
var currentTopic = 'all';
var chatHistory  = [];
var dashStats    = {};

/* ══════════════════════════════════════════════════════
   HELPERS
══════════════════════════════════════════════════════ */
function fmt(n) {
    if (n === undefined || n === null || n === '') return '—';
    var num = Number(n);
    if (isNaN(num)) return String(n);
    return new Intl.NumberFormat('en-IN').format(Math.round(num));
}

function pct(a, b) {
    if (!b || b === 0) return '—';
    return Math.round((a / b) * 100) + '%';
}

function pctNum(a, b) {
    if (!b || b === 0) return 0;
    return Math.round((a / b) * 100);
}

function timeAgo(ts) {
    try {
        var d    = new Date(ts);
        var diff = Math.floor((Date.now() - d) / 60000);
        if (diff < 1)    return 'Just now';
        if (diff < 60)   return diff + 'm ago';
        if (diff < 1440) return Math.floor(diff / 60) + 'h ago';
        return Math.floor(diff / 1440) + 'd ago';
    } catch (e) { return '—'; }
}

function severityBadge(count, threshWarn, threshCrit) {
    var n = Number(count) || 0;
    if (n === 0)             return badge('ok',       '✓ None');
    if (n >= threshCrit)     return badge('critical', '⚠ ' + fmt(n));
    if (n >= threshWarn)     return badge('warn',     '△ ' + fmt(n));
    return badge('warn', '△ ' + fmt(n));
}

function badge(type, text) {
    return '<span class="cwc-badge cwc-badge-' + type + '">' + text + '</span>';
}

function healthColor(p) {
    if (p >= 70) return 'green';
    if (p >= 40) return 'orange';
    return 'red';
}

function healthBadge(online, total) {
    var p = pctNum(online, total);
    var cls = healthColor(p);
    var label = cls === 'green' ? '✓ Good' : cls === 'orange' ? '△ Fair' : '✗ Poor';
    return badge(cls === 'green' ? 'ok' : cls === 'orange' ? 'warn' : 'critical', label + ' · ' + p + '%');
}

/* ── Response builders ── */
function plain(html) { return { type: 'plain', html: html }; }

function stat(title, rows, healthPct) {
    return { type: 'stat', title: title, rows: rows, healthPct: healthPct };
}

function renderBubble(data) {
    if (data.type === 'plain') return data.html;

    var html = '<span class="cwc-stat-title">' + data.title + '</span>';
    data.rows.forEach(function (row) {
        // row = [label, value]  OR  [label, value, 'badge:ok'] (future)
        html += '<div class="cwc-stat-row">'
            + '<span class="cwc-stat-label">' + row[0] + '</span>'
            + '<span class="cwc-stat-val">'   + row[1] + '</span>'
            + '</div>';
    });

    // Optional animated health bar
    if (typeof data.healthPct === 'number') {
        var cls = healthColor(data.healthPct);
        html += '<div class="cwc-health-bar-wrap">'
            + '<div class="cwc-health-bar ' + cls + '" style="width:' + data.healthPct + '%"></div>'
            + '</div>';
    }

    return html;
}

/* ══════════════════════════════════════════════════════
   KNOWLEDGE BASE  (v2.0)
══════════════════════════════════════════════════════ */
var KB = [

    /* ── CAMERAS ─────────────────────────────────── */
    {
        topic: 'camera',
        patterns: ['how many camera','total camera','camera count','cameras installed','camera stat'],
        answer: function (s) {
            var p = pctNum(s.cameraOnline, s.cameraTotal);
            return stat('Camera Network', [
                ['Total Cameras',  fmt(s.cameraTotal)],
                ['Online',         fmt(s.cameraOnline)],
                ['Offline',        fmt(s.cameraOffline)],
                ['Health Status',  healthBadge(s.cameraOnline, s.cameraTotal)],
            ], p);
        },
        replies: ['Camera offline details?','Region camera breakdown?','Worst region?']
    },
    {
        topic: 'camera',
        patterns: ['camera online','online camera','how many online'],
        answer: function (s) {
            return plain('<strong>' + fmt(s.cameraOnline) + '</strong> cameras are online out of ' + fmt(s.cameraTotal) + ' total. ' + healthBadge(s.cameraOnline, s.cameraTotal));
        },
        replies: ['Camera offline count?','Camera health %?']
    },
    {
        topic: 'camera',
        patterns: ['camera offline','offline camera','how many offline'],
        answer: function (s) {
            return plain('<strong>' + fmt(s.cameraOffline) + '</strong> cameras are currently offline. That\'s ' + (s.cameraTotal > 0 ? Math.round(s.cameraOffline / s.cameraTotal * 100) : 0) + '% of the network.');
        },
        replies: ['Total cameras?','Which region has most offline?']
    },
    {
        topic: 'camera',
        patterns: ['camera health','health percent','camera %'],
        answer: function (s) {
            var p = pctNum(s.cameraOnline, s.cameraTotal);
            return stat('Camera Health', [
                ['Health %',    p + '%'],
                ['Online',      fmt(s.cameraOnline)],
                ['Offline',     fmt(s.cameraOffline)],
                ['Status',      healthBadge(s.cameraOnline, s.cameraTotal)],
            ], p);
        },
        replies: ['Which region is worst?','Offline cameras?']
    },

    /* ── FIRE / SMOKE / RODENT ────────────────────── */
    {
        topic: 'fire',
        patterns: ['fire detect','fire alert','how many fire','fire count','fire event'],
        answer: function (s) {
            return stat('🔥 Fire Detection', [
                ['Events Detected',      fmt(s.fireDetected)],
                ['Warehouses Affected',  fmt(s.fireWarehouses)],
                ['Severity',             severityBadge(s.fireDetected, 1, 5)],
                ['Last Seen',            s.fireLastSeen ? timeAgo(s.fireLastSeen) : '—'],
            ]);
        },
        replies: ['Smoke alerts?','Rodent detections?','Detection summary?']
    },
    {
        topic: 'fire',
        patterns: ['smoke detect','smoke alert','how many smoke','smoke event'],
        answer: function (s) {
            return stat('💨 Smoke Detection', [
                ['Events Detected',      fmt(s.smokeDetected)],
                ['Warehouses Affected',  fmt(s.smokeWarehouses)],
                ['Severity',             severityBadge(s.smokeDetected, 1, 5)],
                ['Last Seen',            s.smokeLastSeen ? timeAgo(s.smokeLastSeen) : '—'],
            ]);
        },
        replies: ['Fire alerts?','Rodent detections?']
    },
    {
        topic: 'fire',
        patterns: ['rodent detect','rodent alert','how many rodent','pest'],
        answer: function (s) {
            return stat('🐀 Rodent Detection', [
                ['Events Detected',      fmt(s.rodentDetected)],
                ['Warehouses Affected',  fmt(s.rodentWarehouses)],
                ['Severity',             severityBadge(s.rodentDetected, 1, 3)],
                ['Last Seen',            s.rodentLastSeen ? timeAgo(s.rodentLastSeen) : '—'],
            ]);
        },
        replies: ['Fire alerts?','Smoke alerts?']
    },
    {
        topic: 'fire',
        patterns: ['detection summary','all detection','alert summary','all alert'],
        answer: function (s) {
            return stat('AI Detection Summary', [
                ['Fire',   fmt(s.fireDetected)   + ' events — ' + (s.fireWarehouses   || 0) + ' warehouses'],
                ['Smoke',  fmt(s.smokeDetected)  + ' events — ' + (s.smokeWarehouses  || 0) + ' warehouses'],
                ['Rodent', fmt(s.rodentDetected) + ' events — ' + (s.rodentWarehouses || 0) + ' warehouses'],
            ]);
        },
        replies: ['Which warehouses?','IoT status?','Export report']
    },

    /* ── IoT / CO2 / PH3 ─────────────────────────── */
    {
        topic: 'iot',
        patterns: ['co2','carbon dioxide','co2 alert','co2 sensor','co2 level'],
        answer: function (s) {
            return stat('🌫️ CO₂ Sensor Status', [
                ['Total Sensors',  fmt(s.co2SensorTotal)],
                ['Severe Alerts',  severityBadge(s.co2Severe,   1, 5)],
                ['Critical Alerts',severityBadge(s.co2Critical, 1, 3)],
                ['Action Needed',  (s.co2Critical > 0) ? badge('critical','⚠ Immediate') : badge('ok','✓ Normal')],
            ]);
        },
        replies: ['PH3 status?','IoT summary?','Alert severity?']
    },
    {
        topic: 'iot',
        patterns: ['ph3','phosphine','ph3 alert','ph3 sensor','ph3 level'],
        answer: function (s) {
            return stat('⚗️ PH₃ Sensor Status', [
                ['Total Sensors',  fmt(s.ph3SensorTotal)],
                ['Severe Alerts',  severityBadge(s.ph3Severe,   1, 5)],
                ['Critical Alerts',severityBadge(s.ph3Critical, 1, 3)],
                ['Action Needed',  (s.ph3Critical > 0) ? badge('critical','⚠ Immediate') : badge('ok','✓ Normal')],
            ]);
        },
        replies: ['CO2 status?','IoT summary?']
    },
    {
        topic: 'iot',
        patterns: ['iot summary','sensor summary','all sensor','iot status','gas sensor'],
        answer: function (s) {
            return stat('IoT Sensor Summary', [
                ['CO₂ Severe',    severityBadge(s.co2Severe,   1, 5)],
                ['CO₂ Critical',  severityBadge(s.co2Critical, 1, 3)],
                ['PH₃ Severe',    severityBadge(s.ph3Severe,   1, 5)],
                ['PH₃ Critical',  severityBadge(s.ph3Critical, 1, 3)],
            ]);
        },
        replies: ['CO2 details?','PH3 details?','Export IoT report']
    },
    {
        topic: 'iot',
        patterns: ['alert severity','severity level','how severe','severity breakdown'],
        answer: function (s) {
            var totalSevere   = (s.co2Severe   || 0) + (s.ph3Severe   || 0);
            var totalCritical = (s.co2Critical || 0) + (s.ph3Critical || 0);
            return stat('Alert Severity Breakdown', [
                ['⚠ Severe (CO₂)',    fmt(s.co2Severe)],
                ['🔴 Critical (CO₂)', fmt(s.co2Critical)],
                ['⚠ Severe (PH₃)',    fmt(s.ph3Severe)],
                ['🔴 Critical (PH₃)', fmt(s.ph3Critical)],
                ['Total Severe',      fmt(totalSevere)],
                ['Total Critical',    fmt(totalCritical)],
                ['Overall Risk',      totalCritical > 0 ? badge('critical','High Risk') : totalSevere > 0 ? badge('warn','Moderate') : badge('ok','Low')],
            ]);
        },
        replies: ['CO2 details?','PH3 details?','System status?']
    },

    /* ── BAGS / FRS ───────────────────────────────── */
    {
        topic: 'sack',
        patterns: ['bag','sack','bag count','sack count','how many bag','how many sack','bag in','bag out'],
        answer: function (s) {
            var net = (s.sackIn || 0) - (s.sackOut || 0);
            return stat('🛄 Bag Counting', [
                ['Bags IN',   fmt(s.sackIn)],
                ['Bags OUT',  fmt(s.sackOut)],
                ['Net Flow',  (net >= 0 ? '+' : '') + fmt(net)],
                ['Status',    net > 0 ? badge('ok','Net IN') : net < 0 ? badge('warn','Net OUT') : badge('neutral','Balanced')],
            ]);
        },
        replies: ['FRS status?','Export bag report']
    },
    {
        topic: 'sack',
        patterns: ['frs','face recogni','unknown person','identity','unknown face'],
        answer: function (s) {
            return stat('👤 FRS — Face Recognition', [
                ['Unknown Identities', fmt(s.frsUnknown)],
                ['FRS Cameras',        fmt(s.frsCameraTotal)],
                ['Alert Level',        severityBadge(s.frsUnknown, 1, 10)],
            ]);
        },
        replies: ['Bag counting?','Camera status?']
    },

    /* ── NMS ──────────────────────────────────────── */
    {
        topic: 'nms',
        patterns: ['nms','network status','nvr status','device online','device offline','nvr online','nvr offline'],
        answer: function (s) {
            var regions = s.regionData || [];
            var tot = regions.reduce(function (a, r) { return a + (r.total_cameras   || 0); }, 0);
            var on  = regions.reduce(function (a, r) { return a + (r.online_cameras  || 0); }, 0);
            var off = regions.reduce(function (a, r) { return a + (r.offline_cameras || 0); }, 0);
            var p   = pctNum(on, tot);
            return stat('📡 NMS Network Status', [
                ['Regions Monitored', fmt(regions.length)],
                ['Total Cameras',     fmt(tot)],
                ['Online',            fmt(on)],
                ['Offline',           fmt(off)],
                ['Health',            healthBadge(on, tot)],
            ], p);
        },
        replies: ['Worst region?','Best region?','NVR details?']
    },
    {
        topic: 'nms',
        patterns: ['nvr detail','nvr count','how many nvr','nvr total','nvr brand','device detail','device count'],
        answer: function (s) {
            var regions = s.regionData || [];
            var nvrTotal = regions.reduce(function (a, r) { return a + (r.nvr_count || 0); }, 0);
            return stat('🖥️ NVR / Device Details', [
                ['Total NVRs',     fmt(nvrTotal)],
                ['Regions Active', fmt(regions.length)],
                ['Avg Cameras/NVR', nvrTotal > 0 ? fmt(Math.round(regions.reduce(function(a,r){return a+(r.total_cameras||0);},0) / nvrTotal)) : '—'],
                ['Network Health', healthBadge(
                    regions.reduce(function(a,r){return a+(r.online_cameras||0);},0),
                    regions.reduce(function(a,r){return a+(r.total_cameras||0);},0)
                )],
            ]);
        },
        replies: ['NMS summary?','Worst region?','Camera health?']
    },
    {
        topic: 'nms',
        patterns: ['worst region','most offline','region problem','region health','bad region'],
        answer: function (s) {
            var regions = (s.regionData || []).slice().sort(function (a, b) {
                return (b.offline_cameras || 0) - (a.offline_cameras || 0);
            });
            if (!regions.length) return plain('No region data available.');
            return stat('⚠ Regions — Most Offline', regions.slice(0, 5).map(function (r) {
                return [r.region, fmt(r.offline_cameras || 0) + ' offline · ' + pct(r.online_cameras, r.total_cameras) + ' health'];
            }));
        },
        replies: ['Best region?','NMS summary?','Camera health?']
    },
    {
        topic: 'nms',
        patterns: ['best region','most online','healthy region','top region'],
        answer: function (s) {
            var regions = (s.regionData || []).slice().sort(function (a, b) {
                return pctNum(b.online_cameras, b.total_cameras) - pctNum(a.online_cameras, a.total_cameras);
            });
            if (!regions.length) return plain('No region data available.');
            return stat('✅ Healthiest Regions', regions.slice(0, 5).map(function (r) {
                return [r.region, pct(r.online_cameras, r.total_cameras) + ' health · ' + fmt(r.online_cameras) + ' online'];
            }));
        },
        replies: ['Worst region?','NMS summary?']
    },

    /* ── WAREHOUSE ────────────────────────────────── */
    {
        topic: 'warehouse',
        patterns: ['warehouse count','how many warehouse','total warehouse','warehouses covered','warehouse total'],
        answer: function (s) {
            var regions  = s.regionData || [];
            var warehouseTotal = s.warehouseTotal || s.totalWarehouses || regions.length;
            var activeRegions  = regions.filter(function(r){ return (r.total_cameras||0) > 0; }).length;
            return stat('🏭 Warehouse Coverage', [
                ['Total Warehouses',  fmt(warehouseTotal)],
                ['Regions Covered',   fmt(regions.length)],
                ['Regions Active',    fmt(activeRegions)],
                ['Avg Cameras/Region', regions.length > 0 ? fmt(Math.round(regions.reduce(function(a,r){return a+(r.total_cameras||0);},0) / regions.length)) : '—'],
            ]);
        },
        replies: ['Region breakdown?','NMS summary?','Camera status?']
    },
    {
        topic: 'warehouse',
        patterns: ['region breakdown','region summary','region list','all region','region stat'],
        answer: function (s) {
            var regions = s.regionData || [];
            if (!regions.length) return plain('No region data available right now.');
            return stat('📊 Region Breakdown (' + regions.length + ' regions)', regions.map(function (r) {
                var p = pctNum(r.online_cameras, r.total_cameras);
                var cls = healthColor(p);
                var icon = cls === 'green' ? '✓' : cls === 'orange' ? '△' : '✗';
                return [r.region, icon + ' ' + p + '% · ' + fmt(r.online_cameras) + '/' + fmt(r.total_cameras)];
            }));
        },
        replies: ['Worst region?','Best region?','Warehouse count?']
    },
    {
        topic: 'warehouse',
        patterns: ['active region','active warehouse','region online','region active'],
        answer: function (s) {
            var regions = s.regionData || [];
            var active  = regions.filter(function(r){ return (r.online_cameras||0) > 0; });
            var inactive= regions.filter(function(r){ return (r.online_cameras||0) === 0 && (r.total_cameras||0) > 0; });
            return stat('🟢 Region Activity', [
                ['Total Regions',    fmt(regions.length)],
                ['Active (≥1 online)',fmt(active.length)],
                ['Fully Offline',    fmt(inactive.length)],
                ['Coverage',         pct(active.length, regions.length)],
            ]);
        },
        replies: ['Region breakdown?','Worst region?','Warehouse count?']
    },

    /* ── GENERAL ──────────────────────────────────── */
    {
        topic: 'all',
        patterns: ['dashboard summary','overall summary','system status','how is everything','status','overview'],
        answer: function (s) {
            var cHP = pctNum(s.cameraOnline, s.cameraTotal);
            return stat('📋 System Overview', [
                ['Camera Health',   healthBadge(s.cameraOnline, s.cameraTotal)],
                ['Fire Events',     severityBadge(s.fireDetected,  1, 5)],
                ['Smoke Events',    severityBadge(s.smokeDetected, 1, 5)],
                ['Rodent Events',   severityBadge(s.rodentDetected,1, 3)],
                ['CO₂ Critical',    severityBadge(s.co2Critical, 1, 3)],
                ['PH₃ Critical',    severityBadge(s.ph3Critical, 1, 3)],
                ['Bags IN / OUT',   fmt(s.sackIn) + ' / ' + fmt(s.sackOut)],
                ['Unknown Faces',   severityBadge(s.frsUnknown, 1, 10)],
            ], cHP);
        },
        replies: ['Camera details?','Alert severity?','IoT status?','Warehouse count?']
    },
    {
        topic: 'all',
        patterns: ['help','what can you do','what can i ask','commands','topics'],
        answer: function () {
            return plain('I can answer questions about:<br><br>'
                + '📷 <strong>Cameras</strong> — total, online, offline, health %<br>'
                + '🔥 <strong>Fire / Smoke / Rodent</strong> — detection counts, warehouses affected<br>'
                + '🌡️ <strong>IoT</strong> — CO₂ & PH₃ severe/critical with severity badges<br>'
                + '🛄 <strong>Bags</strong> — sack IN/OUT/net flow<br>'
                + '👤 <strong>FRS</strong> — unknown face detections<br>'
                + '📡 <strong>NMS</strong> — network health, NVR details, worst/best region<br>'
                + '🏭 <strong>Warehouse</strong> — total count, region activity, region breakdown<br><br>'
                + 'Use the <strong>topic tabs</strong> above to filter, or just type naturally.<br>'
                + 'Click export buttons below for PDF / Excel / CSV reports.');
        },
        replies: ['System status?','Camera summary?','Alert severity?']
    },
    {
        topic: 'all',
        patterns: ['hello','hi','hey','good morning','good afternoon','good evening','namaste'],
        answer: function () {
            return plain('Hello! 👋 I\'m the <strong>CWC Assistant</strong>.<br><br>I can check camera status, fire/smoke alerts, IoT gas sensors, bag counts, FRS, warehouse coverage, and NMS device health — all in real time.<br><br>What would you like to know?');
        },
        replies: ['System status?','Camera summary?','Help']
    },
    {
        topic: 'all',
        patterns: ['export','download','report','generate report'],
        answer: function () {
            return plain('Use the export buttons below:<br><br>'
                + '📄 <strong>PDF</strong> — formatted printable report with KPI cards<br>'
                + '📊 <strong>Excel</strong> — spreadsheet with all metrics + region table<br>'
                + '📋 <strong>CSV</strong> — raw data for further analysis<br><br>'
                + 'All exports include the current dashboard snapshot.');
        },
        replies: ['What data is exported?','System status?']
    },
];

/* ══════════════════════════════════════════════════════
   MATCH
══════════════════════════════════════════════════════ */
function findAnswer(input) {
    var q = input.toLowerCase().trim();
    var filtered = KB.filter(function (k) {
        return currentTopic === 'all' || k.topic === currentTopic || k.topic === 'all';
    });
    // Longest pattern match wins (more specific first)
    var best = null, bestLen = 0;
    for (var i = 0; i < filtered.length; i++) {
        var kb = filtered[i];
        for (var j = 0; j < kb.patterns.length; j++) {
            if (q.includes(kb.patterns[j]) && kb.patterns[j].length > bestLen) {
                best    = kb;
                bestLen = kb.patterns[j].length;
            }
        }
    }
    return best;
}

/* ══════════════════════════════════════════════════════
   DOM HELPERS
══════════════════════════════════════════════════════ */
function addMsg(role, html, replies) {
    var msgs = document.getElementById('cwcMessages');
    var div  = document.createElement('div');
    div.className = 'cwc-msg cwc-msg-' + role;

    if (role === 'bot') {
        div.innerHTML = '<div class="cwc-msg-icon"><i class="ri-robot-2-line"></i></div>'
            + '<div class="cwc-bubble">' + html + '</div>';
    } else {
        div.innerHTML = '<div class="cwc-bubble">' + html + '</div>';
    }

    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;

    if (replies && replies.length) setQuickReplies(replies);
    chatHistory.push({ role: role, html: html });
}

function showTyping() {
    var msgs = document.getElementById('cwcMessages');
    var div  = document.createElement('div');
    div.className = 'cwc-msg cwc-msg-bot';
    div.id = 'cwcTyping';
    div.innerHTML = '<div class="cwc-msg-icon"><i class="ri-robot-2-line"></i></div>'
        + '<div class="cwc-bubble"><div class="cwc-typing"><span></span><span></span><span></span></div></div>';
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function hideTyping() {
    var el = document.getElementById('cwcTyping');
    if (el) el.remove();
}

function setQuickReplies(replies) {
    var qr = document.getElementById('cwcQuickReplies');
    qr.innerHTML = '';
    replies.forEach(function (r) {
        var btn = document.createElement('button');
        btn.className = 'cwc-qr';
        btn.textContent = r;
        btn.onclick = function () { cwcAsk(r); };
        qr.appendChild(btn);
    });
}

/* ══════════════════════════════════════════════════════
   FETCH STATS
══════════════════════════════════════════════════════ */
function fetchStats(cb) {
    if (Object.keys(dashStats).length > 0) { cb(dashStats); return; }
    fetch('/api/dashboard/stats', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || '',
        }
    })
    .then(function (r) { return r.json(); })
    .then(function (json) {
        if (json.success) { dashStats = json.data; cb(dashStats); }
        else cb({});
    })
    .catch(function () { cb({}); });
}

/* ══════════════════════════════════════════════════════
   SEND / ASK
══════════════════════════════════════════════════════ */
window.cwcSend = function () {
    var input = document.getElementById('cwcInput');
    var q     = input.value.trim();
    if (!q) return;
    input.value = '';
    cwcAsk(q);
};

window.cwcAsk = function (q) {
    addMsg('user', q);
    document.getElementById('cwcQuickReplies').innerHTML = '';
    showTyping();

    setTimeout(function () {
        fetchStats(function (stats) {
            hideTyping();
            var kb = findAnswer(q);
            if (kb) {
                var result  = kb.answer(stats);
                var html    = renderBubble(result);
                var replies = kb.replies || [];
                addMsg('bot', html, replies);
            } else {
                addMsg('bot',
                    'I\'m not sure about that. Try asking about:<br>'
                    + '📷 cameras · 🔥 fire alerts · 🌡️ IoT sensors · 🛄 bags · 📡 NMS · 🏭 warehouses',
                    ['System status?','Camera summary?','Alert severity?','Help']
                );
            }
        });
    }, 580);
};

/* ══════════════════════════════════════════════════════
   EXPORT
══════════════════════════════════════════════════════ */
window.cwcExport = function (format) {
    fetchStats(function (stats) {
        var regions   = stats.regionData || [];
        var nvrTotal  = regions.reduce(function (a, r) { return a + (r.nvr_count || 0); }, 0);

        var rows = [
            ['Metric', 'Value'],
            ['--- CAMERAS ---', ''],
            ['Total Cameras',   stats.cameraTotal   || 0],
            ['Online Cameras',  stats.cameraOnline  || 0],
            ['Offline Cameras', stats.cameraOffline || 0],
            ['Camera Health %', stats.cameraTotal > 0 ? Math.round(stats.cameraOnline / stats.cameraTotal * 100) + '%' : '—'],
            ['--- DETECTIONS ---', ''],
            ['Fire Detected',      stats.fireDetected    || 0],
            ['Fire Warehouses',    stats.fireWarehouses  || 0],
            ['Smoke Detected',     stats.smokeDetected   || 0],
            ['Smoke Warehouses',   stats.smokeWarehouses || 0],
            ['Rodent Detected',    stats.rodentDetected  || 0],
            ['Rodent Warehouses',  stats.rodentWarehouses|| 0],
            ['--- IOT SENSORS ---', ''],
            ['CO2 Severe',    stats.co2Severe    || 0],
            ['CO2 Critical',  stats.co2Critical  || 0],
            ['PH3 Severe',    stats.ph3Severe    || 0],
            ['PH3 Critical',  stats.ph3Critical  || 0],
            ['--- BAG COUNTING ---', ''],
            ['Bags IN',  stats.sackIn  || 0],
            ['Bags OUT', stats.sackOut || 0],
            ['Net Bags', (stats.sackIn || 0) - (stats.sackOut || 0)],
            ['--- FRS ---', ''],
            ['Unknown Identities', stats.frsUnknown     || 0],
            ['FRS Cameras',        stats.frsCameraTotal || 0],
            ['--- NMS DEVICES ---', ''],
            ['Total NVRs',    nvrTotal],
        ];

        if (regions.length) {
            rows.push(['--- REGIONS ---', '']);
            rows.push(['Region', 'NVRs', 'Total', 'Online', 'Offline', 'Health%']);
            regions.forEach(function (r) {
                rows.push([
                    r.region,
                    r.nvr_count       || 0,
                    r.total_cameras   || 0,
                    r.online_cameras  || 0,
                    r.offline_cameras || 0,
                    r.total_cameras > 0 ? Math.round(r.online_cameras / r.total_cameras * 100) + '%' : '—'
                ]);
            });
        }

        var timestamp = new Date().toLocaleString('en-IN');
        var filename  = 'CWC_Report_' + new Date().toISOString().slice(0, 10);

        if (format === 'csv')   exportCSV(rows, filename);
        else if (format === 'excel') exportExcel(rows, filename, timestamp);
        else if (format === 'pdf')   exportPDF(rows, filename, timestamp, stats);

        addMsg('bot', '✅ <strong>' + format.toUpperCase() + ' report</strong> downloaded successfully!', []);
    });
};

function exportCSV(rows, filename) {
    var csv = rows.map(function (r) {
        return r.map(function (c) {
            var s = String(c);
            return (s.includes(',') || s.includes('"')) ? '"' + s.replace(/"/g, '""') + '"' : s;
        }).join(',');
    }).join('\n');
    download(new Blob([csv], { type: 'text/csv' }), filename + '.csv');
}

function exportExcel(rows, filename, timestamp) {
    var html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" '
        + 'xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">'
        + '<head><meta charset="UTF-8">'
        + '<style>th{background:#1e293b;color:#fff;padding:6px 10px;font-size:12px;}'
        + 'td{padding:5px 10px;font-size:12px;border-bottom:1px solid #e2e8f0;}'
        + '.section{background:#f1f5f9;font-weight:bold;color:#0f172a;}'
        + '</style></head><body>'
        + '<h2 style="color:#0f172a;font-family:Arial;">CWC Smart Warehouse Report</h2>'
        + '<p style="color:#94a3b8;font-size:12px;">Generated: ' + timestamp + '</p>'
        + '<table border="0" cellspacing="0" cellpadding="0">';

    rows.forEach(function (r, i) {
        var isSection = String(r[0]).startsWith('---');
        if (isSection) {
            html += '<tr><td class="section" colspan="6">' + r[0].replace(/---/g, '').trim() + '</td></tr>';
        } else if (i === 0) {
            html += '<tr>' + r.map(function (c) { return '<th>' + c + '</th>'; }).join('') + '</tr>';
        } else {
            html += '<tr>' + r.map(function (c) { return '<td>' + c + '</td>'; }).join('') + '</tr>';
        }
    });

    html += '</table></body></html>';
    download(new Blob([html], { type: 'application/vnd.ms-excel' }), filename + '.xls');
}

function exportPDF(rows, filename, timestamp, stats) {
    var w = window.open('', '_blank');
    var regions     = stats.regionData || [];
    var cameraHealth = pctNum(stats.cameraOnline, stats.cameraTotal);
    var totalSevere  = (stats.co2Severe || 0) + (stats.ph3Severe || 0);
    var totalCritical= (stats.co2Critical|| 0) + (stats.ph3Critical|| 0);

    var html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>CWC Report</title>'
        + '<style>'
        + 'body{font-family:Arial,sans-serif;color:#0f172a;padding:32px;max-width:860px;margin:0 auto;}'
        + 'h1{color:#0f172a;font-size:22px;border-bottom:3px solid #2563eb;padding-bottom:10px;margin-bottom:4px;}'
        + '.meta{color:#94a3b8;font-size:12px;margin-bottom:22px;}'
        + '.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:26px;}'
        + '.kpi{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;}'
        + '.kpi-label{font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}'
        + '.kpi-val{font-size:24px;font-weight:800;color:#0f172a;line-height:1.2;}'
        + '.kpi-sub{font-size:10px;color:#64748b;margin-top:2px;}'
        + '.kpi-val.green{color:#059669;}.kpi-val.orange{color:#d97706;}.kpi-val.red{color:#dc2626;}'
        + 'h2{font-size:13px;color:#64748b;text-transform:uppercase;letter-spacing:.08em;margin:22px 0 8px;border-bottom:1px solid #e2e8f0;padding-bottom:5px;}'
        + 'table{width:100%;border-collapse:collapse;font-size:12.5px;margin-bottom:18px;}'
        + 'th{background:#1e293b;color:#fff;padding:8px 12px;text-align:left;font-size:11px;}'
        + 'td{padding:7px 12px;border-bottom:1px solid #f1f5f9;}'
        + 'tr:nth-child(even) td{background:#f8fafc;}'
        + '.ok{color:#059669;font-weight:700;} .warn{color:#d97706;font-weight:700;} .crit{color:#dc2626;font-weight:700;}'
        + '.footer{margin-top:28px;font-size:10px;color:#94a3b8;text-align:center;border-top:1px solid #e2e8f0;padding-top:10px;}'
        + '@media print{body{padding:16px;} .kpi-grid{grid-template-columns:repeat(4,1fr);}}'
        + '</style></head><body>'
        + '<h1>CWC Smart Warehouse — Dashboard Report</h1>'
        + '<div class="meta">Generated: ' + timestamp + ' &nbsp;|&nbsp; Smart Warehouse ICCC Platform</div>'
        + '<div class="kpi-grid">'
        + '<div class="kpi"><div class="kpi-label">Camera Health</div><div class="kpi-val ' + healthColor(cameraHealth) + '">' + cameraHealth + '%</div><div class="kpi-sub">' + fmt(stats.cameraOnline) + ' / ' + fmt(stats.cameraTotal) + ' online</div></div>'
        + '<div class="kpi"><div class="kpi-label">Fire Events</div><div class="kpi-val ' + ((stats.fireDetected||0) > 0 ? 'red' : 'green') + '">' + (stats.fireDetected || 0) + '</div><div class="kpi-sub">' + (stats.fireWarehouses||0) + ' warehouses</div></div>'
        + '<div class="kpi"><div class="kpi-label">IoT Critical</div><div class="kpi-val ' + (totalCritical > 0 ? 'red' : 'green') + '">' + totalCritical + '</div><div class="kpi-sub">CO₂ + PH₃</div></div>'
        + '<div class="kpi"><div class="kpi-label">Bags IN</div><div class="kpi-val green">' + (stats.sackIn || 0) + '</div><div class="kpi-sub">Out: ' + (stats.sackOut||0) + '</div></div>'
        + '</div>';

    // Sections
    [
        { title: 'Camera Network', headers: ['Metric','Value'], rows: [
            ['Total Cameras', stats.cameraTotal||0],
            ['Online',  stats.cameraOnline||0],
            ['Offline', stats.cameraOffline||0],
            ['Health',  cameraHealth + '%'],
        ]},
        { title: 'AI Detection Events', headers: ['Type','Events','Warehouses Affected'], rows: [
            ['Fire',   stats.fireDetected||0,   stats.fireWarehouses||0],
            ['Smoke',  stats.smokeDetected||0,  stats.smokeWarehouses||0],
            ['Rodent', stats.rodentDetected||0, stats.rodentWarehouses||0],
        ]},
        { title: 'IoT Gas Sensor Alerts', headers: ['Gas Type','Severe','Critical'], rows: [
            ['CO₂', stats.co2Severe||0, stats.co2Critical||0],
            ['PH₃', stats.ph3Severe||0, stats.ph3Critical||0],
            ['Total', totalSevere, totalCritical],
        ]},
        { title: 'Bag Counting (FRS)', headers: ['Metric','Count'], rows: [
            ['Bags IN',           stats.sackIn||0],
            ['Bags OUT',          stats.sackOut||0],
            ['Net',               (stats.sackIn||0)-(stats.sackOut||0)],
            ['Unknown Faces',     stats.frsUnknown||0],
            ['FRS Cameras',       stats.frsCameraTotal||0],
        ]},
    ].forEach(function (sec) {
        html += '<h2>' + sec.title + '</h2><table>'
            + '<tr>' + sec.headers.map(function (h) { return '<th>' + h + '</th>'; }).join('') + '</tr>'
            + sec.rows.map(function (r) {
                return '<tr>' + r.map(function (c) { return '<td>' + c + '</td>'; }).join('') + '</tr>';
            }).join('')
            + '</table>';
    });

    if (regions.length) {
        html += '<h2>Region-wise Camera Status</h2><table>'
            + '<tr><th>Region</th><th>NVRs</th><th>Total</th><th>Online</th><th>Offline</th><th>Health</th></tr>'
            + regions.map(function (r) {
                var h = r.total_cameras > 0 ? Math.round(r.online_cameras / r.total_cameras * 100) : 0;
                var cls = h >= 70 ? 'ok' : h >= 40 ? 'warn' : 'crit';
                return '<tr>'
                    + '<td>' + r.region + '</td>'
                    + '<td>' + (r.nvr_count||0) + '</td>'
                    + '<td>' + (r.total_cameras||0) + '</td>'
                    + '<td class="ok">' + (r.online_cameras||0) + '</td>'
                    + '<td class="crit">' + (r.offline_cameras||0) + '</td>'
                    + '<td class="' + cls + '">' + h + '%</td>'
                    + '</tr>';
            }).join('')
            + '</table>';
    }

    html += '<div class="footer">CWC ICCC — Smart Warehouse Unified Dashboard &nbsp;|&nbsp; Confidential &nbsp;|&nbsp; ' + timestamp + '</div></body></html>';

    w.document.write(html);
    w.document.close();
    setTimeout(function () { w.print(); }, 500);
}

function download(blob, name) {
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = name;
    a.click();
    URL.revokeObjectURL(a.href);
}

function fmt(n) {
    if (n === undefined || n === null || n === '') return '—';
    var num = Number(n);
    if (isNaN(num)) return String(n);
    return new Intl.NumberFormat('en-IN').format(Math.round(num));
}
function pctNum(a, b) { if (!b || b === 0) return 0; return Math.round((a / b) * 100); }
function pct(a, b)    { if (!b || b === 0) return '—'; return pctNum(a, b) + '%'; }
function healthColor(p) { return p >= 70 ? 'green' : p >= 40 ? 'orange' : 'red'; }

/* ══════════════════════════════════════════════════════
   TOGGLE & TOPIC
══════════════════════════════════════════════════════ */
window.cwcToggleChat = function () {
    isOpen = !isOpen;
    var win   = document.getElementById('cwcChatWindow');
    var icon  = document.getElementById('cwcChatIcon');
    var badge = document.getElementById('cwcChatBadge');

    if (isOpen) {
        win.style.display   = 'flex';
        win.style.transform = 'translateY(12px)';
        win.style.opacity   = '0';
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                win.style.transform = 'translateY(0)';
                win.style.opacity   = '1';
            });
        });
        icon.className      = 'ri-close-line';
        badge.style.display = 'none';

        if (!chatHistory.length) {
            setTimeout(function () {
                addMsg('bot',
                    'Hello! 👋 I\'m your <strong>CWC Assistant</strong>.<br><br>'
                    + 'I can help with camera status, fire & smoke alerts, IoT gas sensors, bag counting, FRS, warehouse coverage, and NMS reports — all in real time.<br><br>'
                    + 'What would you like to know?',
                    ['System status?', 'Camera summary?', 'Alert severity?', 'Help']
                );
            }, 280);
        }

        setTimeout(function () {
            document.getElementById('cwcInput').focus();
        }, 340);
    } else {
        win.style.transform = 'translateY(12px)';
        win.style.opacity   = '0';
        setTimeout(function () { win.style.display = 'none'; }, 220);
        icon.className = 'ri-customer-service-2-line';
    }
};

window.cwcSetTopic = function (topic, btn) {
    currentTopic = topic;
    document.querySelectorAll('.cwc-topic-btn').forEach(function (b) { b.classList.remove('active'); });
    btn.classList.add('active');

    var replies = {
        all:       ['System status?', 'Camera summary?', 'Alert severity?', 'Help'],
        camera:    ['Total cameras?', 'Camera health?', 'Offline cameras?', 'Region breakdown?'],
        fire:      ['Fire alerts?', 'Smoke alerts?', 'Rodent detections?', 'Detection summary?'],
        iot:       ['CO2 status?', 'PH3 status?', 'Alert severity?', 'IoT summary?'],
        sack:      ['Bags IN/OUT?', 'FRS status?'],
        nms:       ['NMS summary?', 'NVR details?', 'Worst region?', 'Best region?'],
        warehouse: ['Warehouse count?', 'Region breakdown?', 'Active regions?'],
    };
    setQuickReplies(replies[topic] || []);
};

})();
</script>
<?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\partials\chatbot.blade.php ENDPATH**/ ?>