<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->order_number }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            @page { margin: 8mm; size: 80mm auto; }
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', monospace; font-size: 11px; color: #111; background: #fff; padding: 12px; max-width: 300px; margin: 0 auto; }
        .brand { text-align: center; font-size: 18px; font-weight: 900; letter-spacing: 2px; margin-bottom: 4px; }
        .tagline { text-align: center; font-size: 9px; color: #555; margin-bottom: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .divider { border-top: 1px dashed #aaa; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .row .label { color: #555; }
        .items-header { font-weight: 900; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; margin: 6px 0 4px; color: #555; }
        .item { border-bottom: 1px dotted #eee; padding: 3px 0; }
        .total-row { font-weight: 900; font-size: 13px; }
        .footer { text-align: center; font-size: 9px; color: #888; margin-top: 12px; }
        .btn { display: inline-block; margin: 10px; padding: 8px 20px; background: #111; color: #fff; font-size: 10px; text-decoration: none; border-radius: 6px; cursor: pointer; font-family: sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border: none; }
    </style>
</head>
<body>
    <div class="brand">CMARKET</div>
    <div class="tagline">Your Trusted Marketplace</div>
    <div class="divider"></div>
    <div class="row"><span class="label">Order #</span><strong>{{ $order->order_number }}</strong></div>
    <div class="row"><span class="label">Date</span><span>{{ $order->created_at->format('d M Y H:i') }}</span></div>
    <div class="row"><span class="label">Customer</span><span>{{ $order->user->name }}</span></div>
    <div class="row"><span class="label">Phone</span><span>{{ $order->shipping_phone }}</span></div>
    <div class="divider"></div>
    <div class="items-header">Items</div>
    @foreach($order->items as $item)
    <div class="item">
        <div class="row">
            <span>{{ $item->product_name }}</span>
            <span>৳{{ number_format($item->subtotal, 2) }}</span>
        </div>
        <div style="font-size:9px;color:#888;">Qty: {{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</div>
    </div>
    @endforeach
    <div class="divider"></div>
    @if($order->coupon_discount > 0)
    <div class="row"><span class="label">Coupon Discount</span><span style="color:#16a34a">-৳{{ number_format($order->coupon_discount, 2) }}</span></div>
    @endif
    <div class="row total-row"><span>TOTAL</span><span>৳{{ number_format($order->total_amount, 2) }}</span></div>
    <div class="row"><span class="label">Payment</span><span>{{ strtoupper($order->payment_method) }}</span></div>
    <div class="row"><span class="label">Status</span><span>{{ strtoupper($order->payment_status) }}</span></div>
    <div class="divider"></div>
    @if($order->notes)
    <div style="font-size:9px;color:#555;margin-bottom:8px;">Notes: {{ $order->notes }}</div>
    @endif
    <div class="footer">
        Thank you for shopping with CMarket!<br>
        Keep this receipt for your records.
    </div>

    <div class="no-print" style="text-align:center;margin-top:16px;">
        <button class="btn" onclick="window.print()">🖨️ Print Receipt</button>
        <a class="btn" style="background:#333;" href="{{ url()->previous() }}">✕ Close</a>
    </div>
</body>
</html>
