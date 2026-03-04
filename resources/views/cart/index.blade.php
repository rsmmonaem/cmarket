@extends('layouts.customer')

@section('title', 'My Shopping Bag')
@section('page-title', 'Shopping Bag')

@section('content')
@if(empty($cartItems))
    <div class="card-solid" style="text-align: center; padding: 6rem 2rem;">
        <div style="font-size: 5rem; margin-bottom: 1.5rem;">🛍️</div>
        <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--primary); margin-bottom: 0.75rem;">Your bag is empty</h2>
        <p style="color: var(--text-muted-light); margin-bottom: 2.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">Looks like you haven't added anything to your bag yet. Explore our latest products and find something you love!</p>
        <a href="{{ route('products.index') }}" class="btn-solid btn-primary-solid" style="padding: 1rem 3rem; text-decoration: none; font-size: 1rem;">
            Continue Shopping ✨
        </a>
    </div>
@else
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">
        <!-- Cart Items -->
        <div>
            <div class="card-solid" style="padding: 0; overflow: hidden;">
                <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-light); background: var(--bg-light); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--primary);">Items in Bag ({{ count($cartItems) }})</h3>
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear all items from your bag?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: var(--danger); font-size: 0.8125rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem;">
                            <span>🗑️</span> Clear Bag
                        </button>
                    </form>
                </div>
                
                <div style="display: flex; flex-direction: column;">
                    @foreach($cartItems as $item)
                        <div style="display: flex; gap: 1.5rem; padding: 2rem; border-bottom: 1px solid var(--border-light); last-child: border-bottom: none; align-items: center;">
                            <div style="width: 100px; height: 100px; border-radius: 1rem; overflow: hidden; background: #f8fafc; border: 1px solid var(--border-light); flex-shrink: 0;">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">📦</div>
                                @endif
                            </div>

                            <div style="flex: 1;">
                                <div style="font-size: 0.75rem; font-weight: 800; color: var(--info); text-transform: uppercase; margin-bottom: 0.25rem;">{{ $item['product']->category->name }}</div>
                                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-light); margin-bottom: 0.5rem;">
                                    <a href="{{ route('products.show', $item['product']) }}" style="text-decoration: none; color: inherit;">{{ $item['product']->name }}</a>
                                </h3>
                                <div style="font-weight: 800; color: var(--primary); font-size: 1.125rem;">৳{{ number_format($item['product']->price, 2) }}</div>
                            </div>

                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 1rem;">
                                <div style="display: flex; align-items: center; background: var(--bg-light); border-radius: 0.75rem; padding: 0.25rem; border: 1px solid var(--border-light);">
                                    <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" style="display: flex; align-items: center;">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}"
                                               style="width: 50px; background: transparent; border: none; text-align: center; font-weight: 800; color: var(--primary); outline: none;">
                                        <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 0.6rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; margin-left: 0.25rem;">Update</button>
                                    </form>
                                </div>

                                <div style="display: flex; align-items: center; gap: 1.5rem;">
                                    <div style="text-align: right;">
                                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted-light); text-transform: uppercase;">Subtotal</div>
                                        <div style="font-size: 1.25rem; font-weight: 900; color: var(--primary);">৳{{ number_format($item['subtotal'], 2) }}</div>
                                    </div>
                                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--danger)'; this.style.color='white'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='var(--danger)'">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div style="position: sticky; top: 1.5rem;">
            <div class="card-solid" style="background: var(--primary); color: white;">
                <h2 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">Bag Summary</h2>
                
                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 1rem;">
                        <span style="opacity: 0.7;">Initial Subtotal</span>
                        <span style="font-weight: 600;">৳{{ number_format($total, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 1rem;">
                        <span style="opacity: 0.7;">Estimated Shipping</span>
                        <span style="font-weight: 600;">৳0.00</span>
                    </div>
                    <div style="margin-top: 1rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 1.125rem; font-weight: 700;">Total Amount</span>
                        <span style="font-size: 1.75rem; font-weight: 900; color: white;">৳{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-solid" style="width: 100%; background: white; color: var(--primary); justify-content: center; padding: 1.25rem; font-size: 1.125rem; text-decoration: none;">
                    Checkout Securely ➔
                </a>
            </div>

            <div style="margin-top: 1.5rem; text-align: center;">
                <a href="{{ route('products.index') }}" style="color: var(--text-muted-light); text-decoration: none; font-weight: 700; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted-light)'">
                    ← Back to Marketplace
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
