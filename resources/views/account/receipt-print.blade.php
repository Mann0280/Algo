@extends('layouts.dashboard')

@section('title', 'Invoice — Stock Predictor')

@section('content')

{{-- ═══════════ ACTION BAR (screen only) ═══════════ --}}
<div class="rcpt-actions no-print">
    <button onclick="window.print()" class="rcpt-print-btn">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print / Download
    </button>
    <a href="{{ route('account.subscription-history') }}" class="rcpt-back-btn">← Back to History</a>
</div>

{{-- ═══════════ INVOICE CARD ═══════════ --}}
<div class="rcpt-wrap">
<div class="rcpt-card" id="invoice">

    {{-- Top gradient stripe --}}
    <div class="rcpt-stripe"></div>

    {{-- ── HEADER ── --}}
    <div class="rcpt-hdr">
        <div class="rcpt-hdr-left">
            <div class="rcpt-logo-box">
                <svg width="26" height="26" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            </div>
            <div>
                <div class="rcpt-brand" style="font-family: 'Cinzel Decorative', serif;">Emperor Stock Predictor</div>
                <div class="rcpt-brand-sub">Elite Neural Trading Intelligence</div>
            </div>
        </div>
        <div class="rcpt-hdr-right">
            <div class="rcpt-inv-label">INVOICE</div>
            <div class="rcpt-inv-num">#ESP-{{ str_pad($record->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    {{-- ── META STRIP ── --}}
    <div class="rcpt-meta">
        <div class="rcpt-meta-item">
            <div class="rcpt-meta-key">Date Issued</div>
            <div class="rcpt-meta-val">{{ $record->purchased_at->format('d M Y') }}</div>
        </div>
        <div class="rcpt-meta-item">
            <div class="rcpt-meta-key">Payment Method</div>
            <div class="rcpt-meta-val">Online / UPI</div>
        </div>
        <div class="rcpt-meta-item">
            <div class="rcpt-meta-key">Reference</div>
            <div class="rcpt-meta-val rcpt-mono">TXN-{{ strtoupper(substr(md5($record->id), 0, 8)) }}</div>
        </div>
        <div class="rcpt-meta-item">
            <div class="rcpt-meta-key">Status</div>
            <div class="rcpt-badge-paid">● Paid</div>
        </div>
    </div>

    {{-- ── PARTIES ── --}}
    <div class="rcpt-parties">
        <div class="rcpt-party">
            <div class="rcpt-party-tag">From</div>
            <div class="rcpt-party-name">Stock Predictor Pvt. Ltd.</div>
            <div class="rcpt-party-line">support@stockpredictor.in</div>
            <div class="rcpt-party-line">Mumbai, Maharashtra, India</div>
        </div>
        <div class="rcpt-party rcpt-party-r">
            <div class="rcpt-party-tag">Billed To</div>
            <div class="rcpt-party-name">{{ $user->username }}</div>
            <div class="rcpt-party-line">{{ $user->email }}</div>
            <div class="rcpt-party-line">Account ID: ESP-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    {{-- ── TABLE ── --}}
    <table class="rcpt-tbl">
        <thead>
            <tr>
                <th class="rcpt-th">#</th>
                <th class="rcpt-th">Description</th>
                <th class="rcpt-th rcpt-c">Plan</th>
                <th class="rcpt-th rcpt-r">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="rcpt-td">1</td>
                <td class="rcpt-td">
                    <strong>{{ $record->plan_name }} Plan — Subscription</strong>
                    <span class="rcpt-td-sub">Access to live signals, neural analytics & premium terminal.</span>
                </td>
                <td class="rcpt-td rcpt-c"><span class="rcpt-plan-pill">{{ strtoupper($record->plan_name) }}</span></td>
                <td class="rcpt-td rcpt-r rcpt-mono rcpt-bold">₹{{ number_format($record->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- ── SUMMARY ── --}}
    <div class="rcpt-summary">
        <div class="rcpt-notes">
            <div class="rcpt-notes-hd">Terms & Conditions</div>
            <div class="rcpt-notes-body">
                1. This subscription is valid for 30 days from issued date.<br>
                2. Signals are for educational purposes based on neural data.<br>
                3. No physical signature is required as this is a digital invoice.<br>
                <strong>GSTIN:</strong> 27AABCE1234F1Z5 (Sample)
            </div>
        </div>
        <div class="rcpt-totals">
            <div class="rcpt-row"><span>Subtotal</span><span class="rcpt-mono">₹{{ number_format($record->amount, 2) }}</span></div>
            <div class="rcpt-row"><span>Tax (0%)</span><span class="rcpt-mono">₹0.00</span></div>
            <div class="rcpt-row rcpt-row-total">
                <span>Total Paid</span>
                <span>₹{{ number_format($record->amount, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="rcpt-foot">
        <span>Generated {{ now()->format('d M Y, h:i A') }} IST</span>
        <span class="rcpt-secure">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Verified &amp; Secure
        </span>
    </div>

</div>{{-- /rcpt-card --}}
</div>{{-- /rcpt-wrap --}}

{{-- ═══════════════════════════════════════════════
     STYLES — scoped with .rcpt- prefix
     ═══════════════════════════════════════════════ --}}
<style>
/* ── Font Import ───────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap');

/* ── Global Style ──────────────────────────── */
body{
    background:#080a18!important;
    background-image: radial-gradient(circle at 50% 50%, rgba(124, 58, 237, 0.05) 0%, transparent 50%)!important;
}

/* ── Hide WhatsApp on this page ────────────── */
.whatsapp-float{display:none!important}

/* ── Action bar ────────────────────────────── */
.rcpt-actions{
    max-width:820px;margin:0 auto;padding:28px 20px 12px;
    display:flex;align-items:center;gap:12px;justify-content:flex-end;
}
.rcpt-print-btn{
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 22px;border:0;border-radius:10px;cursor:pointer;
    background:linear-gradient(135deg,#7c3aed,#a855f7);color:#fff;
    font:600 13px/1 'Inter',sans-serif;letter-spacing:.02em;
    transition:transform .15s,box-shadow .15s;
    box-shadow:0 4px 20px rgba(124,58,237,.35);
}
.rcpt-print-btn:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(124,58,237,.45)}
.rcpt-back-btn{
    padding:10px 18px;border-radius:10px;
    background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);
    color:#9ca3af;font:500 13px/1 'Inter',sans-serif;text-decoration:none;
    transition:background .15s,color .15s;
}
.rcpt-back-btn:hover{background:rgba(255,255,255,.1);color:#fff}

/* ── Container ─────────────────────────────── */
.rcpt-wrap{max-width:820px;margin:0 auto 60px;padding:0 20px}

/* ── Card ──────────────────────────────────── */
.rcpt-card{
    background:#fff;border-radius:14px;overflow:hidden;
    font-family:'Inter',sans-serif;color:#1e293b;
    box-shadow:0 30px 90px rgba(0,0,0,.4),0 0 0 1px rgba(255,255,255,.04);
}

/* ── Top Stripe ────────────────────────────── */
.rcpt-stripe{height:4px;background:linear-gradient(90deg,#6d28d9,#a855f7,#6d28d9)}

/* ───────────── HEADER ─────────────────────── */
.rcpt-hdr{
    display:flex;justify-content:space-between;align-items:center;
    padding:32px 36px 24px;border-bottom:1px solid #e5e7eb;
}
.rcpt-hdr-left{display:flex;align-items:center;gap:14px}
.rcpt-logo-box{
    width:48px;height:48px;border-radius:12px;display:flex;
    align-items:center;justify-content:center;flex-shrink:0;
    background:linear-gradient(135deg,#7c3aed,#a855f7);
}
.rcpt-brand{font:800 20px/1.1 'Inter',sans-serif;color:#0f172a;letter-spacing:-.03em}
.rcpt-brand-sub{font:500 10px/1 'Inter',sans-serif;color:#94a3b8;margin-top:4px;text-transform:uppercase;letter-spacing:.08em}
.rcpt-hdr-right{text-align:right}
.rcpt-inv-label{font:900 32px/1 'Inter',sans-serif;color:#7c3aed;letter-spacing:.06em}
.rcpt-inv-num{font:600 12px/1 'Inter',sans-serif;color:#94a3b8;margin-top:6px}

/* ───────────── META STRIP ─────────────────── */
.rcpt-meta{
    display:grid;grid-template-columns:repeat(4,1fr);
    border-bottom:1px solid #e5e7eb;
}
.rcpt-meta-item{
    padding:16px 20px;
    border-right:1px solid #f1f5f9;
}
.rcpt-meta-item:last-child{border-right:none}
.rcpt-meta-key{font:600 9px/1 'Inter',sans-serif;color:#94a3b8;text-transform:uppercase;letter-spacing:.1em;margin-bottom:6px}
.rcpt-meta-val{font:600 13px/1 'Inter',sans-serif;color:#1e293b}
.rcpt-mono{font-family:'SF Mono','Fira Code','Consolas',monospace;font-size:12px}
.rcpt-badge-paid{
    display:inline-flex;align-items:center;gap:4px;
    padding:4px 12px;border-radius:20px;
    background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;
    font:700 11px/1 'Inter',sans-serif;
}

/* ───────────── PARTIES ────────────────────── */
.rcpt-parties{
    display:grid;grid-template-columns:1fr 1fr;
    padding:24px 36px;border-bottom:1px solid #e5e7eb;
    background:#f8fafc;
}
.rcpt-party-r{text-align:right}
.rcpt-party-tag{
    font:700 9px/1 'Inter',sans-serif;color:#7c3aed;
    text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px;
}
.rcpt-party-name{font:700 14px/1.3 'Inter',sans-serif;color:#0f172a;margin-bottom:4px}
.rcpt-party-line{font:400 12px/1.6 'Inter',sans-serif;color:#64748b}

/* ───────────── TABLE ──────────────────────── */
.rcpt-tbl{width:100%;border-collapse:collapse}
.rcpt-th{
    padding:12px 24px;text-align:left;
    font:700 9px/1 'Inter',sans-serif;color:#94a3b8;
    text-transform:uppercase;letter-spacing:.1em;
    background:#f8fafc;border-bottom:1px solid #e5e7eb;
}
.rcpt-td{
    padding:18px 24px;vertical-align:top;
    font:400 13px/1.5 'Inter',sans-serif;color:#334155;
    border-bottom:1px solid #f1f5f9;
}
.rcpt-td strong{display:block;font-weight:600;color:#0f172a;margin-bottom:2px}
.rcpt-td-sub{display:block;font-size:11px;color:#94a3b8;line-height:1.4}
.rcpt-c{text-align:center}
.rcpt-r{text-align:right}
.rcpt-bold{font-weight:700!important;color:#0f172a!important;font-size:14px!important}
.rcpt-plan-pill{
    display:inline-block;padding:4px 14px;border-radius:20px;
    background:#f3f0ff;color:#7c3aed;border:1px solid #ddd6fe;
    font:700 10px/1 'Inter',sans-serif;letter-spacing:.06em;
}

/* ───────────── SUMMARY / TOTALS ───────────── */
.rcpt-summary{
    display:flex;gap:32px;padding:24px 36px;
    border-top:1px solid #e5e7eb;
}
.rcpt-notes{flex:1.3}
.rcpt-notes-hd{font:700 10px/1 'Inter',sans-serif;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}
.rcpt-notes-body{font:400 11px/1.7 'Inter',sans-serif;color:#94a3b8;max-width:340px}
.rcpt-totals{flex:.7;display:flex;flex-direction:column}
.rcpt-row{
    display:flex;justify-content:space-between;
    padding:7px 0;font:500 12px/1 'Inter',sans-serif;color:#64748b;
    border-bottom:1px solid #f1f5f9;
}
.rcpt-row-total{
    margin-top:8px;padding:12px 18px;border:0;border-radius:10px;
    background:linear-gradient(135deg,#6d28d9,#7c3aed);color:#fff;
    font:800 15px/1 'Inter',sans-serif;
}

/* ───────────── FOOTER ─────────────────────── */
.rcpt-foot{
    display:flex;justify-content:space-between;align-items:center;
    padding:16px 36px;background:#f8fafc;border-top:1px solid #e5e7eb;
    font:400 10px/1 'Inter',sans-serif;color:#94a3b8;
}
.rcpt-secure{
    display:inline-flex;align-items:center;gap:5px;
    padding:5px 14px;border-radius:8px;
    background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;
    font:600 10px/1 'Inter',sans-serif;
}

/* ══════════════ PRINT ═════════════════════════ */
@media print{
    @page{size:A4 portrait;margin:14mm 12mm}
    body{background:#fff!important;margin:0!important;padding:0!important}
    .no-print,.sidebar,nav,header,footer,aside,.whatsapp-float,.rcpt-actions{display:none!important}
    .rcpt-wrap{max-width:none;margin:0;padding:0}
    .rcpt-card{border-radius:0;box-shadow:none}

    /* Force backgrounds in print */
    .rcpt-stripe{background:linear-gradient(90deg,#6d28d9,#a855f7,#6d28d9)!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    .rcpt-logo-box{background:linear-gradient(135deg,#7c3aed,#a855f7)!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    .rcpt-row-total{background:linear-gradient(135deg,#6d28d9,#7c3aed)!important;color:#fff!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    .rcpt-badge-paid{background:#ecfdf5!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    .rcpt-plan-pill{background:#f3f0ff!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    .rcpt-th,.rcpt-parties,.rcpt-foot{background:#f8fafc!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    .rcpt-secure{background:#ecfdf5!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
}
</style>

@endsection
