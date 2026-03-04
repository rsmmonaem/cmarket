@extends('layouts.customer')

@section('title', 'Secure Checkout')
@section('page-title', 'Checkout')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">
    <!-- Checkout Form -->
    <div>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <!-- Shipping Information -->
            <div class="card-solid" style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem;">
                    <span style="font-size: 1.5rem;">📍</span>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">Shipping Details</h2>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Full Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly
                               style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: var(--bg-light); color: var(--text-muted-light); font-weight: 600;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Phone Number *</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" required
                               style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Shipping Address *</label>
                    <textarea name="shipping_address" rows="3" required placeholder="Enter your full street address, city, and zip code"
                              style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'"></textarea>
                </div>

                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Order Notes (Optional)</label>
                    <textarea name="notes" rows="2" placeholder="Any special instructions for delivery?"
                              style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'"></textarea>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card-solid" style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem;">
                    <span style="font-size: 1.5rem;">💳</span>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">Payment Selection</h2>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <label style="display: flex; align-items: center; padding: 1.5rem; border: 2px solid var(--border-light); border-radius: 1rem; cursor: pointer; transition: all 0.2s; position: relative;" class="payment-option">
                        <input type="radio" name="payment_method" value="wallet" style="margin-right: 1.25rem; width: 20px; height: 20px; accent-color: var(--primary);" required>
                        <div style="flex: 1;">
                            <div style="font-weight: 800; color: var(--primary); font-size: 1rem; margin-bottom: 0.25rem;">Wallet Payment</div>
                            <div style="font-size: 0.875rem; color: var(--text-muted-light);">
                                Available Balance: <strong style="color: var(--success);">৳{{ number_format($mainWallet->balance ?? 0, 2) }}</strong>
                            </div>
                        </div>
                        <span style="font-size: 1.5rem; opacity: 0.5;">🏦</span>
                    </label>

                    <label style="display: flex; align-items: center; padding: 1.5rem; border: 2px solid var(--border-light); border-radius: 1rem; cursor: pointer; transition: all 0.2s; position: relative;" class="payment-option">
                        <input type="radio" name="payment_method" value="cod" style="margin-right: 1.25rem; width: 20px; height: 20px; accent-color: var(--primary);">
                        <div style="flex: 1;">
                            <div style="font-weight: 800; color: var(--primary); font-size: 1rem; margin-bottom: 0.25rem;">Cash on Delivery</div>
                            <div style="font-size: 0.875rem; color: var(--text-muted-light);">Pay in cash when your order reaches your doorstep</div>
                        </div>
                        <span style="font-size: 1.5rem; opacity: 0.5;">🚛</span>
                    </label>

                    <label style="display: flex; align-items: center; padding: 1.5rem; border: 2px solid var(--border-light); border-radius: 1rem; cursor: not-allowed; position: relative; opacity: 0.5; background: var(--bg-light);">
                        <input type="radio" name="payment_method" value="gateway" disabled style="margin-right: 1.25rem; width: 20px; height: 20px;">
                        <div style="flex: 1;">
                            <div style="font-weight: 800; color: var(--primary); font-size: 1rem; margin-bottom: 0.25rem;">Online Payment</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted-light); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Coming Soon</div>
                        </div>
                        <span style="font-size: 1.5rem; opacity: 0.5;">⚡</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 1.5rem; font-size: 1.25rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.4);">
                Complete Order 🚀
            </button>
        </form>
    </div>

    <!-- Order Summary -->
    <div style="position: sticky; top: 1.5rem;">
        <div class="card-solid" style="background: var(--bg-light); border: none;">
            <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">Your Order</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem; max-height: 300px; overflow-y: auto; padding-right: 0.5rem;">
                @foreach($cartItems as $item)
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--text-light); font-size: 0.875rem; line-height: 1.4;">{{ $item['product']->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.25rem;">Qty: {{ $item['quantity'] }} × ৳{{ number_format($item['product']->price, 2) }}</div>
                        </div>
                        <div style="font-weight: 800; color: var(--primary); font-size: 0.875rem;">৳{{ number_format($item['subtotal'], 2) }}</div>
                    </div>
                @endforeach
            </div>

            <div style="border-top: 2px dashed var(--border-light); pt-1.5rem; padding-top: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                    <span style="color: var(--text-muted-light);">Subtotal</span>
                    <span style="font-weight: 700; color: var(--primary);">৳{{ number_format($subtotal, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                    <span style="color: var(--text-muted-light);">Shipping Fee</span>
                    <span style="font-weight: 700; color: var(--success);">FREE</span>
                </div>
                <div style="margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-size: 1rem; font-weight: 800; color: var(--primary);">Total</span>
                    <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">৳{{ number_format($subtotal, 2) }}</span>
                </div>
            </div>
            
            <div style="background: rgba(16, 185, 129, 0.1); border-radius: 0.75rem; padding: 1rem; margin-top: 1.5rem; display: flex; gap: 0.75rem; align-items: center;">
                <span style="font-size: 1.25rem;">✨</span>
                <div style="color: var(--success); font-size: 0.8125rem; font-weight: 700;">
                    You will earn cashback points after successful delivery.
                </div>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('cart.index') }}" style="color: var(--text-muted-light); text-decoration: none; font-weight: 700; font-size: 0.8125rem;">
                ← Back to My Bag
            </a>
        </div>
    </div>
</div>

<style>
.payment-option:has(input:checked) {
    border-color: var(--primary) !important;
    background: var(--bg-light);
}
</style>
@endsection
