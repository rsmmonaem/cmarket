@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Add New Product</h1>
            <p class="text-gray-600 mt-1">Create a new product listing</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-input 
                    label="Product Name" 
                    name="name" 
                    type="text" 
                    :required="true"
                    placeholder="Enter product name"
                />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="description" 
                        rows="4" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Product description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-select 
                    label="Category" 
                    name="category_id" 
                    :required="true"
                    :options="$categories->pluck('name', 'id')->toArray()"
                />

                <x-select 
                    label="Merchant" 
                    name="merchant_id" 
                    :required="true"
                    :options="$merchants->pluck('business_name', 'id')->toArray()"
                />

                <div class="grid grid-cols-2 gap-4">
                    <x-input 
                        label="Price" 
                        name="price" 
                        type="number" 
                        step="0.01"
                        :required="true"
                        placeholder="0.00"
                    />

                    <x-input 
                        label="Discount Price" 
                        name="discount_price" 
                        type="number" 
                        step="0.01"
                        placeholder="0.00 (optional)"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-input 
                        label="Stock Quantity" 
                        name="stock" 
                        type="number" 
                        :required="true"
                        placeholder="0"
                    />

                    <x-input 
                        label="SKU" 
                        name="sku" 
                        type="text" 
                        placeholder="Product SKU (optional)"
                    />
                </div>

                <x-input 
                    label="Cashback Percentage" 
                    name="cashback_percentage" 
                    type="number" 
                    step="0.01"
                    placeholder="0.00 (optional)"
                />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Product Image
                    </label>
                    <input 
                        type="file" 
                        name="image" 
                        accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-select 
                    label="Status" 
                    name="status" 
                    :required="true"
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
                    <x-button variant="primary" type="submit">Create Product</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
