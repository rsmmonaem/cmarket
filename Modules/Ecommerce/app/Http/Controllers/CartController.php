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

        // Build response with cart data for mini-cart dropdown
        $cartData = $this->buildCartData($cart);

        return response()->json([
            'success'    => true,
            'message'    => 'Added to cart! 🛒',
            'cart_count' => $cartData['count'],
            'cart_total' => $cartData['total'],
            'cart_items' => $cartData['items'],
        ]);
    }

    /**
     * Return compact cart summary for AJAX mini-cart dropdown.
     */
    public function summary()
    {
        $cart = session()->get('cart', []);
        $data = $this->buildCartData($cart);
        return response()->json($data);
    }

    /**
     * Build normalised cart data array for JSON responses.
     */
    private function buildCartData(array $cart): array
    {
        $items = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product) continue;

            $price    = $product->final_price ?? $product->price;
            $subtotal = $price * $details['quantity'];
            $total   += $subtotal;

            // Resolve image URL
            $images = is_array($product->images)
                ? $product->images
                : (json_decode($product->images, true) ?: []);
            $imageUrl = !empty($images[0])
                ? asset('storage/' . $images[0])
                : asset('images/placeholder.png');

            $items[] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'image'    => $imageUrl,
                'quantity' => $details['quantity'],
                'price'    => $price,
                'subtotal' => $subtotal,
            ];
        }

        return [
            'count' => count($items),
            'total' => $total,
            'items' => $items,
        ];
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
