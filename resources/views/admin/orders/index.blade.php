@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Order Management</h1>
        <p class="text-gray-600 mt-1">View and manage all orders</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $orders->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Processing</p>
            <p class="text-2xl font-bold text-blue-600">{{ $orders->where('status', 'processing')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Shipped</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $orders->where('status', 'shipped')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Delivered</p>
            <p class="text-2xl font-bold text-green-600">{{ $orders->where('status', 'delivered')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900">৳{{ number_format($orders->where('status', 'delivered')->sum('total_amount'), 2) }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search by order number..." 
                   value="{{ request('search') }}"
                   class="px-3 py-2 border border-gray-300 rounded-lg">
            
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            
            <input type="date" name="date" value="{{ request('date') }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg">
            
            <x-button type="submit" variant="primary">Filter</x-button>
        </form>
    </div>

    <!-- Orders Table -->
    <x-table :headers="['Order #', 'Customer', 'Merchant', 'Items', 'Amount', 'Status', 'Date']">
        @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $order->user->phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $order->merchant->business_name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $order->items->count() }} items
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">৳{{ number_format($order->total_amount, 2) }}</div>
                    <div class="text-xs text-gray-500">{{ ucfirst($order->payment_method) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'pending' => 'warning',
                            'paid' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'info',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                        ];
                    @endphp
                    <x-badge :variant="$statusVariants[$order->status] ?? 'default'">
                        {{ ucfirst($order->status) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $order->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                        View Details
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">No orders found</td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
