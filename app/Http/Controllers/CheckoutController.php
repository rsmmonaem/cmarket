<?php

namespace App\Http\Controllers;

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

    public function __construct(WalletService $walletService, PackageActivationService $packageService)
    {
        $this->walletService = $walletService;
        $this->packageService = $packageService;
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

        return view('checkout.index', compact('cartItems', 'subtotal', 'mainWallet'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,cod,gateway',
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string',
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

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $subtotal,
                'subtotal' => $subtotal,
                'cashback_amount' => $cashbackTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'wallet' ? 'paid' : 'pending', // Assume wallet is instant paid
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
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

                if (!$mainWallet || $mainWallet->balance < $subtotal) {
                    throw new \Exception('Insufficient wallet balance');
                }

                $reference = 'ORD-' . $order->order_number;
                
                // Deduct from main wallet
                $mainWallet->debit($subtotal, $reference, 'order_payment', "Payment for Order #{$order->order_number}");

                // Add cashback to cashback wallet
                if ($cashbackTotal > 0) {
                    $this->walletService->creditCashback($user, $cashbackTotal, $reference, "Cashback for Order #{$order->order_number}");
                }

                // If it's a package order and paid, trigger activation
                if ($isPackageOrder) {
                    $this->packageService->activate($order);
                }
            }

            // Clear cart
            session()->forget('cart');
            session()->forget('cart_count');

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        });
    }
}
