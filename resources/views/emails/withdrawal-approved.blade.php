@component('mail::message')
# 🏦 Withdrawal Approved

Hi **{{ $withdrawal->user->name ?? 'User' }}**,

Great news! Your withdrawal request has been **approved** and processed.

@component('mail::panel')
**Amount:** ৳{{ number_format($withdrawal->amount, 2) }}
**Bank:** {{ $withdrawal->bank_name }}
**Account:** {{ $withdrawal->account_number }}
**Processed:** {{ now()->format('d M Y') }}
@endcomponent

Please allow 1-2 business days for the funds to reflect in your account.

@component('mail::button', ['url' => url('/wallet'), 'color' => 'success'])
View Wallet
@endcomponent

Thanks,<br>
**CMarket Team**
@endcomponent
