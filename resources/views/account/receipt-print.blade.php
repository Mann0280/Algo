<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP-{{ $record->transaction_id ?? $record->id }} | Payment Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Orbitron:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: #9333ea;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-light: #f5f7fb;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* Controls Section */
        .controls {
            width: 100%;
            max-width: 700px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 24px;
        }

        .btn {
            display: inline-flex;
            items-center: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: 1px solid var(--border);
            background: white;
            color: var(--text-main);
        }

        .btn:hover {
            background: #f9fafb;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #7e22ce;
        }

        /* Receipt Card */
        .receipt-card {
            width: 100%;
            max-width: 700px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .receipt-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary), #6366f1);
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 48px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-symbol {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .platform-name {
            font-family: 'Orbitron', sans-serif;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .receipt-title-section {
            text-align: right;
        }

        .receipt-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            font-weight: 900;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .tx-id {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 1px;
        }

        /* Details Grid */
        .details-grid {
            border-top: 1px solid var(--border);
            padding-top: 32px;
            margin-bottom: 48px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
        }

        .detail-row:not(:last-child) {
            border-bottom: 1px dashed var(--border);
        }

        .label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
        }

        .value-amount {
            font-size: 20px;
            color: var(--text-main);
        }

        /* Status Badge */
        .badge {
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-completed { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .status-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .status-failed { background: rgba(239, 68, 68, 0.1); color: var(--danger); }

        /* Footer */
        footer {
            text-align: center;
            padding-top: 32px;
            border-top: 1px solid var(--border);
        }

        .footer-msg {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .support-info {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
        }

        .support-email {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        /* Print Styles */
        @media print {
            body {
                background-color: white !important;
                padding: 0 !important;
            }
            .controls {
                display: none !important;
            }
            .receipt-card {
                box-shadow: none !important;
                padding: 40px !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
            }
            @page {
                margin: 2cm;
            }
        }

        @media (max-width: 640px) {
            .receipt-card {
                padding: 24px;
            }
            header {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 20px;
            }
            .receipt-title-section {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="controls">
        <button onclick="window.print()" class="btn btn-primary">
            <i data-lucide="printer" style="width: 16px; height: 16px;"></i> Print Protocol
        </button>
        <button onclick="window.print()" class="btn">
            <i data-lucide="download" style="width: 16px; height: 16px;"></i> Download PDF
        </button>
        <button onclick="window.close()" class="btn">
            <i data-lucide="x" style="width: 16px; height: 16px;"></i> Close
        </button>
    </div>

    <div class="receipt-card" id="printable-receipt">
        <header>
            <div class="logo-section">
                <div class="logo-symbol">
                    <i data-lucide="zap" style="width: 24px; height: 24px; fill: white;"></i>
                </div>
                <div class="platform-name">Emperor Predict</div>
            </div>
            <div class="receipt-title-section">
                <div class="receipt-title">PAYMENT RECEIPT</div>
                <div class="tx-id">TX_ID: {{ $record->transaction_id ?? 'EPS-' . strtoupper(substr(md5($record->id), 0, 10)) }}</div>
            </div>
        </header>

        <div class="details-grid">
            <div class="detail-row">
                <span class="label">Protocol Plan</span>
                <span class="value uppercase">{{ $record->plan_name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Amount Paid</span>
                <span class="value value-amount">₹{{ number_format($record->amount, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Protocol Type</span>
                <span class="value">Sync Payment</span>
            </div>
            <div class="detail-row">
                <span class="label">Purchase Date</span>
                <span class="value">{{ $record->purchased_at->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Termination Date</span>
                <span class="value">{{ $record->expires_at ? $record->expires_at->format('d M Y') : 'UNLIMITED' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Status</span>
                <span class="badge status-{{ strtolower($record->status) ?? 'completed' }}">
                    {{ $record->status ?? 'Completed' }}
                </span>
            </div>
        </div>

        <footer>
            <div class="footer-msg">Thank you for using Emperor Predict AI Trading Platform</div>
            <div class="support-info">
                Support Node: <a href="mailto:support@emperorpredict.com" class="support-email">support@emperorpredict.com</a>
            </div>
        </footer>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
