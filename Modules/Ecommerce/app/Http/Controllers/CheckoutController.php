<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wallet;
use App\Services\WalletService;
use App\Services\PackageActivationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $walletService;
    protected $packageService;
    protected $commissionService;

    public function __construct(WalletService $walletService, PackageActivationService $packageService, \App\Services\CommissionService $commissionService)
    {
        $this->walletService = $walletService;
        $this->packageService = $packageService;
        $this->commissionService = $commissionService;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->final_price * $details['quantity']
                ];
                $subtotal += $product->final_price * $details['quantity'];
            }
        }

        $user = auth()->user();
        $mainWallet = $user->getWallet('main');

        return view('ecommerce::checkout.index', compact('cartItems', 'subtotal', 'mainWallet'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,cod,gateway',
            'shipping_address' => 'required|string',
            'phone'            => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        return DB::transaction(function () use ($request, $cart) {
            $user = auth()->user();
            $subtotal = 0;
            $cashbackTotal = 0;
            $isPackageOrder = false;

            // Calculate totals and check types
            foreach ($cart as $id => $details) {
                $product = Product::findOrFail($id);
                $subtotal += $product->final_price * $details['quantity'];
                if ($product->cashback_percentage) {
                    $cashbackTotal += ($product->final_price * $details['quantity'] * $product->cashback_percentage / 100);
                }
                if ($product->type === 'package') {
                    $isPackageOrder = true;
                }
            }

            $discount = session('coupon.discount', 0);
            $totalAmount = max(0, $subtotal - $discount);

            $firstProductId = array_key_first($cart);
            $firstProduct = Product::findOrFail($firstProductId);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'merchant_id' => $firstProduct->merchant_id ?? 1,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_amount' => $totalAmount,
                'cashback_amount' => $cashbackTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'wallet' ? 'paid' : 'pending',
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_phone'   => $request->phone,
                'notes' => $request->notes,
                'paid_at' => $request->payment_method === 'wallet' ? now() : null,
            ]);

            // Create order items
            foreach ($cart as $id => $details) {
                $product = Product::findOrFail($id);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $details['quantity'],
                    'price' => $product->final_price,
                    'subtotal' => $product->final_price * $details['quantity'],
                ]);

                // Reduce stock
                if ($product->stock !== -1) { // Assuming -1 or similar means unlimited
                    $product->decrement('stock', $details['quantity']);
                }
            }

            // Process payment
            if ($request->payment_method === 'wallet') {
                $mainWallet = $user->getWallet('main');

                if (!$mainWallet || $mainWallet->balance < $totalAmount) {
                    throw new \Exception('Insufficient wallet balance');
                }

                $reference = $order->order_number;
                
                // Deduct from main wallet
                $mainWallet->debit($totalAmount, $reference, 'order_payment', "Payment for Order #{$order->order_number}");

                // Add cashback to cashback wallet
                if ($cashbackTotal > 0) {
                    $this->walletService->creditCashback($user, $cashbackTotal, $reference, "Cashback for Order #{$order->order_number}");
                }

                // If it's a package order and paid, trigger activation and distribution immediately
                if ($isPackageOrder) {
                    $order->update([
                        'status' => 'delivered',
                        'delivered_at' => now()
                    ]);
                    $this->packageService->activate($order);
                    $this->commissionService->distribute($order);
                }
            }

            // Clear cart & session coupon
            session()->forget('cart');
            session()->forget('cart_count');
            session()->forget('coupon');

            // Send order confirmation email (queued, silent failure)
            try {
                \Illuminate\Support\Facades\Mail::queue(new \App\Mail\OrderPlaced($order));
            } catch (\Exception $e) { /* Mail failed silently */ }

            // Handle affiliate commission if cookie exists
            $affiliateCookie = request()->cookie('cmarket_affiliate');
            if ($affiliateCookie) {
                $affiliateData = json_decode($affiliateCookie, true);
                if ($affiliateData) {
                    $this->commissionService->processAffiliateCommission($order, $affiliateData);
                }
            }

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!')
                ->withoutCookie('cmarket_affiliate');
        });
    }

    /**
     * Apply a coupon code to the cart session
     */
    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $id => $details) {
            $product = \App\Models\Product::find($id);
            if ($product) $subtotal += $product->final_price * $details['quantity'];
        }

        $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))
            ->where('is_active', true)
            ->where(fn($q) => $q->whereNull('start_date')->orWhere('start_date', '<=', now()))
            ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', now()))
            ->first();

        if (!$coupon) {
            return back()->with('coupon_error', 'Invalid or expired coupon code.');
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return back()->with('coupon_error', 'This coupon has reached its usage limit.');
        }

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return back()->with('coupon_error', "Minimum order amount of ৳{$coupon->min_order_amount} required.");
        }

        // Calculate discount
        $discount = $coupon->type === 'percentage'
            ? min($subtotal * $coupon->value / 100, $coupon->max_discount ?? PHP_INT_MAX)
            : min($coupon->value, $subtotal);

        session()->put('coupon', [
            'code'     => $coupon->code,
            'id'       => $coupon->id,
            'discount' => round($discount, 2),
        ]);

        return back()->with('success', "Coupon applied! You save ৳" . number_format($discount, 2));
    }

    /**
     * Remove the applied coupon from session
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('info', 'Coupon removed.');
    }
}

