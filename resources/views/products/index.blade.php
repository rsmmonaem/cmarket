@extends('layouts.customer')

@section('title', 'Marketplace')
@section('page-title', 'Marketplace')

@section('content')
<div style="display: flex; flex-direction: column; md-flex-direction: row; gap: 2rem;">
    <!-- Filters Sidebar -->
    <aside style="width: 100%; md-width: 280px; flex-shrink: 0;">
        <div class="card-solid">
            <h3 style="margin-bottom: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                <span>🔍</span> Filters
            </h3>
            
            <form action="{{ route('products.index') }}" method="GET">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.75rem;">Category</label>
                    <select name="category" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.75rem;">Price Range</label>
                    <div style="display: flex; gap: 0.75rem;">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" style="width: 50%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                        <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" style="width: 50%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.75rem;">Sort By</label>
                    <select name="sort" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light); font-size: 0.875rem;">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Alphabetical</option>
                    </select>
                </div>

                <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center;">
                    Refine Results ✨
                </button>
            </form>
        </div>
    </aside>

    <!-- Products Grid -->
    <div style="flex: 1;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
            @forelse($products as $product)
                <div class="card-solid" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                    <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                        <div style="height: 200px; position: relative; background: #f1f5f9;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                            @endif
                            
                            @if($product->cashback_percentage)
                                <div style="position: absolute; top: 1rem; right: 1rem; background: var(--success); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    {{ $product->cashback_percentage }}% CASHBACK
                                </div>
                            @endif
                        </div>
                        
                        <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                            <div style="font-size: 0.75rem; color: var(--text-muted-light); font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">{{ $product->category->name }}</div>
                            <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.75rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">{{ $product->name }}</h3>
                            
                            <div style="margin-top: auto;">
                                <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1rem;">
                                    @if($product->discount_price)
                                        <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">৳{{ number_format($product->discount_price, 2) }}</span>
                                        <span style="font-size: 0.875rem; color: var(--text-muted-light); text-decoration: line-through;">৳{{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">৳{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: var(--text-muted-light); margin-bottom: 1.5rem;">
                                    <span>Stock: <strong style="color: {{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }}">{{ $product->stock }}</strong></span>
                                    <span>Merchant: <strong>{{ $product->merchant->business_name }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <div style="padding: 0 1.5rem 1.5rem 1.5rem; margin-top: auto;">
                        <button onclick="addToCart({{ $product->id }})" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 0.875rem;">
                            <span>🛒</span> Add to Cart
                        </button>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem;">
                    <div style="font-size: 4rem; margin-bottom: 1.5rem;">🔍</div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">No products matched your criteria</h3>
                    <p style="color: var(--text-muted-light); margin-top: 0.5rem;">Try adjusting your filters or search terms.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 3rem;">
            {{ $products->links() }}
        </div>
    </div>
</div>

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
            alert('Added to your cart! 🛍️');
            location.reload();
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
