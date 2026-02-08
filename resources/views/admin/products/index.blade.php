@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Product Management</h1>
        <a href="{{ route('admin.products.create') }}">
            <x-button variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Product
            </x-button>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search products..." 
                   value="{{ request('search') }}"
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            
            <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">All Categories</option>
                <!-- Categories will be populated dynamically -->
            </select>
            
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            
            <x-button type="submit" variant="primary">Filter</x-button>
        </form>
    </div>

    <!-- Products Table -->
    <x-table :headers="['Image', 'Name', 'Category', 'Price', 'Stock', 'Status', 'Merchant']">
        @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/50' }}" 
                         alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover">
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                    <div class="text-sm text-gray-500">SKU: {{ $product->sku ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $product->category->name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">৳{{ number_format($product->price, 2) }}</div>
                    @if($product->discount_price)
                        <div class="text-sm text-green-600">৳{{ number_format($product->discount_price, 2) }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'active' => 'success',
                            'inactive' => 'danger',
                            'draft' => 'warning',
                        ];
                    @endphp
                    <x-badge :variant="$statusVariants[$product->status] ?? 'default'">
                        {{ ucfirst($product->status) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $product->merchant->business_name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">No products found</td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
