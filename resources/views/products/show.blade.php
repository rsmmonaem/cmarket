@extends('layouts.customer')

@section('title', $product->name)
@section('page-title', 'Product Details')

@section('content')
<div class="card-solid" style="padding: 0; overflow: hidden;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
        <!-- Product Image Section -->
        <div style="background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 2.5rem; border-right: 1px solid var(--border-light);">
            <div style="width: 100%; max-width: 500px; border-radius: 1.5rem; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: auto; display: block;">
                @else
                    <div style="width: 100%; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; background: white; font-size: 6rem;">📦</div>
                @endif
            </div>
        </div>

        <!-- Product Details Section -->
        <div style="padding: 3rem;">
            <div style="margin-bottom: 0.75rem;">
                <a href="{{ route('products.index', ['category' => $product->category_id]) }}" style="background: rgba(59, 130, 246, 0.1); color: var(--info); padding: 0.35rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ $product->category->name }}
                </a>
            </div>
            
            <h1 style="font-size: 2.25rem; font-weight: 900; color: var(--primary); margin-bottom: 1.5rem; line-height: 1.2;">{{ $product->name }}</h1>
            
            <div style="display: flex; align-items: baseline; gap: 1rem; margin-bottom: 2rem;">
                @if($product->discount_price)
                    <span style="font-size: 2.5rem; font-weight: 900; color: var(--primary);">৳{{ number_format($product->discount_price, 2) }}</span>
                    <span style="font-size: 1.25rem; color: var(--text-muted-light); text-decoration: line-through;">৳{{ number_format($product->price, 2) }}</span>
                    <span style="background: var(--danger); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.8125rem; font-weight: 800;">
                        {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                    </span>
                @else
                    <span style="font-size: 2.5rem; font-weight: 900; color: var(--primary);">৳{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            @if($product->cashback_percentage)
                <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%); border-left: 4px solid var(--success); padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="font-size: 1.5rem;">🎉</div>
                    <div>
                        <div style="font-weight: 800; color: var(--success); font-size: 1rem;">{{ $product->cashback_percentage }}% Instant Cashback</div>
                        <div style="color: var(--text-muted-light); font-size: 0.875rem;">Get back <strong>৳{{ number_format(($product->discount_price ?? $product->price) * $product->cashback_percentage / 100, 2) }}</strong> in your wallet!</div>
                    </div>
                </div>
            @endif

            <div style="margin-bottom: 2.5rem;">
                <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.05em;">Product Description</h3>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 1rem;">{{ $product->description }}</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 3rem; background: var(--bg-light); padding: 1.5rem; border-radius: 1rem;">
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.25rem;">Availability</div>
                    <div style="font-weight: 700; color: {{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }}; font-size: 0.9375rem;">
                        {{ $product->stock > 0 ? $product->stock . ' units in stock' : 'Currently Out of Stock' }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.25rem;">Shipment</div>
                    <div style="font-weight: 700; color: var(--text-light); font-size: 0.9375rem;">Standard Delivery</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.25rem;">Verified Merchant</div>
                    <div style="font-weight: 700; color: var(--text-light); font-size: 0.9375rem;">{{ $product->merchant->business_name }}</div>
                </div>
            </div>

            @if($product->stock > 0)
                <button onclick="addToCart({{ $product->id }})" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 1.25rem; font-size: 1.125rem;">
                    <span>🛒</span> Add to Cart
                </button>
            @else
                <button disabled style="width: 100%; background: #e2e8f0; color: #94a3b8; padding: 1.25rem; border-radius: 0.75rem; border: none; font-weight: 700; font-size: 1.125rem; cursor: not-allowed;">
                    Out of Stock 📦
                </button>
            @endif
        </div>
    </div>
</div>

@if($relatedProducts->count() > 0)
    <div style="margin-top: 4rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-bottom: 2rem;">Recommended Products</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
            @foreach($relatedProducts as $related)
                <div class="card-solid" style="padding: 0; overflow: hidden; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <a href="{{ route('products.show', $related) }}" style="text-decoration: none; color: inherit;">
                        <div style="height: 180px; background: #f8fafc; border-bottom: 1px solid var(--border-light);">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">📦</div>
                            @endif
                        </div>
                        <div style="padding: 1.25rem;">
                            <h3 style="font-size: 1rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $related->name }}</h3>
                            <div style="font-size: 1.125rem; font-weight: 800; color: var(--primary);">৳{{ number_format($related->price, 2) }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif

<script>
function addToCart(productId) {
    @guest
        window.location.href = '{{ route("login") }}';
        return;
    @endguest
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Selection added to your bag! 🛒');
            window.location.href = '{{ route("cart.index") }}';
        } else {
            alert(data.message || 'Error occurred while adding to cart.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Could not add to cart. Please try again.');
    });
}
</script>
@endsection
