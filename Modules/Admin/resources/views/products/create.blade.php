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

                <div class="bg-gray-50 p-4 rounded-lg mb-4 border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">SEO Metadata</h3>
                    <x-input 
                        label="Meta Title" 
                        name="meta_title" 
                        type="text" 
                        placeholder="Optimized SEO Title"
                    />
                    <div class="mb-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Meta description for search engines">{{ old('meta_description') }}</textarea>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-4 border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Visibility & Promotion</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm font-bold text-gray-700">Featured Product</span>
                        </label>
                        <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg cursor-pointer">
                            <input type="checkbox" name="is_flash_deal" id="is_flash_deal_toggle" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm font-bold text-gray-700">Enable Flash Deal</span>
                        </label>
                    </div>

                    <div id="flash_deal_config" class="hidden grid grid-cols-2 gap-4">
                        <x-input 
                            label="Flash Deal Start" 
                            name="flash_deal_start" 
                            type="datetime-local" 
                        />
                        <x-input 
                            label="Flash Deal End" 
                            name="flash_deal_end" 
                            type="datetime-local" 
                        />
                    </div>
                </div>

                <script>
                    document.getElementById('is_flash_deal_toggle').addEventListener('change', function() {
                        document.getElementById('flash_deal_config').classList.toggle('hidden', !this.checked);
                    });
                </script>

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
