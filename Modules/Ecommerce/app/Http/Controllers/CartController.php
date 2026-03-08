<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $price = $product->final_price ?? $product->price;
                $cartItems[] = [
                    'product'  => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $price * $details['quantity'],
                ];
                $total += $price * $details['quantity'];
            }
        }

        return view('ecommerce::cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock < 1) {
            return response()->json(['success' => false, 'message' => 'Product out of stock']);
        }

        $cart = session()->get('cart', []);

        // Logic: Cannot mix normal products and packages
        if (count($cart) > 0) {
            $isCartPackage = collect($cart)->contains('type', 'package');
            if ($product->type === 'package' || $isCartPackage) {
                return response()->json(['success' => false, 'message' => 'Cannot mix normal products and packages. Please clear your cart first.']);
            }
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->discount_price ?? $product->price,
                'image' => ($product->images[0] ?? null),
                'type' => $product->type,
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_count', count($cart));

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            session()->put('cart_count', count($cart));
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    public function clear()
    {
        session()->forget('cart');
        session()->forget('cart_count');

        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}
