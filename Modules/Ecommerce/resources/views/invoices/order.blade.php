<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>C-Market Invoice - {{ $order->order_number }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #1e293b;
            margin: 0;
            padding: 40pt;
            background-color: #fff;
        }
        .matrix-header {
            margin-bottom: 40pt;
            border-bottom: 4pt solid #f97316;
            padding-bottom: 20pt;
        }
        .matrix-header table {
            width: 100%;
        }
        .logo-text {
            font-size: 28pt;
            font-weight: 900;
            color: #1e293b;
            letter-spacing: -1pt;
        }
        .logo-accent {
            color: #f97316;
        }
        .invoice-title {
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 2pt;
            font-weight: 900;
            color: #f97316;
            font-size: 20pt;
        }
        .section-container {
            margin-bottom: 30pt;
        }
        .section-container table {
            width: 100%;
        }
        .section-title {
            font-size: 9pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1pt;
            color: #94a3b8;
            margin-bottom: 10pt;
            border-bottom: 1pt solid #f1f5f9;
            padding-bottom: 5pt;
        }
        .info-label {
            color: #64748b;
            font-weight: bold;
            font-size: 10pt;
        }
        .info-value {
            font-weight: 900;
            font-size: 10pt;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20pt;
        }
        .items-table th {
            background-color: #1e293b;
            color: white;
            padding: 12pt;
            text-align: left;
            text-transform: uppercase;
            font-size: 9pt;
            letter-spacing: 1pt;
        }
        .items-table td {
            padding: 12pt;
            border-bottom: 1pt solid #f1f5f9;
            font-size: 10pt;
        }
        .merchant-tag {
            font-weight: 900;
            color: #f97316;
            font-size: 8pt;
            text-transform: uppercase;
            display: block;
            margin-top: 2pt;
        }
        .amount-col {
            text-align: right;
            font-weight: 900;
        }
        .totals-container {
            margin-top: 30pt;
            float: right;
            width: 250pt;
        }
        .total-row {
            padding: 8pt 0;
            border-bottom: 1pt solid #f1f5f9;
        }
        .total-row.grand {
            background-color: #f97316;
            color: white;
            padding: 15pt;
            border-radius: 10pt;
            margin-top: 10pt;
        }
        .qr-placeholder {
            width: 80pt;
            height: 80pt;
            background-color: #f8fafc;
            border: 1pt solid #e2e8f0;
            display: inline-block;
            margin-top: 30pt;
            text-align: center;
            line-height: 80pt;
            font-size: 8pt;
            color: #94a3b8;
            font-weight: bold;
        }
        .footer {
            position: relative;
            bottom: 40pt;
            left: 40pt;
            right: 40pt;
            text-align: center;
            border-top: 1pt solid #f1f5f9;
            padding-top: 20pt;
        }
        .footer p {
            font-size: 8pt;
            color: #94a3b8;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1pt;
        }
    </style>
</head>
<body>
    <div class="matrix-header">
        <table>
            <tr>
                <td>
                    <div class="logo-text">C-<span class="logo-accent">Market</span></div>
                    <div style="font-size: 8pt; color: #94a3b8; font-weight: bold; text-transform: uppercase; letter-spacing: 2pt; margin-top: 5pt;">Premium Marketplace Infrastructure</div>
                </td>
                <td class="invoice-title">Official Invoice</td>
            </tr>
        </table>
    </div>

    <div class="section-container">
        <table>
            <tr>
                <td width="50%" style="vertical-align: top;">
                    <div class="section-title">Customer Details</div>
                    <div class="info-value" style="font-size: 12pt;">{{ $order->user->name }}</div>
                    <div class="info-label" style="margin-top: 5pt;">{{ $order->shipping_address }}</div>
                    <div class="info-label">📞 {{ $order->shipping_phone }}</div>
                </td>
                <td width="50%" style="vertical-align: top; text-align: right;">
                    <div class="section-title">Order Information</div>
                    <div class="total-row">
                        <span class="info-label">Order Number:</span>
                        <span class="info-value">{{ $order->order_number }}</span>
                    </div>
                    <div class="total-row">
                        <span class="info-label">Order Date:</span>
                        <span class="info-value">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="total-row">
                        <span class="info-label">Payment Method:</span>
                        <span class="info-value">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Product Manifest</div>
    <table class="items-table">
        <thead>
            <tr>
                <th width="50%">Item Description</th>
                <th width="15%">Quantity</th>
                <th width="15%">Unit Price</th>
                <th width="20%" class="amount-col">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="info-value">{{ $item->product->name }}</div>
                        <span class="merchant-tag">Sold by: {{ $item->product->merchant->business_name }}</span>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>৳{{ number_format($item->price, 2) }}</td>
                    <td class="amount-col">৳{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-container">
        <div class="total-row" style="border: none;">
            <table width="100%">
                <tr>
                    <td class="info-label">Subtotal:</td>
                    <td class="amount-col">৳{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="total-row">
            <table width="100%">
                <tr>
                    <td class="info-label">Tax (0%):</td>
                    <td class="amount-col">৳0.00</td>
                </tr>
            </table>
        </div>
        <div class="total-row">
            <table width="100%">
                <tr>
                    <td class="info-label">Shipping:</td>
                    <td class="amount-col">৳0.00</td>
                </tr>
            </table>
        </div>
        <div class="total-row grand">
            <table width="100%">
                <tr>
                    <td style="font-weight: 900; text-transform: uppercase; font-size: 10pt;">Final Amount:</td>
                    <td class="amount-col" style="font-size: 14pt;">৳{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    @php
        $trackingUrl = url('/tracking?order_number=' . $order->order_number . '&phone=' . $order->shipping_phone);
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($trackingUrl);
    @endphp

    <div style="margin-top: 50pt;">
        <div style="float: left; width: 100pt; text-align: center;">
            <img src="{{ $qrCodeUrl }}" style="width: 80pt; height: 80pt; border: 1pt solid #e2e8f0; padding: 5pt; border-radius: 8pt;">
            <div style="font-size: 7pt; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 1pt; margin-top: 5pt;">Scan to Verify</div>
        </div>
        {{-- <div style="float: left; margin-left: 20pt; margin-top: 15pt;">
            <div class="info-label">Verification Link</div>
            <div style="font-size: 8pt; font-weight: bold; color: #f97316;">{{ $trackingUrl }}</div>
        </div> --}}
    </div>

    {{-- <div class="footer">
        <p>This is a computer generated invoice and does not require a physical signature.</p>
        <p>Thank you for shopping with C-Market &copy; {{ date('Y') }}</p>
    </div> --}}
</body>
</html>
