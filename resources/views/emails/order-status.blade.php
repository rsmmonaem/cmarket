@component('mail::message')
# 📦 Order Status Update

Hi **{{ $order->user->name ?? 'Customer' }}**,

Your order **#{{ $order->order_number }}** status has been updated.

@component('mail::panel')
**New Status:** {{ strtoupper($order->status) }}
**Total:** ৳{{ number_format($order->total_amount, 2) }}
@endcomponent

@component('mail::button', ['url' => url('/orders/' . $order->id)])
Track Order
@endcomponent

Thanks,<br>
**CMarket Team**
@endcomponent
