@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
                <p class="text-gray-600 mt-1">{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <x-badge :variant="$order->status == 'delivered' ? 'success' : 'warning'" class="text-lg px-4 py-2">
                {{ ucfirst($order->status) }}
            </x-badge>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 pb-4 border-b border-gray-200 last:border-0">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" 
                                     alt="{{ $item->product_name }}" class="w-20 h-20 rounded object-cover">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $item->product_name }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">৳{{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-6 pt-4 border-t border-gray-200 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">৳{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="text-green-600">-৳{{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">৳{{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        @if($order->cashback_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Cashback</span>
                                <span class="text-blue-600">৳{{ number_format($order->cashback_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-semibold pt-2 border-t border-gray-200">
                            <span>Total</span>
                            <span>৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                @if($order->status != 'delivered' && $order->status != 'cancelled')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Update Order Status</h2>
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            <div class="flex gap-3">
                                <select name="status" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                </select>
                                <x-button variant="primary" type="submit">Update</x-button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer</h2>
                    <div class="space-y-2">
                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->phone }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Shipping Address</h2>
                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment</h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-500">Method</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <x-badge :variant="$order->payment_status == 'paid' ? 'success' : 'warning'">
                                {{ ucfirst($order->payment_status) }}
                            </x-badge>
                        </div>
                    </div>
                </div>

                <!-- Merchant Info -->
                @if($order->merchant)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Merchant</h2>
                        <p class="font-medium text-gray-900">{{ $order->merchant->business_name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->merchant->user->phone }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
