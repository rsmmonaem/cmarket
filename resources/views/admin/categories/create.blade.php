@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Add New Category</h1>
            <p class="text-gray-600 mt-1">Create a new product category</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-input 
                    label="Category Name" 
                    name="name" 
                    type="text" 
                    :required="true"
                    placeholder="Enter category name"
                />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Category description (optional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-select 
                    label="Parent Category" 
                    name="parent_id" 
                    :options="['' => 'None (Root Category)'] + $categories->pluck('name', 'id')->toArray()"
                />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category Image
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

                <x-input 
                    label="Sort Order" 
                    name="sort_order" 
                    type="number" 
                    :value="0"
                    placeholder="0"
                />

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked 
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.categories.index') }}">
                        <x-button variant="outline" type="button">Cancel</x-button>
                    </a>
                    <x-button variant="primary" type="submit">Create Category</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
