<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\WalletLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
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
                    'subtotal' => $product->price * $details['quantity']
                ];
                $subtotal += $product->price * $details['quantity'];
            }
        }

        $user = auth()->user();
        $mainWallet = Wallet::where('user_id', $user->id)
            ->where('wallet_type', 'main')
            ->first();

        return view('checkout.index', compact('cartItems', 'subtotal', 'mainWallet'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,cod,gateway',
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $subtotal = 0;
            $cashbackTotal = 0;

            // Calculate totals
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                $subtotal += $product->price * $details['quantity'];
                if ($product->cashback_percentage) {
                    $cashbackTotal += ($product->price * $details['quantity'] * $product->cashback_percentage / 100);
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'total_amount' => $subtotal,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'wallet' ? 'paid' : 'pending',
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'merchant_id' => $product->merchant_id,
                    'quantity' => $details['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $details['quantity'],
                    'cashback_amount' => $product->cashback_percentage ? 
                        ($product->price * $details['quantity'] * $product->cashback_percentage / 100) : 0,
                ]);

                // Reduce stock
                $product->decrement('stock', $details['quantity']);
            }

            // Process payment
            if ($request->payment_method === 'wallet') {
                $mainWallet = Wallet::where('user_id', $user->id)
                    ->where('wallet_type', 'main')
                    ->first();

                if ($mainWallet->balance < $subtotal) {
                    throw new \Exception('Insufficient wallet balance');
                }

                // Deduct from main wallet
                WalletLedger::create([
                    'wallet_id' => $mainWallet->id,
                    'type' => 'debit',
                    'amount' => $subtotal,
                    'description' => 'Order payment: ' . $order->order_number,
                    'reference_type' => 'order',
                    'reference_id' => $order->id,
                ]);

                // Add cashback to cashback wallet
                if ($cashbackTotal > 0) {
                    $cashbackWallet = Wallet::where('user_id', $user->id)
                        ->where('wallet_type', 'cashback')
                        ->first();

                    WalletLedger::create([
                        'wallet_id' => $cashbackWallet->id,
                        'type' => 'credit',
                        'amount' => $cashbackTotal,
                        'description' => 'Cashback from order: ' . $order->order_number,
                        'reference_type' => 'order',
                        'reference_id' => $order->id,
                    ]);
                }
            }

            // Clear cart
            session()->forget('cart');
            session()->forget('cart_count');

            DB::commit();

            // Send order confirmation email
            try {
                \Mail::to($user->email)->send(new \App\Mail\OrderPlaced($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
