@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Order Header -->
        <div class="border-b pb-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Order #{{ $order->order_number }}</h1>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">Order Items</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex gap-4 p-4 border rounded-lg">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-20 h-20 object-cover rounded">
                        @else
                            <div class="w-20 h-20 bg-gray-200 flex items-center justify-center rounded">
                                <span class="text-gray-400 text-2xl">📦</span>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="font-semibold">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600">Sold by: {{ $item->merchant->business_name }}</p>
                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            @if($item->cashback_amount > 0)
                                <p class="text-sm text-green-600">Cashback: ৳{{ number_format($item->cashback_amount, 2) }}</p>
                            @endif
                        </div>
                        
                        <div class="text-right">
                            <p class="font-bold">৳{{ number_format($item->subtotal, 2) }}</p>
                            <p class="text-sm text-gray-600">৳{{ number_format($item->price, 2) }} each</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="border-t pt-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="font-medium">{{ auth()->user()->name }}</p>
                <p class="text-gray-600">{{ $order->phone }}</p>
                <p class="text-gray-600">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="border-t pt-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method:</span>
                    <span class="font-medium">{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Status:</span>
                    <span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="border-t pt-6">
            <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="font-medium">৳{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping:</span>
                    <span class="font-medium">৳0.00</span>
                </div>
                <div class="border-t pt-2 flex justify-between">
                    <span class="text-lg font-bold">Total:</span>
                    <span class="text-lg font-bold text-indigo-600">৳{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="border-t pt-6 mt-6">
            <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection
