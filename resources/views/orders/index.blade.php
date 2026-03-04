@extends('layouts.customer')

@section('title', 'My Orders')
@section('page-title', 'My Order History')

@section('content')
<div class="card-solid">
    @if($orders->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            @foreach($orders as $order)
                <div class="card-solid" style="background: var(--bg-light); border: 1px solid var(--border-light); padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <div style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">Order #{{ $order->order_number }}</div>
                            <div style="font-size: 0.875rem; color: var(--text-muted-light);">Placed on {{ $order->created_at->format('M d, Y • h:i A') }}</div>
                        </div>
                        <div style="text-align: right;">
                            <span style="padding: 0.35rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
                                {{ $order->status === 'delivered' ? 'background: rgba(16, 185, 129, 0.1); color: var(--success);' : '' }}
                                {{ $order->status === 'pending' ? 'background: rgba(245, 158, 11, 0.1); color: var(--warning);' : '' }}
                                {{ $order->status === 'processing' ? 'background: rgba(59, 130, 246, 0.1); color: var(--info);' : '' }}
                                {{ $order->status === 'cancelled' ? 'background: rgba(239, 68, 68, 0.1); color: var(--danger);' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <div style="font-size: 1.25rem; font-weight: 800; color: var(--text-light); mt-2;">৳{{ number_format($order->total_amount, 2) }}</div>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-light); pt-1.5rem; margin-top: 1rem; padding-top: 1.5rem;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                            @foreach($order->items->take(2) as $item)
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <div style="width: 60px; height: 60px; border-radius: 0.75rem; overflow: hidden; background: white; border: 1px solid var(--border-light); flex-shrink: 0;">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-cover: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📦</div>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; color: var(--text-light); font-size: 0.9375rem;">{{ $item->product->name }}</div>
                                        <div style="font-size: 0.8125rem; color: var(--text-muted-light);">Qty: {{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            @if($order->items->count() > 2)
                                <span style="font-size: 0.8125rem; color: var(--text-muted-light); font-weight: 600;">+ {{ $order->items->count() - 2 }} more items in this order</span>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('orders.show', $order) }}" class="btn-solid" style="background: var(--primary); color: white; padding: 0.5rem 1.25rem; font-size: 0.875rem; text-decoration: none;">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    @else
        <div style="padding: 5rem 2rem; text-align: center;">
            <div style="font-size: 5rem; margin-bottom: 1.5rem;">📦</div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.75rem;">No orders found</h2>
            <p style="color: var(--text-muted-light); margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">You haven't placed any orders yet. Start exploring our marketplace to find great deals!</p>
            <a href="{{ route('products.index') }}" class="btn-solid btn-primary-solid" style="padding: 1rem 2.5rem; text-decoration: none;">
                Start Shopping 🛒
            </a>
        </div>
    @endif
</div>
@endsection
