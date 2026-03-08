@extends('layouts.customer')

@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->order_number)

@section('content')
<div class="card-solid">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">Order Details</h2>
            <p style="color: var(--text-muted-light); font-size: 0.875rem;">Placed on {{ $order->created_at->format('M d, Y • h:i A') }}</p>
        </div>
        <div style="text-align: right; display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-end;">
            <span style="padding: 0.5rem 1.25rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
                {{ $order->status === 'delivered' ? 'background: rgba(16, 185, 129, 0.1); color: var(--success);' : '' }}
                {{ $order->status === 'pending' ? 'background: rgba(245, 158, 11, 0.1); color: var(--warning);' : '' }}
                {{ $order->status === 'processing' ? 'background: rgba(59, 130, 246, 0.1); color: var(--info);' : '' }}
                {{ $order->status === 'cancelled' ? 'background: rgba(239, 68, 68, 0.1); color: var(--danger);' : '' }}">
                {{ ucfirst($order->status) }}
            </span>
            @if($order->status === 'delivered')
                <a href="{{ route('invoices.download', $order) }}" class="btn-solid" style="background: var(--bg-light); border: 1px solid var(--border-light); color: var(--primary); font-size: 0.8125rem;">
                    📄 Download Invoice
                </a>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem;">
        <!-- Left Column: Items & Shipping -->
        <div>
            <div style="margin-bottom: 2.5rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem;">Order Items ({{ $order->items->count() }})</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($order->items as $item)
                        <div style="display: flex; gap: 1.25rem; background: var(--bg-light); padding: 1.25rem; border-radius: 1rem; align-items: center; border: 1px solid transparent; transition: border-color 0.2s;" onmouseover="this.style.borderColor='var(--border-light)'" onmouseout="this.style.borderColor='transparent'">
                            <div style="width: 80px; height: 80px; border-radius: 0.75rem; overflow: hidden; background: white; border: 1px solid var(--border-light); flex-shrink: 0;">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">📦</div>
                                @endif
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 700; color: var(--text-light); font-size: 1rem; margin-bottom: 0.25rem;">{{ $item->product->name }}</div>
                                <div style="font-size: 0.8125rem; color: var(--text-muted-light); margin-bottom: 0.5rem;">Sold by: {{ $item->merchant->business_name }}</div>
                                @if($item->cashback_amount > 0)
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--success); background: rgba(16, 185, 129, 0.1); padding: 0.25rem 0.625rem; border-radius: 2rem;">
                                        ✨ ৳{{ number_format($item->cashback_amount, 2) }} Cashback Earned
                                    </span>
                                @endif
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; color: var(--primary); font-size: 1.125rem;">৳{{ number_format($item->subtotal, 2) }}</div>
                                <div style="font-size: 0.8125rem; color: var(--text-muted-light);">{{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-solid" style="background: var(--bg-light); border: none; padding: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.25rem;">Shipping Information</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Customer</div>
                        <div style="font-weight: 700; color: var(--text-light);">{{ auth()->user()->name }}</div>
                        <div style="color: var(--text-muted-light); font-size: 0.875rem;">{{ $order->phone }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Shipping Address</div>
                        <div style="color: var(--text-light); line-height: 1.5;">{{ $order->shipping_address }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Payment -->
        <div>
            <div class="card-solid" style="background: var(--primary); color: white; margin-bottom: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">Order Summary</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.9375rem;">
                        <span style="opacity: 0.7;">Subtotal</span>
                        <span style="font-weight: 600;">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9375rem;">
                        <span style="opacity: 0.7;">Shipping Fee</span>
                        <span style="font-weight: 600;">৳0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9375rem;">
                        <span style="opacity: 0.7;">Tax</span>
                        <span style="font-weight: 600;">৳0.00</span>
                    </div>
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span style="font-size: 1.125rem; font-weight: 700;">Grand Total</span>
                        <span style="font-size: 1.375rem; font-weight: 900;">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card-solid" style="background: var(--bg-light); border: none;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.25rem;">Payment Info</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.875rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted-light);">Method:</span>
                        <span style="font-weight: 700; color: var(--text-light); text-transform: uppercase;">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted-light);">Status:</span>
                        <span style="font-weight: 800; color: {{ $order->payment_status === 'paid' ? 'var(--success)' : 'var(--warning)' }}; text-transform: uppercase;">{{ $order->payment_status }}</span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 2rem; text-align: center;">
                <a href="{{ route('orders.index') }}" style="color: var(--text-muted-light); text-decoration: none; font-weight: 700; font-size: 0.875rem;">
                    ← Back to My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
