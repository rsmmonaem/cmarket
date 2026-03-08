@component('mail::message')
# ✅ Order Confirmed

Hi **{{ $order->user->name ?? 'Customer' }}**,

Thank you for your order! We've received it and it's being processed.

@component('mail::panel')
**Order Number:** #{{ $order->order_number }}
**Total:** ৳{{ number_format($order->total_amount, 2) }}
**Payment:** {{ strtoupper($order->payment_method) }}
**Status:** Pending
@endcomponent

## Items Ordered

@foreach($order->items as $item)
- **{{ $item->product_name }}** × {{ $item->quantity }} — ৳{{ number_format($item->subtotal, 2) }}
@endforeach

@component('mail::button', ['url' => url('/orders/' . $order->id), 'color' => 'primary'])
View Order
@endcomponent

We'll notify you when your order ships.

Thanks,<br>
**CMarket Team**
@endcomponent
