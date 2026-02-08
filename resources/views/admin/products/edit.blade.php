@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
            <p class="text-gray-600 mt-1">Update product information</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-input 
                    label="Product Name" 
                    name="name" 
                    type="text" 
                    :required="true"
                    :value="$product->name"
                />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="description" 
                        rows="4" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-select 
                    label="Category" 
                    name="category_id" 
                    :required="true"
                    :selected="$product->category_id"
                    :options="$categories->pluck('name', 'id')->toArray()"
                />

                <div class="grid grid-cols-2 gap-4">
                    <x-input 
                        label="Price" 
                        name="price" 
                        type="number" 
                        step="0.01"
                        :required="true"
                        :value="$product->price"
                    />

                    <x-input 
                        label="Discount Price" 
                        name="discount_price" 
                        type="number" 
                        step="0.01"
                        :value="$product->discount_price"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-input 
                        label="Stock Quantity" 
                        name="stock" 
                        type="number" 
                        :required="true"
                        :value="$product->stock"
                    />

                    <x-input 
                        label="SKU" 
                        name="sku" 
                        type="text" 
                        :value="$product->sku"
                    />
                </div>

                <x-input 
                    label="Cashback Percentage" 
                    name="cashback_percentage" 
                    type="number" 
                    step="0.01"
                    :value="$product->cashback_percentage"
                />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Product Image
                    </label>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="w-32 h-32 object-cover rounded mb-2">
                    @endif
                    <input 
                        type="file" 
                        name="image" 
                        accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-select 
                    label="Status" 
                    name="status" 
                    :required="true"
                    :selected="$product->status"
                    :options="[
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'draft' => 'Draft',
                    ]"
                />

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.products.index') }}">
                        <x-button variant="outline" type="button">Cancel</x-button>
                    </a>
                    <x-button variant="primary" type="submit">Update Product</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
